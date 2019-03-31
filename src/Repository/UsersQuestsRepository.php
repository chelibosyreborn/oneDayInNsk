<?php

namespace App\Repository;

use App\Entity\UsersQuests;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UsersQuests|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersQuests|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersQuests[]    findAll()
 * @method UsersQuests[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersQuestsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UsersQuests::class);
    }
}
