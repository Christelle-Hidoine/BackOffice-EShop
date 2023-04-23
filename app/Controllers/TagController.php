<?php

namespace App\Controllers;

use App\Models\Tag;

class TagController extends CoreController 

{
  /**
   * Method to display tag's list
   *
   * @return void
   */
  public function list()
  {
    $tags = Tag::findAll();
    $this->show("tag/list", ["tags" => $tags]);
  }

  /**
   * Method to retrieve data from tag's add form
   *
   * @return void
   */
  public function add()
  {
    $this->show('tag/add', ['tag' => new Tag]);
  }

  /**
   * Method to display tag's edit form
   *
   * @param [int] $id
   * @return void
   */
  public function edit($id)
  {
    $tag = Tag::find($id);
    $id = $tag->getId();
    $this->show('tag/add', ['tag' => $tag, 'id'=> $id]);
  }

  /**
   * Method to add or edit a form with tag's add form
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
      $errorList[] = 'Le nom du tag est vide';
    }

    // Si aucune erreur, $errorList est vide
    if(empty($errorList))
    {
      // On récupère le tag actuellement en BDD

      if($id > 0)
      {
        $tag = Tag::find($id);
      }
      else
      {
        $tag = new Tag();
      }

      // On modifie ses propriétés grace aux setters      
      $tag->setName($name);
      
      // sauvegarder ces modif en BDD
      if($tag->save())
      {
        // header("Location: /brand/list");
        header("Location: " . $this->router->generate('tag-list'));
        exit;
      }
      else
      {
        $message = "Une erreur est survenue lors de l'édition du tag";
        $this->show("tag/add", ['error' => $message]);
      }
    }
    else
    {
      // On affiche chaque erreurs rencontrée
      $tag= new Tag;
      $tag->setName($name);

      $message = $errorList;
      $this->show("tag/add", ['tag' => $tag, 'error' => $message]);
    }
  }

  /**
   * Method to delete a tag from tag's list
   *
   * @param [int] $id
   * @return void
   */
  public function delete($id)
  {
    $tag = Tag::find($id);  

    if($tag->delete())
    {
      // header("Location: /tag/list");
      header("Location: " . $this->router->generate('tag-list'));
      exit;
    }
    else
    {
      $message = "Echec de la suppression du tag";
      $tag = Tag::findAll();
      $this->show("tag/list", ['tag' => $tag, ['error' => $message]]);
    }
  }
}