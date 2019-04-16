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
    public function index($login, $password, $rnd) {
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
    public function logout($token) {
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
    public function addUser($login, $password) {
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
    public function setMoney($token, $money) {
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
    public function setRoom($token, $roomToId) {
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
     * @Route("api/user/setRang/{token}/{newRang}")
     * @param string $token уникальный ключ пользователя
     * @param int $newRang новый ранг пользователя
     * @return JsonResponse
     */
    public function setRang($token, $newRang) {
        $result = $this->service->setRang($token, $newRang);
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
    public function setRole($token, $roleId) {
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
