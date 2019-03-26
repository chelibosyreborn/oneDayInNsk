<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    private $roomRepository = null;
    /**
     * RoomController constructor.
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * @Route("/api/room", name="room")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RoomController.php',
        ]);
    }

    /**
     * @Route("/api/room/{id}")
     * @param Int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getRoom(int $id) {
        $result = $this->roomRepository->getRoom($id);
        return $this->json([
            'status' => 'ok',
            'data' => $result->jsonSerialize()
        ]);
    }
}
