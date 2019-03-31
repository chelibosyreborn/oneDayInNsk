<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 3/31/2019
 * Time: 3:50 PM
 */

namespace App\Service;


use App\Repository\QuestRepository;

class QuestService {

    private $questRepository = null;

    /**
     * QuestService constructor.
     * @param QuestRepository $questRepository
     */
    public function __construct(QuestRepository $questRepository) {
        $this->questRepository = $questRepository;
    }

    public function getQuestsByRoleId($roleId) {
        return $this->questRepository->findBy(['roles_id' => $roleId]);
    }

}