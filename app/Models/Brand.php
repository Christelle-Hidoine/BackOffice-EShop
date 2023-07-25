<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Brand extends CoreModel
{
  /**
   * @var string
   */
  private $name;

  /**
   * Method to retrieve data from one brand according to his id
   *
   * @param int $brandId brand id
   * @return Brand
   */
  public static function find($id)
  {
    $pdo = Database::getPDO();

    $sql = '
            SELECT *
            FROM brand
            WHERE id = ' . $id;

    $pdoStatement = $pdo->query($sql);
    $brand = $pdoStatement->fetchObject(Brand::class);

    return $brand;
  }

  /**
   * Method to retrieve all brands
   *
   * @return Brand[]
   */
  public static function findAll()
  {
    $pdo = Database::getPDO();
    $sql = 'SELECT * FROM `brand`';
    $pdoStatement = $pdo->query($sql);
    $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Brand::class);

    return $results;
  }

  /**
   * Method to add a new brand
   *
   * @return bool
   */
  public function insert()
  {
    $pdo = Database::getPDO();

    $sql = "INSERT INTO `brand` (`name`)
              VALUES (:name)";

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(":name",        $this->name,        PDO::PARAM_STR);
    $pdoStatement->execute();

    if ($pdoStatement->rowCount() === 1) {
      $this->id = $pdo->lastInsertId();

      return true;
    } else {

      return false;
    }
  }

  /**
   * Method to update a brand
   *
   * @return bool
   */
  public function update()
  {
    $pdo = Database::getPDO();

    $sql = "UPDATE `brand` SET 
                `name`       = :name,
                `updated_at` = NOW()
              WHERE `id` = :id";

    $pdoStatement = $pdo->prepare($sql);

    $pdoStatement->bindValue(":name",       $this->name,       PDO::PARAM_STR);
    $pdoStatement->bindValue(":id",         $this->id,         PDO::PARAM_INT);

    $pdoStatement->execute();

    if ($pdoStatement->rowCount() === 1) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Method to delete a brand
   *
   * @return bool
   */
  public function delete()
  {
    $pdo = Database::getPDO();

    $sql = "DELETE FROM `brand` WHERE `id` = :id";

    $pdoStatement = $pdo->prepare($sql);

    $pdoStatement->execute([":id" => $this->id]);

    if ($pdoStatement->rowCount() === 1) {
      return true;
    } else {
      return false;
    }

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