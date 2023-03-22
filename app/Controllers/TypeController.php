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
    $this->show("type/list", ["types" => $types]);
  }

  /**
   * Method to retrieve data from type's add form
   *
   * @return void
   */
  public function add()
  {
    $this->show('type/add', ['type' => new Type]);
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
    $this->show('type/add', ['type' => $type]);
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

    // on vérifie les valeurs de ces variables "filtrées"
    // tableau avec toutes les erreurs rencontrées
    $errorList = [];

    if(empty($name)) 
    {
      $errorList[] = 'Le nom du type est vide';
    }

    // Si aucune erreur, $errorList est vide
    if(empty($errorList))
    {
      // On récupère le type actuellement en BDD

      if($id > 0)
      {
        $type = Type::find($id);
      }
      else
      {
        $type = new Type();
      }

      // On modifie ses propriétés grace aux setters      
      $type->setName($name);
      
      // sauvegarder ces modif en BDD
      if($type->save())
      {
        header("Location: /type/list");
        exit;
      }
      else
      {
        $message = "Une erreur est survenue lors de l'édition du Type";
        $this->show("type/add", ['error' => $message]);
      }
    }
    else
    {
      // On affiche chaque erreur rencontrée
      $type= new Type;
      $type->setName($name);

      $message = $errorList;
      $this->show("type/add", ['type' => $type, 'error' => $message]);
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
      $this->show("type/list", ['type' => $type, ['error' => $message]]);
    }
  }
}