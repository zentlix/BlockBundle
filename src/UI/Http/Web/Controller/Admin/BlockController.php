<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Zentlix\MainBundle\UI\Http\Web\Controller\Admin\ResourceController;
use Zentlix\BlockBundle\Application\Command\Block\CreateCommand;
use Zentlix\BlockBundle\Application\Command\Block\UpdateCommand;
use Zentlix\BlockBundle\Application\Command\Block\DeleteCommand;
use Zentlix\BlockBundle\Application\Query\Block\DataTableQuery;
use Zentlix\BlockBundle\Domain\Block\Entity\Block;
use Zentlix\BlockBundle\UI\Http\Web\DataTable\Block\Table;
use Zentlix\BlockBundle\UI\Http\Web\Form\Block\CreateForm;
use Zentlix\BlockBundle\UI\Http\Web\Form\Block\UpdateForm;

class BlockController extends ResourceController
{
    public static $createSuccessMessage = 'zentlix_block.create.success';
    public static $updateSuccessMessage = 'zentlix_block.update.success';
    public static $deleteSuccessMessage = 'zentlix_block.delete.success';
    public static $redirectAfterAction  = 'admin.block.list';

    public function index(Request $request): Response
    {
        return $this->listResource(new DataTableQuery(Table::class), $request);
    }

    public function create(Request $request): Response
    {
        return $this->createResource(new CreateCommand($request), CreateForm::class, $request);
    }

    public function update(Block $block, Request $request): Response
    {
        return $this->updateResource(new UpdateCommand($block), UpdateForm::class, $request);
    }

    public function delete(Block $block): Response
    {
        return $this->deleteResource(new DeleteCommand($block));
    }
}