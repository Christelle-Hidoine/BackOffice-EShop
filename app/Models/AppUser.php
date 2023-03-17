<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $role;

    /**
     * @var int
     */
    private $status;

    /**
     * Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un id donné
     *
     * @param int $id ID du user
     * @return AppUser
     */
    public static function find($id)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = '
            SELECT *
            FROM app_user
            WHERE id = ' . $id;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $result = $pdoStatement->fetchObject(AppUser::class);

        // retourner le résultat
        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table app_user
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, AppUser::class);

        return $results;
    }


    /**
     * Méthode qui récupère les données d'un utilisateur selon son email
     *
     * @param [string] $email email du user
     * @return AppUser
     */
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        
        // on prépare la requête avec un marqueur
        $sql = "SELECT * FROM `app_user` WHERE `email` = :email";

        $pdoStatement = $pdo->prepare($sql);

        // si static function = on récupère la propriété elle-même = pas $this->email donc $email
        $pdoStatement->execute([':email' => $email]);

        $user = $pdoStatement->fetchObject(AppUser::class);

        if ($user)
        {
          return $user;
        } else {
          return false;
        }

        // condition en ternaire
        // return ($user) ? $user : false;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table app_user
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
      $pdo = Database::getPDO();

      $sql = "INSERT INTO `app_user` (`email`, `password`, `firstname`,`lastname`, `role`, `status`)
              VALUES (:email, :password, :firstname, :lastname, :role, :status)";

      // On stocke notre requete préparée 
      $pdoStatement = $pdo->prepare($sql);

      // remplacer chaque "valeur" précédée d'un : par sa vraie valeur
      $pdoStatement->bindValue(":email",       $this->email,       PDO::PARAM_STR);
      $pdoStatement->bindValue(":password",    $this->password,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":firstname",   $this->firstname,   PDO::PARAM_STR);
      $pdoStatement->bindValue(":lastname",    $this->lastname,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":role",        $this->role,        PDO::PARAM_STR);
      $pdoStatement->bindValue(":status",      $this->status,      PDO::PARAM_INT);

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
     * Méthode permettant de mettre à jour un enregistrement dans la table app_user
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function update()
    {
      $pdo = Database::getPDO();

      $sql = "UPDATE `app_user` SET 
                `email`      = :email, 
                `password`   = :password,
                `firstname`  = :firstname,
                `lastname`   = :lastname, 
                `role`       = :role, 
                `status`     = :status,
                `updated_at` = NOW()
              WHERE `id` = :id";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->bindValue(":email",       $this->email,       PDO::PARAM_STR);
      $pdoStatement->bindValue(":password",    $this->password,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":firstname",   $this->firstname,   PDO::PARAM_STR);
      $pdoStatement->bindValue(":lastname",    $this->lastname,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":role",        $this->role,        PDO::PARAM_STR);
      $pdoStatement->bindValue(":status",      $this->status,      PDO::PARAM_INT);
      $pdoStatement->bindValue(":id",          $this->id,          PDO::PARAM_INT);

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

      $sql = "DELETE FROM `app_user` WHERE `id` = :id";

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
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}