<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userRepository = null;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Логин в систему
     * @Route("api/user/login/{login}/{password}/{rnd}")
     * @param string $login логин пользователя
     * @param string $password хеш-пароль
     * @param int $rnd случайное число для формирования хеша
     * @return JsonResponse
     */
    public function index(string $login, string $password, int $rnd): JsonResponse
    {
        $result = $this->userRepository->login($login, $password, $rnd);
        return $this->json([
            'status' => 'ok',
            'data' => $result
        ]);
    }

    /**
     * Выход из системы
     * @Route("api/user/logout/{token}")
     * @param $token
     * @return JsonResponse
     */
    public function logout(string $token): JsonResponse
    {
        $result = $this->userRepository->logout($token);
        return $this->json([
            'status' => 'ok',
            'data' => $result
        ]);
    }

    /**
     * Регистрация
     * @Route("api/user/addUser/{login}/{password}")
     * @param string $login логин пользователя
     * @param string $password пароль пользователя
     * @return JsonResponse
     */
    public function addUser(string $login, string $password): JsonResponse
    {
        $result = $this->userRepository->addUser($login, $password);
        return $this->json([
           'status' => 'ok',
           'data' => $result
        ]);
    }

    /**
     * Изменить количество денег игрока
     * @Route("api/user/setMoney/{token}/{money}")
     * @param string $token токен игра
     * @param int $money количество денег
     * @return JsonResponse
     */
    public function setMoney(string $token, int $money): JsonResponse
    {
        $result = $this->userRepository->setMoney($token, $money);
        return $this->json([
            'status' => 'ok',
            'data' => $result
        ]);
    }

    /**
     * Переместить игрока в другую комнату
     * @Route("api/user/setRoom/{token}/{roomToId}")
     * @param string $token уникальный ключ пользователя
     * @param int $roomToId идентификатор комнаты, в которую нужно перейти
     * @return JsonResponse
     */
    public function setRoom(string $token, int $roomToId): JsonResponse
    {
        $result = $this->userRepository->setRoom($token, $roomToId);
        return $this->json([
            'status' => 'ok',
            'data' => $result
        ]);
    }

    /**
     * Изменить ранг пользователя
     * @Route("api/user/setRang/{token}/{newRang}")
     * @param string $token уникальный ключ пользователя
     * @param int $newRang новый ранг пользователя
     * @return JsonResponse
     */
    public function setRang(string $token, int $newRang): JsonResponse
    {
        $result = $this->userRepository->setRang($token, $newRang);
        return $this->json([
            'status' => 'ok',
            'data' => $result
        ]);
    }

    /**
     * Изменить роль игрока
     * @Route("api/user/setRole/{token}/{roleId}")
     * @param string $token ключ активного игрока
     * @param int $roleId идентификатор роли
     * @return JsonResponse
     */
    public function setRole(string $token, int $roleId): JsonResponse
    {
        $result = $this->userRepository->setRole($token, $roleId);
        return $this->json([
            'status' => 'ok',
            'data' => $result
        ]);
    }

}
