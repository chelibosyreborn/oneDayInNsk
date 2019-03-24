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
     * Вход в систему (логин)
     * @param string $login логин пользователя
     * @param string $password хеш-пароль
     * @param int $rnd случайное число
     * @return User|bool
     */
    public function login(string $login, string $password, int $rnd)
    {
        $user = $this->findOneBy(['login' => $login]);
        if ($user)
        {
            $hash = md5($user->getPassword() . $rnd);
            if ($password === $hash)
            {
                $entityManager = $this->getEntityManager();
                $token = md5($hash . rand(0, 10000));
                $user->setToken($token);
                try
                {
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $user;
                } catch (OptimisticLockException $e) {}
                catch (ORMException $e) {}
            }
        }
        return false;
    }

    /**
     * Выход из системы (логаут)
     * @param string $token уникальный ключ активного пользователя
     * @return bool
     */
    public function logout(string $token): bool
    {
        $user = $this->findOneBy(['token' => $token]);
        if ($user)
        {
            $entityManager = $this->getEntityManager();
            $user->setToken(null);
            try
            {
                $entityManager->persist($user);
                $entityManager->flush();
                return true;
            } catch (OptimisticLockException $e) {}
            catch (ORMException $e) {}
        }
        return false;
    }

    /**
     * Добавить пользователя
     * @param string $login логин пользователя
     * @param string $password пароль пользователя
     * @return bool
     */
    public function addUser(string $login, string $password): bool
    {
        if ($login && $password)
        {
            $entityManager = $this->getEntityManager();
            $user = new User();
            $user->setLogin($login);
            $user->setPassword(md5($login . $password));
            try
            {
                $entityManager->persist($user);
                $entityManager->flush();
                return true;
            } catch (OptimisticLockException $e) {}
            catch (ORMException $e) {}
            catch (UniqueConstraintViolationException $e) {}
        }
        return false;
    }

    /**
     * Изменить количество денег игрока
     * @param string $token
     * @param int $money
     * @return User|bool
     */
    public function setMoney(string $token, int $money)
    {
        $user = $this->findOneBy(['token' => $token]);
        if ($user)
        {
            $entityManager = $this->getEntityManager();
            $money = $money < 0 ? 0 : $money;
            $user->setMoney($money);
            try
            {
                $entityManager->persist($user);
                $entityManager->flush();
                return $user;
            } catch (OptimisticLockException $e) {}
            catch (ORMException $e) {}
        }
        return false;
    }

    /**
     * Переместить игрока в другую комнату
     * @param string $token
     * @param int $roomToId
     * @return User|bool
     */
    public function setRoom(string $token, int $roomToId)
    {
        $user = $this->findOneBy(['token' => $token]);
        if ($user && $roomToId > 0)
        {
            $entityManager = $this->getEntityManager();
            // Найти комнату с идентификатором roomToId.
            //...
            // Проверить наличие пути между комнатой юзера и новой комнатой
            // ...
            // Переместить юзера в комнату
            $user->setRoomId($roomToId);
            try
            {
                $entityManager->persist($user);
                $entityManager->flush();
                return $user;
            } catch (OptimisticLockException $e) {}
            catch (ORMException $e) {}
        }
        return false;
    }

    /**
     * @param string $token
     * @param int $newRang
     * @return User|bool|null
     */
    public function setRang(string $token, int $newRang)
    {
        $user = $this->findOneBy(['token' => $token]);
        if ($user && $newRang >= 0)
        {
            $entityManager = $this->getEntityManager();
            $user->setRang($newRang);
            try
            {
                $entityManager->persist($user);
                $entityManager->flush();
                return $user;
            } catch (OptimisticLockException $e) {}
            catch (ORMException $e) {}
        }
        return false;
    }

    /**
     * @param string $token
     * @param int $roleId
     * @return User|bool
     */
    public function setRole(string $token, int $roleId)
    {
        $user = $this->findOneBy(['token' => $token]);
        if ($user && $roleId > 0)
        {
            $entityManager = $this->getEntityManager();
            $user->setRoleId($roleId);
            try
            {
                $entityManager->persist($user);
                $entityManager->flush();
                return $user;
            } catch (OptimisticLockException $e) {}
            catch (ORMException $e) {}
        }
        return false;
    }

}
