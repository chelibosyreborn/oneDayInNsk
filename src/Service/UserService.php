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
    private $userRepository;

    /**
     * UserService constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Получить пользователя по токену
     * @param $token
     * @return User|null
     */
    public function getUser($token) {
        return $this->userRepository->findOneBy(['token' => $token]);
    }

    /**
     * Сохранить измененного юзера
     * @param $user
     * @return bool
     */
    public function saveUser($user) {
        return $this->userRepository->saveUser($user);
    }

    /**
     * Вход в систему (логин)
     * @param string $login логин пользователя
     * @param string $password хеш-пароль
     * @param int $rnd случайное число
     * @return User|bool
     */
    public function login($login, $password, $rnd) {
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
    public function logout($token) {
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
    public function addUser($login, $password) {
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
    public function setMoney($token, $money) {
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
     * @param string $token
     * @param int $newRang
     * @return User|bool|null
     */
    public function setRang($token, $newRang) {
        $user = $this->userRepository->findOneBy(['token' => $token]);
        if ($user && $newRang >= 0) {
            $user->setRang($newRang);
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
    public function setRole($token, $roleId) {
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