<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Type extends CoreModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * Method to retrieve data from type entity according to his id
     *
     * @param int $typeId type id
     * @return Type
     */
    public static function find($id)
    {
      $pdo = Database::getPDO();
      $sql = 'SELECT * FROM `type` WHERE `id` =' . $id;

      $pdoStatement = $pdo->query($sql);

      return $pdoStatement->fetchObject(Type::class);
    }

    /**
     * Method to retrieve all data from type
     *
     * @return Type[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `type`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Type::class);

        return $results;
    }

    /**
     * Method to add a type
     *
     * @return bool
     */
    public function insert()
    {
      $pdo = Database::getPDO();

      $sql = "INSERT INTO `type` (`name`)
              VALUES (:name)";

      $pdoStatement = $pdo->prepare($sql);
      $pdoStatement->bindValue(":name",        $this->name,        PDO::PARAM_STR);
      $pdoStatement->execute();

      if($pdoStatement->rowCount() === 1)
      {
        $this->id = $pdo->lastInsertId();
        return true;
      }
      else
      {
        return false;
      }
    }

    /**
     * Method to update a type
     *
     * @return bool
     */
    public function update()
    {
      $pdo = Database::getPDO();

      $sql = "UPDATE `type` SET 
                `name`       = :name,
                `updated_at` = NOW()
              WHERE `id` = :id";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->bindValue(":name",       $this->name,       PDO::PARAM_STR);
      $pdoStatement->bindValue(":id",         $this->id,         PDO::PARAM_INT);

      $pdoStatement->execute();

      if($pdoStatement->rowCount() === 1)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    
    /**
     * Method to delete a type
     *
     * @return bool
     */
    public function delete()
    {
      $pdo = Database::getPDO();

      $sql = "DELETE FROM `type` WHERE `id` = :id";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->execute([
        ":id" => $this->id
      ]);

      return $pdoStatement->rowCount() === 1;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}