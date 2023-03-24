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
    // Récupérer les données grace au Model
    $category = Category::findAll();

    // Les transmettre à la vue
    $this->show("category/list", ["category" => $category]);
  }

  /**
   * Method to display category's add form
   *
   * @return void
   */
  public function add()
  {
    $this->show("category/add", ['category' => new Category]);
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

    // on crée la variable errorList pour conserver toutes les erreurs possibles à la récupération de ces données
    $errorList = [];

    if (empty($name)) {
        $errorList[] = 'Le nom de la catégorie est vide';
    }

    // Pour l'URL de l'image "picture", le filtre vérifie sa présence aussi.
    if ($picture === false) {
        $errorList[] = 'L\'URL de l\'image est invalide';
    }

    // si $errorList est vide
    if (empty($errorList)) {
        // On créé une nouvelle instance de Category
        $category = new Category();

        // On met à jour ses propriétés avec les données du formulaire (nettoyées)
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);
        $category->setHomeOrder(0);

        // méthode "insert" qui va faire l'ajout en BDD (method save() choisi insert ou update selon que l'id existe déjà ou non)
        // renvoi un booléen si l'ajout a fonctionné ou non
        if ($category->save()) {
            // Si la sauvegarde a fonctionné
            // header(); Ne peut pas être appelé si le moindre affichage a déjà été fait
            // On pourrait utiliser $router->generate mais il faudrait ajouter un "global $router"
            // en haut de la méthode
            // header("Location: /category/list");

            // avec l'argument $router dans le construct - et paramétré dans le dispatch - on peut utiliser $this->router->generate(+ nom de la route) dans le header();
            header("Location: " . $this->router->generate("category-list"));

            // Toujours exit après une redirection pour éviter de charger le reste de la page
            exit;
        } else {
            $message = "Echec de la sauvegarde en BDD";
            $this->show("category/add", ['error' => $message]);
        }
    } else {
        // On affiche chaque erreur rencontrée
        $category = new Category();
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);
        $category->setHomeOrder(0);

        $message = $errorList;
        $this->show("category/add", ['category' => $category, 'error' => $message]);
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
    // dump($category);
    $this->show("category/edit", ["category" => $category]);
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

    // tableau qui va contenir toutes les erreurs rencontrées
    $errorList = [];

    if(empty($name)) 
    {
      $errorList[] = 'Le nom de la catégorie est vide';
    }
    // Pour l'URL de l'image "picture", le filtre vérifie forcément sa présence aussi.
    if(empty($picture) || ($picture === false)) 
    {
      $errorList[] = 'L\'URL d\'image est invalide';
    }

    // Si aucune erreur, $errorList est vide
    if(empty($errorList))
    {
      // On récupère la catégorie selon son id en BDD
      $category = Category::find($id);

      // On modifie ses propriétés grace aux setters      
      $category->setName($name);
      $category->setSubtitle($subtitle);
      $category->setPicture($picture);
      $category->setHomeOrder(0);

      // sauvegarde des modifs en BDD
      if($category->save())
      {
        // header("Location: /category/list");
        // avec l'argument $router dans le construct - et paramétré dans le dispatch - on peut utiliser $this->router->generate(+ nom de la route) dans le header();
        header("Location: " . $this->router->generate("category-list"));
        exit;
      }
      else
      {
        $message = "Echec de la sauvegarde en BDD";
        $this->show("category/edit", ['error' => $message]);
      }
    }
    else
    {
      // On affiche chaque erreur rencontrée
      $category = new Category; 
      $category->setName($name);
      $category->setSubtitle($subtitle);
      $category->setPicture($picture);
      $category->setHomeOrder(0);

      $message = $errorList;
      $this->show("category/edit", ['category' => $category, 'errorList' => $message]);
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
      $this->show("category/list", ['category' => $category, ['error' => $message]]);
    }
  }

  /**
   * Method to display categoryHome's list to select home_order by category
   *
   * @return void
   */
  public function homeList()
  {

    // $homeOrder = Category::findAllHomepage();

    // -------- methode pour afficher toutes les catégories (pas seulement les 5 de la bdd)----------
    $homeOrder = Category::findAll();

    $this->show('category/home', ['homeOrder' => $homeOrder]);
  }

  /**
   * Method to select home_order and retrieve data from categoryHome's list
   *
   * @return void
   */
  public function homeSelect()
  {
    // OBJECTIF : setter toutes les home_order sur les categoryId correspondantes + update en BDD

    // On récupère du form un tableau $emplacement ['key' => 'home_order à modifier'] avec value string
    $emplacement = $_POST["emplacement"];
    // dump($emplacement);
    
    // tableau vide qui contiendra la liste des emplacements sélectionnés sur le form
    $homeOrderList = [];

    // filtre avec filter_var
    foreach ($emplacement as $home_order => $categoryId) {
        $categoryById = filter_var($categoryId, FILTER_VALIDATE_INT);
  
        // Modification de la clé pour commencer à 1 = 1er emplacement dans le form
        $homeOrderList[$home_order +1] = $categoryById;
    }
    // dump($homeOrderList);

// ----------------------------------  METHODE AVEC FIND ALL pour afficher toutes les category (pas seulement les 5 de la bdd)-----------------------------------------------------------

    // SI FINDALL() = > il faut passer toutes les home_order de la BDD à 0 avant de setter les nouvelles category->homeOrder
    $category = Category::findAll();
    foreach ($category as $resetHomeOrder) {
      $resetHomeOrder->setHomeOrder(0);
      // dump($categoryElement);
      $resetHomeOrder->save();
    };
// ----------------------------------  METHODE AVEC FIND ALL continue comme la méthode classique pour afficher juste le select des 5 catégories ------------------------------------------    

    // on parcourt le tableau en récupérant chaque categoryId correspondant à chaque emplacement
    foreach ($homeOrderList as $home_order => $categoryId) {
        // récupération de la category correspondante à la home_order sélectionnée avec method findByHomeOrder
        $category = Category::find($categoryId);
        // dump($category);

        // set de la valeur avec la position indiquée dans le form
        $category->setHomeOrder($home_order);
        // dump($category);

        // on sauvegarde dans la BDD
        $category->save(); 
    }

    // $homeOrder = Category::findAllHomepage();

    // -------- methode pour afficher toutes les catégories (pas seulement les 5 de la bdd)---------
    $homeOrder = Category::findAll();
    $this->show('category/home', ['homeOrder' => $homeOrder]);
  }
}