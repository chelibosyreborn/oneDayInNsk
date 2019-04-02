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
     * @Route("api/quest/startQuest/{token}/{$questsId}")
     * @param string $token токен игра
     * @param int $quests_id ид квеста
     * @return JsonResponse
     */
    public function startQuest($token, $questsId) {
        $result = $this->service->startQuest($token, $questsId);
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
