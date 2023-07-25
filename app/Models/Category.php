<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

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

    /**
     * Get the value of subtitle
     * 
     * @param string $subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle(string $subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Method to retrieve a category according to his id
     *
     * @param int $categoryId category id
     * @return Category
     */
    public static function find($id)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `category` WHERE `id` = :id';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $pdoStatement->execute();

        return $pdoStatement->fetchObject(self::class);

    }

    /**
     * Methode to retrieve all categories
     *
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo          = Database::getPDO();
        $sql          = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results      = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        return $results;
    }

    /**
     * Method to retrieve categories list from the homepage
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';

        $pdoStatement = $pdo->query($sql);
        $categories   = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $categories;
    }

    /**
     * Method to add a new category
     *
     * @return bool
     */
    public function insert()
    {
      $pdo = Database::getPDO();

      $sql = "INSERT INTO `category` (`name`, `subtitle`, `picture`, `home_order`)
              VALUES (:name, :subtitle, :picture, :home_order)";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->bindValue(":name",        $this->name,        PDO::PARAM_STR);
      $pdoStatement->bindValue(":subtitle",    $this->subtitle,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":picture",     $this->picture,     PDO::PARAM_STR);
      $pdoStatement->bindValue(":home_order",  $this->home_order,  PDO::PARAM_INT);

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
     * Method to update a category
     * 
     * @return bool
     */
    public function update()
    {
      $pdo = Database::getPDO();

      $sql = "UPDATE `category` SET 
                `name`       = :name,
                `subtitle`   = :subtitle,
                `picture`    = :picture,
                `home_order` = :home_order,
                `updated_at` = NOW()
              WHERE `id` = :id";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->bindValue(":name",       $this->name,       PDO::PARAM_STR);
      $pdoStatement->bindValue(":subtitle",   $this->subtitle,   PDO::PARAM_STR);
      $pdoStatement->bindValue(":picture",    $this->picture,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":home_order", $this->home_order, PDO::PARAM_INT);
      $pdoStatement->bindValue(":id",         $this->id,         PDO::PARAM_INT);

      $pdoStatement->execute();

      if($pdoStatement->rowCount() > 0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    /**
     * Method to update displaying 5 categories on the homepage
     *
     * @param array $ids categories list [ids] to display on homepage
     * @return bool
     */ 
    public static function updateHomeOrder($ids)
    {
      $pdo = Database::getPDO();

      $sql = "UPDATE `category` SET `home_order` = 0;
              UPDATE `category` SET `home_order` = 1 WHERE id = ?;
              UPDATE `category` SET `home_order` = 2 WHERE id = ?;
              UPDATE `category` SET `home_order` = 3 WHERE id = ?;
              UPDATE `category` SET `home_order` = 4 WHERE id = ?;
              UPDATE `category` SET `home_order` = 5 WHERE id = ?";

      $pdoStatement = $pdo->prepare($sql);
      $pdoStatement->execute($ids);

      return ($pdoStatement->rowCount() > 0);
    }
        
    /**
     * Method to delete a category
     *
     * @return bool
     */
    public function delete()
    {
      $pdo = Database::getPDO();

      $sql = "DELETE FROM `category` WHERE `id` = :id";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->execute([
        ":id" => $this->id
      ]);

      return $pdoStatement->rowCount() === 1;
    }
}
