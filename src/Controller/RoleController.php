<?php

namespace App\Controller;

use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

class RoleController extends AbstractController
{

    private $roleRepository = null;

    /**
     * RoleController constructor.
     * @param null $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @Route("/role", name="role")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RoleController.php',
        ]);
    }

    /**
     * @Route("/getRoles")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getRoles() {
        $roles = $this->roleRepository->findAll();
        $result = [];
        for ($i = 0; $i < count($roles); $i++) {
            $result[] = $roles[$i]->jsonSerialize();
        }
        return $this->json([
            'message' => $result
        ]);
    }



}
