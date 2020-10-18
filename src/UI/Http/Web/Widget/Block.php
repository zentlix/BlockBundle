<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\UI\Http\Web\Widget;

use Twig\Extension\AbstractExtension;
use Twig\Environment;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\VisualEditor\Service\VisualEditor;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;
use Zentlix\BlockBundle\Domain\Block\Entity\Block as BlockEntity;
use Zentlix\BlockBundle\Domain\Block\Repository\BlockRepository;
use Zentlix\BlockBundle\UI\Http\Web\Form\Block\VisualEditForm;

class Block extends AbstractExtension
{
    private BlockRepository $blockRepository;
    private VisualEditor $visualEditor;

    public function __construct(BlockRepository $blockRepository, VisualEditor $visualEditor)
    {
        $this->blockRepository = $blockRepository;
        $this->visualEditor = $visualEditor;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('block_widget', [$this, 'getBlock'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function getBlock(Environment $twig, string $code, string $cacheGroup = 'default'): ?string
    {
        $block = $this->getEntity($code, $cacheGroup);

        if($block === null) {
            return null;
        }

        if($this->visualEditor->isEnabled() === false) {
            return $block->getContent();
        }

        return $twig->render('@BlockBundle/widgets/block.html.twig', [
            'block' => $block,
            'class' => BlockEntity::class,
            'form'  => VisualEditForm::class
        ]);
    }

    private function getEntity(string $code, string $cacheGroup): ?BlockEntity
    {
        $cacheResult = Cache::get('zentlix_block_block_' . $cacheGroup);
        if(is_array($cacheResult)) {
            return isset($cacheResult[$code]) ? $cacheResult[$code] : null;
        }

        $blocks = $this->blockRepository->findByCacheGroup($cacheGroup);

        $cacheResult = [];
        foreach ($blocks as $block) {
            $cacheResult[$block->getCode()] = $block;
        }

        Cache::set($cacheResult, 'zentlix_block_block_' . $cacheGroup);

        return isset($cacheResult[$code]) ? $cacheResult[$code] : null;
    }
}