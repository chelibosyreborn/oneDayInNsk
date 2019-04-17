<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 3/31/2019
 * Time: 3:16 PM
 */

namespace App\Service;


use App\Entity\Room;
use App\Repository\RoomRepository;

class RoomService {

    private $roomRepository = null;

    /**
     * RoomService constructor.
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * Получить комнату по идентификатору
     * @param int $id идентификатор комнаты
     * @return Room|null
     */
    public function getRoom($id): Room
    {
        return $this->roomRepository->find($id);
    }

}