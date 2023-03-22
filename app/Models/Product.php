<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
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
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     *
     * @param int $productId ID du produit
     * @return Product
     */
    public static function find($id)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        $sql = '
            SELECT *
            FROM product
            WHERE id = ' . $id;

        // query ? exec ?
        // On fait de la LECTURE = une récupration => query()
        // si on avait fait une modification, suppression, ou un ajout => exec
        $pdoStatement = $pdo->query($sql);

        // fetchObject() pour récupérer un seul résultat
        // si j'en avais eu plusieurs => fetchAll
        $result = $pdoStatement->fetchObject(self::class);

        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Product[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table product.
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     * 
     * @return bool
     */
    public function insert()
    {
      // Récupération de l'objet PDO représentant la connexion à la DB
      $pdo = Database::getPDO();

      // Ecriture de la requête INSERT INTO
      $sql = "INSERT INTO `product` (name, description, picture, price, rate, status, brand_id, category_id, type_id)
          VALUES (:name, :description, :picture, :price, :rate, :status, :brand_id, :category_id, :type_id)";

      // Préparation de la requête d'insertion (+ sécurisé que exec directement)
      // @see https://www.php.net/manual/fr/pdo.prepared-statements.php

      // Permet de lutter contre les injections SQL
      // @see https://portswigger.net/web-security/sql-injection (exemples avec SELECT)
      // @see https://stackoverflow.com/questions/681583/sql-injection-on-insert (exemples avec INSERT INTO)
      $query = $pdo->prepare($sql);

      // Execution de la requête d'insertion
      // Ou bien utiliser la méthode bindValue pour chaque token/jeton/placeholder
      $query->bindValue(':name', $this->name, PDO::PARAM_STR);
      $query->bindValue(':description', $this->description, PDO::PARAM_STR);
      $query->bindValue(':picture', $this->picture, PDO::PARAM_STR);
      $query->bindValue(':price', $this->price, PDO::PARAM_STR);
      $query->bindValue(':rate', $this->rate, PDO::PARAM_INT);
      $query->bindValue(':status', $this->status, PDO::PARAM_INT);
      $query->bindValue(':brand_id', $this->brand_id, PDO::PARAM_INT);
      $query->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
      $query->bindValue(':type_id', $this->type_id, PDO::PARAM_INT);
      

      // Le 3e argument permet de préciser "valeur numérique" (PDO::PARAM_STR) ou "autre" (PDO::PARAM_STR)
      // Puis exécuter la requête SQL préparée
      $query->execute();

      // Si au moins une ligne ajoutée
      if( $query->rowCount() > 0 ) 
      {
        // Alors on récupère l'id auto-incrémenté généré par MySQL
        $this->id = $pdo->lastInsertId();

        // On retourne VRAI car l'ajout a parfaitement fonctionné
        return true;
        // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
      }
      
      // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
      return false;
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table product
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
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
     * Méthode qui va appeller insert() ou update() selon la présence d'un id
     *
     * @return void
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

     
    /**
     * Méthode qui supprime un enregistrement de la table
     *
     * @return bool
     */
     public function delete()
     {
       $pdo = Database::getPDO();
 
       $sql = "DELETE FROM `product` WHERE `id` = :id";
 
       $pdoStatement = $pdo->prepare($sql);
 
       // Version alternative a binvalue + execute
       // Fait le bindValue et le execute en une ligne en passant un tableau
       // en premier argument de
       $pdoStatement->execute([
         ":id" => $this->id
       ]);
 
       if($pdoStatement->rowCount() === 1)
       {
         return true;
       }
       else
       {
         return false;
       }
 
       // Version raccourcie du bloc if/else du dessus
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
}