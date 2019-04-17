<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 3/31/2019
 * Time: 3:47 PM
 */

namespace App\Service;


use App\Entity\Role;
use App\Repository\RoleRepository;

class RoleService {

    private $roleRepository = null;

    /**
     * RoleService constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Получить все роли
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->roleRepository->findAll();
    }


}