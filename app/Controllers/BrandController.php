<?php

namespace App\Controllers;

use App\Models\Brand;

class BrandController extends CoreController

{
  /**
   * Method to display brand's list
   *
   * @return void
   */
  public function list()
  {
    $brand = Brand::findAll();
    $this->show("brand/list", ["brand" => $brand]);
  }

  /**
   * Method to retrieve data from brand's add form
   *
   * @return void
   */
  public function add()
  {
    $this->show('brand/add', ['brand' => new Brand]);
  }

  /**
   * Method to display brand's edit form
   *
   * @param [int] $id
   * @return void
   */
  public function edit($id)
  {
    $brand = Brand::find($id);
    $this->show('brand/add', ['brand' => $brand]);
  }

  /**
   * Method to add or edit a form with brand's add form
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
      $errorList[] = 'Le nom de la marque est vide';
    }

    // Si aucune erreur, $errorList est vide
    if(empty($errorList))
    {
      // On récupère la marque actuellement en BDD

      if($id > 0)
      {
        $brand = Brand::find($id);

      }
      else
      {
        $brand = new Brand();

      }

      // On modifie ses propriétés grace aux setters      
      $brand->setName($name);
      
      // sauvegarder ces modif en BDD
      if($brand->save())
      {
        header("Location: /brand/list");
        exit;
      }
      else
      {
        $message = "Une erreur est survenue lors de l'édition de la Marque";
        $this->show("brand/add", ['error' => $message]);
      }
    }
    else
    {
      // On affiche chaque erreurs rencontrée
      $brand= new Brand;
      $brand->setName($name);

      $message = $errorList;
      $this->show("brand/add", ['brand' => $brand, 'error' => $message]);
    }
  }

  /**
   * Method to delete a brand from brand's list
   *
   * @param [int] $id
   * @return void
   */
  public function delete($id)
  {
    $brand = Brand::find($id);  

    if($brand->delete())
    {
      header("Location: /brand/list");
      exit;
    }
    else
    {
      $message = "Echec de la suppression de la marque";
      $brand = Brand::findAll();
      $this->show("brand/list", ['brand' => $brand, ['error' => $message]]);
    }
  }

}