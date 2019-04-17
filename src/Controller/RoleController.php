<?php

namespace App\Controller;

use App\Repository\RoleRepository;
use App\Service\MainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

class RoleController extends AbstractController {

    private $service = null;

    /**
     * RoleController constructor.
     * @param MainService $service
     */
    public function __construct(MainService $service)
    {
        $this->service= $service;
    }

    /**
     * @Route("api/role")
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = $this->service->getRoles();
        $result = [];
        for ($i = 0; $i < count($roles); $i++) {
            $result[] = $roles[$i]->jsonSerialize();
        }
        return $this->json([
            'message' => $result
        ]);
    }

}
