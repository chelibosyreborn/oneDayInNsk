<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 3/31/2019
 * Time: 2:53 PM
 */

namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;

class UserService {

    const RANKS = [
        '1' => 100,
        '2' => 200,
        '3' => 300,
        '4' => 400,
        '5' => 500,
        '6' => 600,
        '7' => 700,
        '8' => 800
    ];

    private $userRepository;

    /**
     * UserService constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Получить пользователя по токену
     * @param $token
     * @return User|null
     */
    public function getUser(string $token): User
    {
        return $this->userRepository->findOneBy(['token' => $token]);
    }

    /**
     * Сохранить измененного юзера
     * @param $user
     * @return bool
     */
    public function saveUser(User $user): bool
    {
        return $this->userRepository->saveUser($user);
    }

    /**
     * Вход в систему (логин)
     * @param string $login логин пользователя
     * @param string $password хеш-пароль
     * @param int $rnd случайное число
     * @return User|bool
     */
    public function login(string $login, string $password, int $rnd): User
    {
        $user = $this->userRepository->findOneBy(['login' => $login]);
        if ($user) {
            $hash = md5($user->getPassword() . $rnd);
            if ($password === $hash) {
                $token = md5($hash . rand(0, 10000));
                $user->setToken($token);
                $this->userRepository->saveUser($user);
                $user->setPassword('');
                return $user;
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
        $user = $this->userRepository->findOneBy(['token' => $token]);
        if ($user) {
            $user->setToken(null);
            return $this->userRepository->saveUser($user);
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
        if ($login && $password) {
            $user = new User();
            $user->setLogin($login);
            $user->setPassword(md5($login . $password));
            return $this->userRepository->saveUser($user);
        }
        return false;
    }

    /**
     * Изменить количество денег игрока
     * @param string $token
     * @param int $money
     * @return User|bool
     */
    public function setMoney(string $token, int $money): object
    {
        $user = $this->userRepository->findOneBy(['token' => $token]);
        if ($user) {
            $money = $money < 0 ? 0 : $money;
            $user->setMoney($money);
            $this->userRepository->saveUser($user);
            $user->setPassword('');
            return $user;
        }
        return false;
    }

    /**
     * @param User $user
     * @return User|bool|null
     */
    public function setRang(User $user): object
    {
        if ($user->getMoney() >= self::RANKS[$user->getRang() + 1]) {
            $user->setMoney($user->getMoney() - self::RANKS[$user->getRang() + 1]);
            $user->setRang($user->getRang() + 1);
            $this->userRepository->saveUser($user);
            $user->setPassword('');
            return $user;
        }
        return false;
    }

    /**
     * @param string $token
     * @param int $roleId
     * @return User|bool
     */
    public function setRole(string $token, int $roleId): object
    {
        $user = $this->userRepository->findOneBy(['token' => $token]);
        if ($user && $roleId > 0) {
            $user->setRoleId($roleId);
            $this->userRepository->saveUser($user);
            $user->setPassword('');
            return $user;
        }
        return false;
    }

}