<?php

namespace App\Repository;

use App\Entity\Way;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Way|null find($id, $lockMode = null, $lockVersion = null)
 * @method Way|null findOneBy(array $criteria, array $orderBy = null)
 * @method Way[]    findAll()
 * @method Way[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WayRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Way::class);
    }
}
