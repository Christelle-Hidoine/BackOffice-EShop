<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{
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
     * Method to retrieve all data about one user according to his id
     *
     * @param int $id user id
     * @return AppUser
     */
    public static function find($id)
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM app_user
            WHERE id = ' . $id;

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(":id", $id, PDO::PARAM_INT);
        $pdoStatement->execute();

        return $pdoStatement->fetchObject(AppUser::class);

    }

    /**
     * Method to retrieve all data from User entity
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, AppUser::class);

    }

    /**
     * Method to retrieve data from a user according to his email
     *
     * @param [string] $email user emal
     * @return AppUser
     */
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        
        $sql = "SELECT * FROM `app_user` WHERE `email` = :email";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute([':email' => $email]);

        $user = $pdoStatement->fetchObject(AppUser::class);

        return ($user) ? $user : false;
    }

    /**
     * Method to add a user in DB
     *
     * @return bool
     */
    public function insert()
    {
      $pdo = Database::getPDO();

      $sql = "INSERT INTO `app_user` (`email`, `password`, `firstname`,`lastname`, `role`, `status`)
              VALUES (:email, :password, :firstname, :lastname, :role, :status)";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->bindValue(":email",       $this->email,       PDO::PARAM_STR);
      $pdoStatement->bindValue(":password",    $this->password,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":firstname",   $this->firstname,   PDO::PARAM_STR);
      $pdoStatement->bindValue(":lastname",    $this->lastname,    PDO::PARAM_STR);
      $pdoStatement->bindValue(":role",        $this->role,        PDO::PARAM_STR);
      $pdoStatement->bindValue(":status",      $this->status,      PDO::PARAM_INT);

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
     * Method to update a user in DB
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

      return $pdoStatement->rowCount() === 1;
    }

    /**
     * Method to delete a user in DB
     *
     * @return bool
     */
    public function delete()
    {
      $pdo = Database::getPDO();

      $sql = "DELETE FROM `app_user` WHERE `id` = :id";

      $pdoStatement = $pdo->prepare($sql);

      $pdoStatement->execute([
        ":id" => $this->id
      ]);

      return $pdoStatement->rowCount() === 1;
    }

    /**
     * Method to check if a user has admin role
     *
     * @return boolean
     */
    public function isAdmin()
    {
      return $this->role === "admin";

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