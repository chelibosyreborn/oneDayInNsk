<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 3/31/2019
 * Time: 3:50 PM
 */

namespace App\Service;


use App\Repository\QuestRepository;
use App\Repository\UsersQuestsRepository;

class QuestService
{

    private $questRepository = null;

    private $usersQuestsRepository = null;

    /**
     * QuestService constructor.
     * @param QuestRepository $questRepository
     * @param UsersQuestsRepository $usersQuestsRepository
     */
    public function __construct(QuestRepository $questRepository, UsersQuestsRepository $usersQuestsRepository)
    {
        $this->questRepository = $questRepository;
        $this->usersQuestsRepository = $usersQuestsRepository;
    }

    public function getQuestsByRoleId($roleId)
    {
        return $this->questRepository->findBy(['roles_id' => $roleId]);
    }

    public function getQuest($questId)
    {
        return $this->questRepository->find($questId);
    }

    /**
     * @param $questId
     * @param $userId
     * @return object
     */
    public function getUserQuest($questId, $userId)
    {
        return $this->usersQuestsRepository->findBy(['users_id' => $userId, 'quests_id' => $questId])[0];
    }

    public function saveUserQuest($userQuest)
    {
        $this->usersQuestsRepository->save($userQuest);
    }

}