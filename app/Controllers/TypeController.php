<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController

{
  /**
   * Method to display type's list
   *
   * @return void
   */
  public function list()
  {
    $types = Type::findAll();
    $this->show("type/list", ["types" => $types, 'token' => $this->generateToken()]);
  }

  /**
   * Method to retrieve data from type's add form
   *
   * @return void
   */
  public function add()
  {
    $this->show('type/add', ['type' => new Type, 'token' => $this->generateToken()]);
  }

  /**
   * Method to display type's edit form
   *
   * @param [int] $id
   * @return void
   */
  public function edit($id)
  {
    $type = Type::find($id);
    $id = $type->getId();
    $this->show('type/add', ['type' => $type, 'id' => $id, 'token' => $this->generateToken()]);
  }

  /**
   * Method to add or edit a form with type's add form
   *
   * @param integer $id
   * @return void
   */
  public function createOrEdit($id = null)
  {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $errorList = [];

    if(empty($name)) 
    {
      $errorList[] = 'Le nom du type est vide';
    }

    if(empty($errorList))
    {
      if($id > 0)
      {
        $type = Type::find($id);
      }
      else
      {
        $type = new Type();
      }
     
      $type->setName($name);
      
      if($type->save())
      {
        // header("Location: /type/list");
        header("Location: " . $this->router->generate('type-list'));
        exit;
      }
      else
      {
        $message = "Une erreur est survenue lors de l'édition du Type";
        $this->show("type/add", ['error' => $message, 'token' => $this->generateToken()]);
      }
    }
    else
    {
      $type= new Type;
      $type->setName($name);

      $message = $errorList;
      $this->show("type/add", ['type' => $type, 'error' => $message, 'token' => $this->generateToken()]);
    }
  }

  /**
   * Method to delete a type from type's list
   *
   * @param [int] $id
   * @return void
   */
  public function delete($id)
  {
    $type = Type::find($id);  

    if($type->delete())
    {
      header("Location: /type/list");
      exit;
    }
    else
    {
      $message = "Echec de la suppression de la marque";
      $type = Type::findAll();
      $this->show("type/list", ['type' => $type, ['error' => $message], 'token' => $this->generateToken()]);
    }
  }
}