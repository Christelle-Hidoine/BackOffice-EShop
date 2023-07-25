<?php

namespace App\Models;

abstract class CoreModel
{
    abstract static function find($id);
    abstract static function findAll();
    abstract function insert();
    abstract function update();
    abstract function delete();

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * Method to insert in DB if there is an Id, if not = update
     *
     */
    public function save()
    {
      if($this->id)
      {
        return $this->update();
      }
      else
      {
        return $this->insert();
      }
    }
}