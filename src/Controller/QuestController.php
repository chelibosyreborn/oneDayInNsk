<?php

namespace App\Controller;

use App\Repository\QuestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestController extends AbstractController
{

    private $questRepository = null;

    /**
     * QuestController constructor.
     * @param null $questRepository
     */
    public function __construct(QuestRepository $questRepository)
    {
        $this->questRepository = $questRepository;
    }

    /**
     * @Route("/quest", name="quest")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/QuestController.php',
        ]);
    }

    /**
     * @Route("/getQuests")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getQuests() {
        $quests = $this->questRepository->findAll();
        $result = [];
        for ($i = 0; $i < count($quests); $i++) {
            $result[] = $quests[$i]->jsonSerialize();
        }
        return $this->json([
            'message' => $result
        ]);
    }
}
