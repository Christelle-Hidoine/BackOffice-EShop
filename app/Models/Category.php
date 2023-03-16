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
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
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
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($id)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `category` WHERE `id` = :id';

        // préparer notre requête
        $pdoStatement = $pdo->prepare($sql);

        // remplacer les placeholders/étiquettes
        $pdoStatement->bindValue(":id", $id, PDO::PARAM_INT);

        // Executer la requete
        $pdoStatement->execute();

        // un seul résultat => fetchObject
        // self fait ici référence au nom de la classe actuelle, ici Category
        // ::class fait lui réference au FQCN de cette classe
        // Au final, on aura "App\Models\Category" passé en argument
        $category = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
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
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    static public function findAllHomepage()
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

    // Fonction qui se charge d'ajouter en base de données l'instance actuelle de Category
    public function insert()
    {
      $pdo = Database::getPDO();

      $sql = "INSERT INTO `category` (`name`, `subtitle`, `picture`, `home_order`)
              VALUES (:name, :subtitle, :picture, :home_order)";

      // On stocke notre requete préparée (attention à ce stade elle n'est pas encore executée !)
      $pdoStatement = $pdo->prepare($sql);

      // Ensuite, je vais remplacer chaque "valeur" précédée d'un : par sa vraie valeur
      // En quelque sorte, les :name, :subtitle etc.. sont juste des "emplacements" pour les valeurs
      $pdoStatement->bindValue(":name",        $this->name,        PDO::PARAM_STR);
      $pdoStatement->bindValue(":subtitle",    $this->subtitle,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":picture",     $this->picture,     PDO::PARAM_STR);
      $pdoStatement->bindValue(":home_order",  $this->home_order,  PDO::PARAM_INT);

      // On execute la requete une fois qu'elle est préparée
      $pdoStatement->execute();

      // On vérifie le nombre d'enregistrements affectés par la requete
      // Ici c'est un insert, on doit donc avoir un enregistrement affecté => celui ajouté
      if($pdoStatement->rowCount() === 1)
      {
        // On utilise la méthode lastInsertId de PDO pour récupérerle dernier ID
        // autoincrémenté, ici celui de notre nouvelle catégorie
        $this->id = $pdo->lastInsertId();

        // L'ajout a bien fonctionné on peut retourner true
        return true;
      }
      else
      {
        // Si l'ajout a échoué, on return false, ce qui déclenchera l'affichage du message
        // d'erreur dans la condition du controller
        return false;
      }
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

      $sql = "DELETE FROM `category` WHERE `id` = :id";

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
}