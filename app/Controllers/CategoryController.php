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

    if(empty($name)) 
    {
      $errorList[] = 'Le nom de la catégorie est vide';
    }
    
    // Pour l'URL de l'image "picture", le filtre vérifie sa présence aussi.
    if($picture === false) 
    {
      $errorList[] = 'L\'URL de l\'image est invalide';
    }

    // si $errorList est vide 
    if(empty($errorList))
    {
      // On créé une nouvelle instance de Category
      $category = new Category; 

      // On met à jour ses propriétés avec les données du formulaire (nettoyées)
      $category->setName($name);
      $category->setSubtitle($subtitle);
      $category->setPicture($picture);
      $category->setHomeOrder(0);

      // méthode "insert" qui va faire l'ajout en BDD (method save() choisi insert ou update selon que l'id existe déjà ou non)
      // renvoi un booléen si l'ajout a fonctionné ou non
      if($category->save())
      {
        // Si la sauvegarde a fonctionné
        // header(); Ne peut pas être appelé si le moindre affichage a déjà été fait
        // On pourrait utiliser $router->generate mais il faudrait ajouter un "global $router"
        // en haut de la méthode 
        header( "Location: /category/list" );

        // Toujours exit après une redirection pour éviter de charger le reste de la page
        exit;
      }
      else
      {
        $message = "Echec de la sauvegarde en BDD";
        $this->show("category/add", ['error' => $message]);
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
        header( "Location: /category/list" );
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


// Version factorisée de create et edit
  // public function createOrEdit($id = 0)
  // {
  //   $name     = filter_input( INPUT_POST, "name",     FILTER_SANITIZE_STRING );
  //   $subtitle = filter_input( INPUT_POST, "subtitle", FILTER_SANITIZE_STRING );
  //   $picture  = filter_input( INPUT_POST, "picture",  FILTER_VALIDATE_URL );

    // Maintenant on vérifie les valeurs de ces variables "filtrées"
    // Pour ça on créé un tableau qui va contenir toutes les erreurs rencontrées
  //   $errorList = [];

  //   if( empty( $name ) ) 
  //   {
  //     $errorList[] = 'Le nom de la catégorie est vide';
  //   }

  // Subtitle peut etre null en BDD donc on peut ne pas le vérifier

    // Pour l'URL de l'image "picture", le filtre vérifie forcément sa présence aussi.
  //   if( $picture === false ) 
  //   {
  //     $errorList[] = 'L\'URL d\'image est invalide';
  //   }

    // Si je n'ai rencontré aucune erreur, $errorList est vide
  //   if( empty( $errorList ) )
  //   {
      // On commence par récupérer la catégorie actuellement en BDD

  //     if( $id > 0 )
  //     {
  //       $category = Category::find( $id );
  //     }
  //     else
  //     {
  //       $category = new Category();
  //     }

      // On modifie ses propriétés grace aux setters      
  //     $category->setName( $name );
  //     $category->setSubtitle( $subtitle );
  //     $category->setPicture( $picture );
  //     $category->setHomeOrder( 0 );

      // Il nous reste a sauvegarder ces modif en BDD
  //     if( $category->save() )
  //     {
  //       header( "Location: /category/list" );
  //       exit;
  //     }
  //     else
  //     {
  //       echo "Une erreur est survenue lors de l'édition de la Categorie";
  //     }
  //   }
  //   else
  //   {
      // On affiche chaque erreurs rencontrée
  //     foreach( $errorList as $error )
  //     {
  //       echo $error . "<br>";
  //     }
  //   }
  // }

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
    $homeOrder = Category::findAllHomepage();

    $categoryByHomeOrder = [];
        foreach ($homeOrder as $category) {
            $categoryByHomeOrder[$category->getHomeOrder()] = $category;
        }
    $this->show('category/home', ['homeOrder' => $homeOrder, 'categoryByHomeOrder' => $categoryByHomeOrder]);
  }

  /**
   * Method to select home_order and retrieve data from categoryHome's list
   *
   * @return void
   */
  public function homeSelect()
  {
    // On récupère du form un tableau $emplacement['key' => 'home_order à modifier'] avec value string
    $emplacementForm = $_POST["emplacement"];

    $homeOrderCategory = Category::findAllHomepage();

    $homeOrderList = [];
    // on convertit les values en int et on filtre
    foreach ($emplacementForm as $emplacement) {
        $emplacementNumber = intval($emplacement);
        $homeOrderNumber = filter_var($emplacementNumber, FILTER_VALIDATE_INT);
        $homeOrderList[] = $homeOrderNumber;
    }
    dump($homeOrderList);

    foreach ($homeOrderCategory as $category => $element) {
      $category= $element->getId();
    }
    dump($homeOrderCategory);
  

    // OBJECTIF : setter toutes les home_order sur les category correspondantes + update en BDD

    // on crée un tableau vide qui accueillera ['home_order à setter' => 'categoryId']
    $homeOrderByCategoryId = [];

    // on récupère l'id de chaque category de la home Category 
    $homeOrderCategory = Category::findAllHomepage();
    foreach ($homeOrderCategory as $category) {

      $categoryId = $category->getId();
      $homeOrderByCategoryId[] = $categoryId;
    }
    $homeOrderByCategoryId = array_fill_keys($homeOrderList, $categoryId);
    dump($homeOrderByCategoryId);

    // on parcourt le tableau des emplacements sélectionnés dans le form pour récupérer la clé home_order qui servira à setter les catégories
    
    
  }
  
  
}