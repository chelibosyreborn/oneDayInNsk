<?php

namespace App\Controller;

use App\Service\MainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $service = null;

    /**
     * UserController constructor.
     * @param MainService $service
     */
    public function __construct(MainService $service)
    {
        $this->service = $service;
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
        $result = $this->service->login($login, $password, $rnd);
        if ($result) {
            return $this->json([
                'status' => 'ok',
                'data' => $result->jsonSerialize()
            ]);
        }
        return $this->json([
            'status' => 'error',
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
        $result = $this->service->logout($token);
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
        $result = $this->service->addUser($login, $password);
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
        $result = $this->service->setMoney($token, $money);
        if ($result) {
            return $this->json([
                'status' => 'ok',
                'data' => $result->jsonSerialize()
            ]);
        }
        return $this->json([
            'status' => 'error',
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
        $result = $this->service->setRoom($token, $roomToId);
        if ($result) {
            return $this->json([
                'status' => 'ok',
                'data' => $result->jsonSerialize()
            ]);
        }
        return $this->json([
            'status' => 'error',
            'data' => $result
        ]);
    }

    /**
     * Изменить ранг пользователя
     * @Route("api/user/setRang/{token}")
     * @param string $token уникальный ключ пользователя
     * @return JsonResponse
     */
    public function setRang(string $token): JsonResponse
    {
        $result = $this->service->setRang($token);
        if ($result) {
            return $this->json([
                'status' => 'ok',
                'data' => $result->jsonSerialize()
            ]);
        }
        return $this->json([
            'status' => 'error',
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
        $result = $this->service->setRole($token, $roleId);
        if ($result) {
            return $this->json([
                'status' => 'ok',
                'data' => $result->jsonSerialize()
            ]);
        }
        return $this->json([
            'status' => 'error',
            'data' => $result
        ]);
    }

}
