<?php

namespace App\Controller;

use App\Service\MainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestController extends AbstractController
{

    private $service = null;

    /**
     * QuestController constructor.
     * @param MainService $service
     */
    public function __construct(MainService $service)
    {
        $this->service = $service;
    }


    /**
     * @Route("api/quest/{token}")
     * @param $token
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index($token) {
        $result = $this->service->getQuests($token);
        return $this->json([
            'status' => $result ? 'ok' : 'error',
            'message' => $result
        ]);
    }

    /**
     * Изменить прогресс выполнения квеста
     * @Route("api/quest/changeStatus/{token}/{questsId}")
     * @param string $token токен игра
     * @param $questsId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function finishQuest($token, $questsId) {
        $result = $this->service->finishQuest($token, $questsId);
        if ($result) {
            return $this->json([
                'status' => 'ok',
                'data' => $result
            ]);
        }
        return $this->json([
            'status' => 'error',
            'data' => $result
        ]);
    }

}
