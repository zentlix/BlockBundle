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
use Zentlix\MainBundle\Application\Command\DynamicPropertyCommand;
use Zentlix\MainBundle\Application\Command\VisualEditorCommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\BlockBundle\Domain\Block\Entity\Block;

class Command extends DynamicPropertyCommand implements CommandInterface, VisualEditorCommandInterface
{
    /** @Constraints\NotBlank() */
    public ?string $title;

    public ?string $code;
    public ?string $description;
    public ?string $content;
    public string $cache_group = 'default';

    /** @Constraints\NotBlank() */
    public string $type = 'html';
    protected ?Block $entity;

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