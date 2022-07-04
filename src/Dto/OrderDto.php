<?php

namespace App\Dto;

class OrderDto
{
    private int $id;
    private int $volume;
    private int $weight;

    /**
     * @param $id
     * @param $volume
     * @param $weight
     */
    public function __construct($id, $volume, $weight)
    {
        $this->id = $id;
        $this->volume = $volume;
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume): void
    {
        $this->volume = $volume;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }


}