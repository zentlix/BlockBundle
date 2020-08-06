<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\Application\Command\Block;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Application\Command\UpdateCommandInterface;
use Zentlix\BlockBundle\Domain\Block\Entity\Block;

class UpdateCommand extends Command implements UpdateCommandInterface
{
    /** @Constraints\NotBlank() */
    public ?string $code;

    public function __construct(Block $block, Request $request = null)
    {
        $this->entity = $block;

        $this->title = isset($request) ?
            $request->request->get('title', $block->getTitle()) : $block->getTitle();
        $this->code = isset($request) ?
            $request->request->get('code', $block->getCode()) : $block->getCode();
        $this->description = isset($request) ?
            $request->request->get('description', $block->getDescription()) : $block->getDescription();
        $this->content = isset($request) ?
            $request->request->get('content', $block->getContent()) : $block->getContent();
        $this->type = isset($request) ?
            (string) $request->request->get('type', $block->getType()) : $block->getType();
        $this->cache_group = isset($request) ?
            (string) $request->request->get('cache_group', $block->getCacheGroup()) : $block->getCacheGroup();
    }

    public function getEntity(): Block
    {
        return $this->entity;
    }

    public function update(string $content = null): void
    {
        $this->content = trim($content);
    }

    public function getVisualEditedContent(): ?string
    {
        return $this->content;
    }
}