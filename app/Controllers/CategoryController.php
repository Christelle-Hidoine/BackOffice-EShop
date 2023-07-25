<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController

{
  /**
   * Method to display category's list
   *
   */
  public function list()
  {
    $category = Category::findAll();

    $this->show("category/list", ["category" => $category, 'token' => $this->generateToken()]);
  }

  /**
   * Method to display category's add form
   *
   * @return void
   */
  public function add()
  {
    $this->show("category/add", ['category' => new Category, 'token' => $this->generateToken()]);
  }

  /**
   * Method to retrieve data from category's add form
   *
   * @return void
   */
  public function create()
  {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $subtitle = filter_input(INPUT_POST, "subtitle", FILTER_SANITIZE_SPECIAL_CHARS);
    $picture = filter_input(INPUT_POST, "picture", FILTER_VALIDATE_URL);

    $errorList = [];

    if (empty($name)) {
        $errorList[] = 'Le nom de la catégorie est vide';
    }

    if ($picture === false) {
        $errorList[] = 'L\'URL de l\'image est invalide';
    }

    if (empty($errorList)) {

        $category = new Category();

        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);
        $category->setHomeOrder(0);

        if ($category->save()) {

            header("Location: " . $this->router->generate("category-list"));

            exit;
        } else {
            $message = "Echec de la sauvegarde en BDD";
            $this->show("category/add", ['error' => $message, 'token' => $this->generateToken()]);
        }
    } else {
        $category = new Category();
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);
        $category->setHomeOrder(0);

        $message = $errorList;
        $this->show("category/add", ['category' => $category, 'error' => $message, 'token' => $this->generateToken()]);
    }
  }

  /**
   * Method to display category's edit form
   *
   * @param [int] $id
   * @return void
   */
  public function edit($id)
  {   
    $category = Category::find($id);
    $this->show("category/edit", ["category" => $category, 'token' => $this->generateToken()]);
  }

  /**
   * Method to retrieve data from category's edit form
   *
   * @param [int] $id
   * @return void
   */
  public function update($id)
  {    
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $subtitle = filter_input(INPUT_POST, "subtitle", FILTER_SANITIZE_SPECIAL_CHARS);
    $picture = filter_input(INPUT_POST, "picture", FILTER_VALIDATE_URL);

    $errorList = [];

    if(empty($name)) 
    {
      $errorList[] = 'Le nom de la catégorie est vide';
    }

    if(empty($picture) || ($picture === false)) 
    {
      $errorList[] = 'L\'URL d\'image est invalide';
    }

    if(empty($errorList))
    {
      $category = Category::find($id);
    
      $category->setName($name);
      $category->setSubtitle($subtitle);
      $category->setPicture($picture);
      $category->setHomeOrder(0);

      if($category->save())
      {
        // header("Location: /category/list");
        header("Location: " . $this->router->generate("category-list"));
        exit;
      }
      else
      {
        $message = "Echec de la sauvegarde en BDD";
        $this->show("category/edit", ['error' => $message, 'token' => $this->generateToken()]);
      }
    }
    else
    {
      $category = new Category; 
      $category->setName($name);
      $category->setSubtitle($subtitle);
      $category->setPicture($picture);
      $category->setHomeOrder(0);

      $message = $errorList;
      $this->show("category/edit", ['category' => $category, 'errorList' => $message, 'token' => $this->generateToken()]);
    }
  }

  /**
   * Method to delete a category from category's list
   *
   * @param [int] $id
   * @return void
   */
  public function delete($id)
  {
    $category = Category::find($id);  

    if($category->delete())
    {
      header("Location: /category/list");
      exit;
    }
    else
    {
      $message = "Echec de la suppression de la catégorie";
      $category = Category::findAll();
      $this->show("category/list", ['category' => $category, ['error' => $message, 'token' => $this->generateToken()]]);
    }
  }

  /**
   * Method to display categoryHome's list to select home_order by category
   *
   * @return void
   */
  public function homeList()
  {
    $homeOrder = Category::findAll();
    $this->show('category/home', ['homeOrder' => $homeOrder, 'token' => $this->generateToken()]);
  }

  /**
   * Method to select home_order and retrieve data from categoryHome's list
   *
   * @return void
   */
  public function homeSelect()
  {
    $emplacement = filter_input(INPUT_POST, 'emplacement', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    Category::updateHomeOrder($emplacement);
    header('Location: /category/list');
    exit;

  }
}