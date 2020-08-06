<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\Domain\Block\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zentlix\MainBundle\Domain\Shared\Repository\CodeTrait;
use Zentlix\BlockBundle\Domain\Block\Entity\Block;

/**
 * @method Block|null find($id, $lockMode = null, $lockVersion = null)
 * @method Block|null findOneBy(array $criteria, array $orderBy = null)
 * @method Block|null findOneByCode(string $code)
 * @method Block      getOneByCode(string $code)
 * @method Block[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlockRepository extends ServiceEntityRepository
{
    use CodeTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Block::class);
    }

    public function findByCacheGroup(string $cacheGroup, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->findBy(['cache_group' => $cacheGroup], $orderBy, $limit, $offset);
    }
}