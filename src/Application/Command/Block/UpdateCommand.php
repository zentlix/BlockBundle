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

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Infrastructure\Share\Bus\UpdateCommandInterface;
use Zentlix\BlockBundle\Domain\Block\Entity\Block;

class UpdateCommand extends Command implements UpdateCommandInterface
{
    /** @Constraints\NotBlank() */
    public ?string $code;

    public function __construct(Block $block)
    {
        $this->entity = $block;

        $this->title       = $block->getTitle();
        $this->code        = $block->getCode();
        $this->description = $block->getDescription();
        $this->content     = $block->getContent();
        $this->type        = $block->getType();
        $this->cache_group = $block->getCacheGroup();
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