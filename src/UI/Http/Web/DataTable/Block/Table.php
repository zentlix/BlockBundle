<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\UI\Http\Web\DataTable\Block;

use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Zentlix\MainBundle\Infrastructure\Share\DataTable\AbstractDataTableType;
use Zentlix\BlockBundle\Domain\Block\Event\Table as TableEvent;
use Zentlix\BlockBundle\Domain\Block\Entity\Block;

class Table extends AbstractDataTableType
{
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable->setName('blocks-datatable');

        $dataTable
            ->add('id', TextColumn::class, ['label' => 'zentlix_main.id', 'visible' => true])
            ->add('title', TwigColumn::class,
                [
                    'template'  => '@BlockBundle/admin/blocks/datatable/title.html.twig',
                    'visible'   => true,
                    'label'     => 'zentlix_main.title'
                ])

            ->add('code', TextColumn::class, [
                'label'   => 'zentlix_main.symbol_code',
                'visible' => true
            ])
            ->add('type', TextColumn::class, [
                'label'   => 'zentlix_main.type',
                'visible' => false
            ])
            ->add('cache_group', TextColumn::class, [
                'label'   => 'zentlix_block.cache_group',
                'visible' => false
            ])
            ->addOrderBy($dataTable->getColumnByName('id'), $dataTable::SORT_DESCENDING)
            ->createAdapter(ORMAdapter::class, ['entity' => Block::class]);

        $this->eventDispatcher->dispatch(new TableEvent($dataTable));
    }
}