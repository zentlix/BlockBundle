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

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;
use Zentlix\BlockBundle\Domain\Block\Event\AfterDelete;
use Zentlix\BlockBundle\Domain\Block\Event\BeforeDelete;

class DeleteHandler implements CommandHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(DeleteCommand $command): void
    {
        $blockId = $command->block->getId();

        $this->eventDispatcher->dispatch(new BeforeDelete($command));

        Cache::clear('zentlix_block_block_' . $command->block->getCacheGroup());

        $this->entityManager->remove($command->block);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterDelete($blockId));
    }
}