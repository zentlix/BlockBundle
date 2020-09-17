<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\Domain\Block\Specification;

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\BlockBundle\Domain\Block\Repository\BlockRepository;

final class UniqueCodeSpecification
{
    private BlockRepository $blockRepository;
    private TranslatorInterface $translator;

    public function __construct(BlockRepository $blockRepository, TranslatorInterface $translator)
    {
        $this->blockRepository = $blockRepository;
        $this->translator = $translator;
    }

    public function isUnique(string $code): void
    {
        if($this->blockRepository->hasByCode($code)) {
            throw new NonUniqueResultException(sprintf($this->translator->trans('zentlix_block.already_exist'), $code));
        }
    }

    public function __invoke(string $code): void
    {
        $this->isUnique($code);
    }
}