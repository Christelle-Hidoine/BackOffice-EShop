<?php 

namespace App\Models;

use App\Utils\Database;
use PDO;

class Tag extends CoreModel {

    private $name;

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
   * Méthode permettant de récupérer un enregistrement de la table Tag en fonction d'un id donné
   *
   * @param int $tagId ID du tag
   * @return Tag
   */
  public static function find($id)
  {
    // se connecter à la BDD
    $pdo = Database::getPDO();

    // écrire notre requête
    $sql = '
            SELECT *
            FROM tag
            WHERE id = ' . $id;

    // exécuter notre requête
    $pdoStatement = $pdo->query($sql);

    // un seul résultat => fetchObject
    $tag = $pdoStatement->fetchObject(Tag::class);

    // retourner le résultat
    return $tag;
  }

  /**
   * Méthode permettant de récupérer tous les enregistrements de la table tag
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
   * Méthode permettant d'ajouter un enregistrement dans la table tag
   * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
   *
   * @return bool
   */
  public function insert()
  {
    $pdo = Database::getPDO();

    $sql = "INSERT INTO `tag` (`name`)
              VALUES (:name)";

    // On stocke notre requete préparée (attention à ce stade elle n'est pas encore executée !)
    $pdoStatement = $pdo->prepare($sql);

    // Ensuite, je vais remplacer chaque "valeur" précédée d'un : par sa vraie valeur
    // En quelque sorte, les :name, :subtitle etc.. sont juste des "emplacements" pour les valeurs
    $pdoStatement->bindValue(":name",        $this->name,        PDO::PARAM_STR);

    // On execute la requete une fois qu'elle est préparée
    $pdoStatement->execute();

    // On vérifie le nombre d'enregistrements affectés par la requete
    // Ici c'est un insert, on doit donc avoir un enregistrement affecté => celui ajouté
    if ($pdoStatement->rowCount() === 1) {
      // On utilise la méthode lastInsertId de PDO pour récupérerle dernier ID
      // autoincrémenté, ici celui de notre nouvelle catégorie
      $this->id = $pdo->lastInsertId();

      // L'ajout a bien fonctionné on peut retourner true
      return true;
    } else {
      // Si l'ajout a échoué, on return false, ce qui déclenchera l'affichage du message
      // d'erreur dans la condition du controller
      return false;
    }
  }

  /**
   * Méthode permettant de mettre à jour un enregistrement dans la table tag
   * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
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
   * Méthode qui va appeller insert() ou update() selon la présence d'un id
   *
   */
  public function save()
  {
    if ($this->id) {
      return $this->update();
    } else {
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

    $sql = "DELETE FROM `tag` WHERE `id` = :id";

    $pdoStatement = $pdo->prepare($sql);

    // Version alternative a binvalue + execute
    // Fait le bindValue et le execute en une ligne en passant un tableau
    // en premier argument de
    $pdoStatement->execute([":id" => $this->id]);

    if ($pdoStatement->rowCount() === 1) {
      return true;
    } else {
      return false;
    }

    // Version raccourcie du bloc if/else du dessus
    return $pdoStatement->rowCount() === 1;
  }

}