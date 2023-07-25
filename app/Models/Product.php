<?php

namespace App\Models;

use PDO;
use App\Utils\Database;

class Product extends CoreModel
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;

    /**
     * @var string tag name for product_has_tag table
     */
    private $tags;

    /**
     * @var string tag ids for product_has_tag table
     */
    private $tag_ids;

    /**
     * @var string tag id for product_has_tag table
     */
    private $tag_id;

    /**
     * @var int product id for product_has_tag table
     */
    private $product_id;

    /**
     * Method to retrieve a product according to his id
     *
     * @param int $productId ID du produit
     * @return Product
     */
    public static function find($id)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT *, product.name AS `name`, product.id AS id, GROUP_CONCAT(tag.name) AS tags, GROUP_CONCAT(tag.id) AS tag_ids
        FROM product 
        INNER JOIN product_has_tag ON product.id = product_has_tag.product_id 
        JOIN tag ON tag.id = product_has_tag.tag_id 
        WHERE product.id = ' . $id;

        $pdoStatement = $pdo->query($sql);

        return $pdoStatement->fetchObject(self::class);

    }

    /**
     * Method to retrieve all product
     *
     * @return Product[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT *, product.id, product.name, GROUP_CONCAT(tag.name) AS tags
        FROM product
        INNER JOIN product_has_tag ON product.id = product_has_tag.product_id
        INNER JOIN tag ON tag.id = product_has_tag.tag_id
        GROUP BY product.id
        ORDER BY product.id';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

    }

    /**
     * Method to retrieve all tags and product data according to product id
     *
     * @param [int] $id
     * @return Product
     */
    public static function findProductByTagId($id)
    {
      $pdo = Database::getPDO();
      $sql = "SELECT * FROM `product` WHERE `id` IN ( SELECT `tag_id` FROM `product_has_tag` WHERE `product_id` = '. $id .')";
      $pdoStatement = $pdo->query($sql);
      return $pdoStatement->fetchObject(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Method to add a product
     * 
     * @return bool
     */
    public function insert()
    {
      $pdo = Database::getPDO();

      $sql = "INSERT INTO `product` (name, description, picture, price, rate, status, brand_id, category_id, type_id)
          VALUES (:name, :description, :picture, :price, :rate, :status, :brand_id, :category_id, :type_id)";

      $query = $pdo->prepare($sql);

      $query->bindValue(':name', $this->name, PDO::PARAM_STR);
      $query->bindValue(':description', $this->description, PDO::PARAM_STR);
      $query->bindValue(':picture', $this->picture, PDO::PARAM_STR);
      $query->bindValue(':price', $this->price, PDO::PARAM_STR);
      $query->bindValue(':rate', $this->rate, PDO::PARAM_INT);
      $query->bindValue(':status', $this->status, PDO::PARAM_INT);
      $query->bindValue(':brand_id', $this->brand_id, PDO::PARAM_INT);
      $query->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
      $query->bindValue(':type_id', $this->type_id, PDO::PARAM_INT);

      $query->execute();

      if( $query->rowCount() > 0 ) 
      {
        $this->id = $pdo->lastInsertId();
        return true;
      }
      return false;
    }

    /**
     * Method to add a relation in product_has_tag.
     * 
     * @return bool
     */
    public function insertTagProduct()
    {
      $pdo = Database::getPDO();

      $sql = "INSERT INTO `product_has_tag` (`product_id`, `tag_id`) VALUES (:product_id, :tag_id)";

      $query = $pdo->prepare($sql);
      $query->bindValue(':product_id', $this->product_id, PDO::PARAM_INT);
      $query->bindValue(':tag_id', $this->tag_id, PDO::PARAM_INT);    

      $query->execute();

      if( $query->rowCount() > 0 ) 
      {
        $this->id = $pdo->lastInsertId();
        return true;
      }
      return false;
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
     * Method to retrieve all tags from product_has_tag table according to product id
     *
     * @param int $id product id
     * @return void
     */
    public function findTagsByProductId($id)
    {
      $pdo = Database::getPDO();

      $sql = "SELECT * 
            FROM `product_has_tag` 
            INNER JOIN `tag` ON tag.id = product_has_tag.tag_id
            WHERE product_id =" . $id;

      $pdoStatement = $pdo->query($sql);
      return $pdoStatement->fetchAll(PDO::FETCH_CLASS, Tag::class);
    }
 
    /**
     * Method to update a product
     *
     * @return bool
     */
    public function update()
    {
      $pdo = Database::getPDO();

      $sql = "
      UPDATE `product` SET 
                `name`       = :name,
                `description`= :description,
                `picture`    = :picture,
                `price`      = :price,
                `rate`       = :rate,
                `status`     = :status,
                `brand_id`   = :brand_id,
                `category_id`= :category_id,
                `type_id`    = :type_id,
                `updated_at` = NOW()
              WHERE `id` = :id";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->bindValue(':name',        $this->name,        PDO::PARAM_STR);
      $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
      $pdoStatement->bindValue(':picture',     $this->picture,     PDO::PARAM_STR);
      $pdoStatement->bindValue(':price',       $this->price,       PDO::PARAM_STR);
      $pdoStatement->bindValue(':rate',        $this->rate,        PDO::PARAM_INT);
      $pdoStatement->bindValue(':status',      $this->status,      PDO::PARAM_INT);
      $pdoStatement->bindValue(':brand_id',    $this->brand_id,    PDO::PARAM_INT);
      $pdoStatement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
      $pdoStatement->bindValue(':type_id',     $this->type_id,     PDO::PARAM_INT);
      $pdoStatement->bindValue(":id",          $this->id,          PDO::PARAM_INT);

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
     * Method to delete a product
     *
     * @return bool
     */
    public function delete()
    {
        $this->deleteTagProduct();
        $pdo = Database::getPDO();
    
        $sql = "DELETE FROM `product` WHERE `id` = :id";
    
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

    /**
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }

    /**
     * Get product id for product_has_tag table
     *
     * @return  int
     */ 
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set product id for product_has_tag table
     *
     * @param  int  $product_id  product id for product_has_tag table
     *
     * @return  self
     */ 
    public function setProductId(int $product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }


    /**
     * Get tag name for product_has_tag table
     *
     * @return  string
     */ 
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set tag name for product_has_tag table
     *
     * @param  string  $tags  tag name for product_has_tag table
     *
     * @return  self
     */ 
    public function setTags(string $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tag ids for product_has_tag table
     *
     * @return  string
     */ 
    public function getTagIds()
    {
        return $this->tag_ids;
    }

    /**
     * Set tag ids for product_has_tag table
     *
     * @param  string  $tag_ids  tag ids for product_has_tag table
     *
     * @return  self
     */ 
    public function setTagIds(string $tag_ids)
    {
        $this->tag_ids = $tag_ids;

        return $this;
    }

    /**
     * Get tag id for product_has_tag table
     *
     * @return  string
     */ 
    public function getTagId()
    {
        return $this->tag_id;
    }

    /**
     * Set tag id for product_has_tag table
     *
     * @param  string  $tag_id  tag id for product_has_tag table
     *
     * @return  self
     */ 
    public function setTagId(string $tag_id)
    {
        $this->tag_id = $tag_id;

        return $this;
    }
}