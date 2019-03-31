<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use App\Service\MainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController {

    private $service = null;

    /**
     * RoomController constructor.
     * @param MainService $service
     */
    public function __construct(MainService $service) {
        $this->service = $service;
    }

    /**
     * @Route("/api/room/{id}")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index($id) {
        $result = $this->service->getRoom($id);
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
