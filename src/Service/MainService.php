<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 3/31/2019
 * Time: 3:17 PM
 */

namespace App\Service;


use App\Entity\Role;
use App\Entity\Room;
use App\Entity\User;

class MainService {

    private $roomService = null;
    private $questService = null;
    private $roleService = null;
    private $wayService = null;
    private $userService = null;

    /**
     * MainService constructor.
     * @param QuestService $questService
     * @param RoleService $roleService
     * @param WayService $wayService
     * @param RoomService $roomService
     * @param UserService $userService
     */
    public function __construct(QuestService $questService, RoleService $roleService, WayService $wayService, RoomService $roomService, UserService $userService)
    {
        $this->roomService = $roomService;
        $this->questService = $questService;
        $this->roleService = $roleService;
        $this->wayService = $wayService;
        $this->userService = $userService;
    }

    /**
     * Вход в систему (логин)
     * @param string $login логин пользователя
     * @param string $password хеш-пароль
     * @param int $rnd случайное число
     * @return User|bool
     */
    public function login(string $login, string $password, int $rnd): object
    {
        if ($login && $password && $rnd) {
            return $this->userService->login($login, $password, $rnd);
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
        if ($token) {
            return $this->userService->logout($token);
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
            return $this->userService->addUser($login, $password);
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
        if ($token && $money) {
            return $this->userService->setMoney($token, $money);
        }
        return false;
    }

    /**
     * Переместить игрока в другую комнату
     * @param string $token
     * @param int $roomToId
     * @return User|bool
     */
    public function setRoom(string $token, int $roomToId): object
    {
        if ($token && $roomToId) {
            $user = $this->userService->getUser($token);
            if ($user) {
                // Найти комнату с идентификатором roomToId.
                $room = $this->roomService->getRoom($roomToId);
                if ($room) {
                    // Проверить наличие пути между комнатой юзера и новой комнатой
                    $isWayExists = $this->wayService->getWay($user->getRoomId(), $roomToId);
                    // Переместить юзера в комнату
                    if ($isWayExists) {
                        $user->setRoomId($roomToId);
                        $this->userService->saveUser($user);
                        $user->setPassword('');
                        return $user;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param string $token
     * @return User|bool|null
     */
    public function setRang(string $token): object
    {
        if ($token) {
            $user = $this->userService->getUser($token);
            if ($user) {
                return $this->userService->setRang($user);
            }
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
        if ($token && $roleId) {
            return $this->userService->setRole($token, $roleId);
        }
        return false;
    }

    /**
     * Получить комнату по идентификатору
     * @param int $id идентификатор комнаты
     * @return Room|bool|null
     */
    public function getRoom(int $id): object
    {
        if ($id) {
            return $this->roomService->getRoom($id);
        }
        return false;
    }

    /**
     * Получить все роли
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->roleService->getRoles();
    }

    /**
     * Получить все задания для определенного игрока
     * @param string $token токен игрока
     * @return array|bool
     */
    public function getQuests(string $token): array
    {
        if ($token) {
            $user = $this->userService->getUser($token);
            if ($user) {
                $quests = $this->questService->getQuestsByRoleId($user->getRoleId());
                $result = [];
                for ($i = 0; $i < count($quests); $i++) {
                    $result[] = $quests[$i]->jsonSerialize();
                }
                return $result;
            }
        }
        return false;
    }

    /**
     * Закончить квест
     * @param $token
     * @param $questId
     * @return bool
     */
    public function finishQuest(string $token, int $questId): bool
    {
        if ($token && $questId) {
            //взять юзера
            $user = $this->userService->getUser($token);
            if ($user) {
                //взять квест
                $quest = $this->questService->getQuest($questId);
                //проверить квест
                if ($quest) {
                    //проверить, может ли этот юзер взять этот квест
                    if ($user->getRoleId() === $quest->getRolesId()) {
                        //Поменять прогресс выполнения квеста
                        $userQuest = $this->questService->getUserQuest($questId, $user->getId());
                        if ($userQuest) {
                            $userQuest->setProgress("Выполнено");
                            $this->questService->saveUserQuest($userQuest);
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

}