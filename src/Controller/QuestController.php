<?php

namespace App\Controller;

use App\Repository\QuestRepository;
use App\Service\MainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @return JsonResponse
     */
    public function index(string $token): JsonResponse
    {
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
     * @param int $questsId
     * @return JsonResponse
     */
    public function finishQuest(string $token, int $questsId): JsonResponse
    {
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
