<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Сохранить измененного пользователя
     * @param User $user измененный пользователь
     * @return bool результат сохранения
     */
    public function saveUser(User $user): bool
    {
        $entityManager = $this->getEntityManager();
        try {
            $entityManager->persist($user);
            $entityManager->flush();
            return true;
        } catch (OptimisticLockException $e) {}
        catch (ORMException $e) {}
        catch (UniqueConstraintViolationException $e) {}
        return false;
    }

}
