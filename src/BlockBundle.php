<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Zentlix\MainBundle\ZentlixBundleInterface;
use Zentlix\MainBundle\ZentlixBundleTrait;
use Zentlix\BlockBundle\Application\Command;
use Zentlix\BlockBundle\Application\Query;

class BlockBundle extends Bundle implements ZentlixBundleInterface
{
    use ZentlixBundleTrait;

    public function getTitle(): string
    {
        return 'zentlix_block.blocks';
    }

    public function getVersion(): string
    {
        return '0.1.1';
    }

    public function getDeveloper(): array
    {
        return ['name' => 'Zentlix', 'url' => 'https://zentlix.io'];
    }

    public function getDescription(): string
    {
        return 'zentlix_block.bundle_description';
    }

    public function configureRights(): array
    {
        return [
            Query\Block\DataTableQuery::class  => 'zentlix_block.view_blocks',
            Command\Block\CreateCommand::class => 'zentlix_block.create.process',
            Command\Block\UpdateCommand::class => 'zentlix_block.update.process',
            Command\Block\DeleteCommand::class => 'zentlix_block.delete.process',
        ];
    }
}