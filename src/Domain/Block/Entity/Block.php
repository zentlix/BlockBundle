<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\Domain\Block\Entity;

use Doctrine\ORM\Mapping;
use Gedmo\Mapping\Annotation\Slug;
use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\BlockBundle\Application\Command\Block\CreateCommand;
use Zentlix\BlockBundle\Application\Command\Block\UpdateCommand;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\BlockBundle\Domain\Block\Repository\BlockRepository")
 * @Mapping\Table(name="zentlix_block_blocks", uniqueConstraints={
 *     @Mapping\UniqueConstraint(columns={"code"})
 * })
 */
class Block implements Eventable
{
    public const HTML_TYPE = 'html';
    public const RAW_TYPE = 'raw';

    /**
     * @Mapping\Id()
     * @Mapping\GeneratedValue()
     * @Mapping\Column(type="integer")
     */
    private $id;

    /** @Mapping\Column(type="string", length=255) */
    private $title;

    /**
     * @Slug(fields={"title"}, updatable=false, unique=true)
     * @Mapping\Column(type="string", length=64)
     */
    private $code;

    /** @Mapping\Column(type="string", length=255, nullable=true) */
    private $description;

    /** @Mapping\Column(type="text", nullable=true) */
    private $content;

    /** @Mapping\Column(type="string", length=64, options={"default": "default"}) */
    private $cache_group;

    /** @Mapping\Column(type="string", length=64, options={"default": "html"}) */
    private $type;

    public function __construct(CreateCommand $command)
    {
        $this->setValuesFromCommands($command);
    }

    public function update(UpdateCommand $command)
    {
        $this->setValuesFromCommands($command);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCacheGroup(): string
    {
        return $this->cache_group;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isHTML()
    {
        return $this->type === self::HTML_TYPE;
    }

    public function isCodeEqual(string $code): bool
    {
        return $code === $this->code;
    }

    /**
     * @param CreateCommand|UpdateCommand $command
     */
    private function setValuesFromCommands($command): void
    {
        $this->title       = $command->title;
        $this->code        = $command->code;
        $this->description = $command->description;
        $this->content     = $command->content;
        $this->cache_group = $command->cache_group;
        $this->type        = $command->type;
    }
}