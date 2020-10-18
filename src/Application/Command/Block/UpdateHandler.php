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
use Zentlix\BlockBundle\Domain\Block\Event\BeforeUpdate;
use Zentlix\BlockBundle\Domain\Block\Event\AfterUpdate;
use Zentlix\BlockBundle\Domain\Block\Specification\UniqueCodeSpecification;

class UpdateHandler implements CommandHandlerInterface
{
    private UniqueCodeSpecification $uniqueCodeSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                UniqueCodeSpecification $uniqueCodeSpecification)
    {
        $this->uniqueCodeSpecification = $uniqueCodeSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(UpdateCommand $command): void
    {
        $block = $command->getEntity();

        if(!$block->isCodeEqual($command->code)) {
            $this->uniqueCodeSpecification->isUnique($command->code);
        }

        $this->eventDispatcher->dispatch(new BeforeUpdate($command));

        $block->update($command);

        $this->entityManager->flush();

        Cache::clear('zentlix_block_block_' . $block->getCacheGroup());

        $this->eventDispatcher->dispatch(new AfterUpdate($block, $command));
    }
}