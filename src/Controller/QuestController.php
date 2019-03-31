<?php

namespace App\Controller;

use App\Repository\QuestRepository;
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
}
