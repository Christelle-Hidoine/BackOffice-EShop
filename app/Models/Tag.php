<?php 

namespace App\Models;

use App\Utils\Database;
use PDO;

class Tag extends CoreModel {

    private $name;
    private $product_id;
    private $tag_id;

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

  /**
   * Method to retrieve one tag according to his id
   *
   * @param int $tagId tag id
   * @return Tag
   */
  public static function find($id)
  {
    $pdo = Database::getPDO();

    $sql = '
            SELECT *
            FROM tag
            WHERE id = ' . $id;

    $pdoStatement = $pdo->query($sql);
    $tag = $pdoStatement->fetchObject(Tag::class);

    return $tag;
  }

  /**
   * Method to retrieve all tag
   *
   * @return Tag[]
   */
  public static function findAll()
  {
    $pdo = Database::getPDO();
    $sql = 'SELECT * FROM `tag`';
    $pdoStatement = $pdo->query($sql);
    $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Tag::class);

    return $results;
  }

  /**
     * Method to retrieve tag data from product and tag table by product_Id
     *
     * @param [int] $id
     * @return Tag
     */
    public static function findTagByProductId($id)
    {
      $pdo = Database::getPDO();
      $sql = "SELECT * FROM `tag` WHERE `id` IN ( SELECT `tag_id` FROM `product_has_tag` WHERE `product_id` = '. $id .')";
      $pdoStatement = $pdo->query($sql);
      $results = $pdoStatement->fetchObject(PDO::FETCH_CLASS, self::class);
      return $results;
    }

  /**
   * Method to add a new tag
   *
   * @return bool
   */
  public function insert()
  {
    $pdo = Database::getPDO();

    $sql = "INSERT INTO `tag` (`name`)
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
   * Method to update a tag
   *
   * @return bool
   */
  public function update()
  {
    $pdo = Database::getPDO();

    $sql = "UPDATE `tag` SET 
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
   * Method to delete association between tag and product id
   *
   * @return bool
   */
  public function deleteTagProduct()
  {
      $pdo = Database::getPDO();

      $sql = "DELETE FROM `product_has_tag` WHERE `product_id` = :product_id OR `tag_id` = :tag_id";

      $query = $pdo->prepare($sql);
      $query->bindValue(':product_id', $this->product_id, PDO::PARAM_INT);
      $query->bindValue(':tag_id', $this->tag_id, PDO::PARAM_INT);

      $query->execute();

      return $query->rowCount() > 0;
  }

  /**
   * Method to delete a tag
   *
   * @return bool
   */
  public function delete()
  {
    $this->deleteTagProduct();
    $pdo = Database::getPDO();

    $sql = "DELETE FROM `tag` WHERE `id` = :id";

    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute([":id" => $this->id]);

    return $pdoStatement->rowCount() === 1;
  }


    /**
     * Get the value of product_id
     */ 
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of tag_id
     */ 
    public function getTagId()
    {
        return $this->tag_id;
    }

    /**
     * Set the value of tag_id
     *
     * @return  self
     */ 
    public function setTagId($tag_id)
    {
        $this->tag_id = $tag_id;

        return $this;
    }
}