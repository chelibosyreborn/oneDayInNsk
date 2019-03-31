<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WayRepository")
 */
class Way
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_from;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_to;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFrom(): ?int
    {
        return $this->id_from;
    }

    public function setIdFrom(int $id_from): self
    {
        $this->id_from = $id_from;

        return $this;
    }

    public function getIdTo(): ?int
    {
        return $this->id_to;
    }

    public function setIdTo(int $id_to): self
    {
        $this->id_to = $id_to;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
            'idFrom' => $this->getIdFrom(),
            'idTo' => $this->getIdTo()
        );
    }
}
