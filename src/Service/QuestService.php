<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 3/31/2019
 * Time: 3:50 PM
 */

namespace App\Service;


use App\Entity\Quest;
use App\Entity\UsersQuests;
use App\Repository\QuestRepository;
use App\Repository\UsersQuestsRepository;

class QuestService {

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

    /**
     * Получить все квесты по идентификатору роли
     * @param $roleId
     * @return array
     */
    public function getQuestsByRoleId(int $roleId): array
    {
        return $this->questRepository->findBy(['roles_id' => $roleId]);
    }

    /**
     * Получить квест по идентификатору
     * @param $questId
     * @return Quest|null
     */
    public function getQuest(int $questId): Quest
    {
        return $this->questRepository->find($questId);
    }

    /**
     * Получить квест пользователя
     * @param int $questId
     * @param int $userId
     * @return UsersQuests
     */
    public function getUserQuest(int $questId, int $userId): UsersQuests
    {
        return $this->usersQuestsRepository->findOneBy(['users_id' => $userId, 'quests_id' => $questId]);
    }

    /**
     * Сохранить новый статус квеста пользователя
     * @param UsersQuests $userQuest
     * @return bool
     */
    public function saveUserQuest(UsersQuests $userQuest): bool
    {
        return $this->usersQuestsRepository->save($userQuest);
    }

}