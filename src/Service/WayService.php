<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 3/31/2019
 * Time: 3:27 PM
 */

namespace App\Service;


use App\Repository\WayRepository;

class WayService {

    private $wayRepository = null;

    /**
     * WayService constructor.
     * @param WayRepository $wayRepository
     */
    public function __construct(WayRepository $wayRepository)
    {
        $this->wayRepository = $wayRepository;
    }

    /**
     * Получить путь между двумя комнатами
     * @param int $idFrom идентификатор исходной комнаты
     * @param int $idTo идентификатор входной комнаты
     * @return \App\Entity\Way|null
     */
    public function getWay($idFrom, $idTo) {
        return $this->wayRepository->findOneBy(['id_from' => $idFrom, 'id_to' => $idTo]);
    }


}