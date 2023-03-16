<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\Category;

class CategoryController extends CoreController

{
  public function list()
  {
    // Récupérer les données grace au Model
    $category = Category::findAll();

    // Les transmettre à la vue
    $this->show("category/list", ["category" => $category]);

    // On peut aussi transmettre directement le tableau en argument : même résultat !
      // $this->show( "category/list", [
      //   "allCategories" => $allCategories
      // ] );
  }

  // Page d'affichage du formulaire
  public function add()
  {
    $this->show("category/add");
  }

  // Page de traitement du formulaire
  public function create()
  {
    // dump( $_POST );

    // On reçoit les données du formulaire
    // DOC : https://www.php.net/manual/fr/function.filter-input.php
    //       https://www.php.net/manual/fr/filter.filters.sanitize.php
    //       https://www.php.net/manual/fr/filter.filters.validate.php
    $name     = filter_input(INPUT_POST, "name",     FILTER_SANITIZE_SPECIAL_CHARS);
    $subtitle = filter_input(INPUT_POST, "subtitle", FILTER_SANITIZE_SPECIAL_CHARS);
    $picture  = filter_input(INPUT_POST, "picture",  FILTER_VALIDATE_URL);

    // Maintenant on vérifie les valeurs de ces variables "filtrées"
    // Pour ça on créé un tableau qui va contenir toutes les erreurs rencontrées
    $errorList = [];

    if(empty($name)) 
    {
      $errorList[] = 'Le nom de la catégorie est vide';
    }

    // Subtitle peut etre null en BDD donc on peut ne pas le vérifier

    // Pour l'URL de l'image "picture", le filtre vérifie forcément sa présence aussi.
    if($picture === false) 
    {
      $errorList[] = 'L\'URL d\'image est invalide';
    }

    // Si on a rencontré aucune erreur => si $errorList est vide donc
    if(empty($errorList))
    {
      // On créé une nouvelle instance de Category
      $category = new Category; 

      // On met à jour ses propriétés avec les données du formulaire (nettoyées)
      $category->setName($name);
      $category->setSubtitle($subtitle);
      $category->setPicture($picture);
      $category->setHomeOrder(0);

      // Ensuite on appelle une méthode "insert" qui va faire l'ajout en BDD
      // elle va renvoyer un booléen selon si l'ajout a fonctionné ou non
      if($category->save())
      {
        // Si la sauvegarde a fonctionné
        // Ne peut être appellé si le moindre affichage a déjà été fait
        // On pourrait utiliser $router->generate mais il faudrait ajouter un "global $router"
        // en haut de la méthode 
        header( "Location: /category/list" );

        // Toujours exit après une redirection pour éviter de charger le reste de la page
        exit;
      }
      else
      {
        echo "Echec de la sauvegarde en BDD";
      }
    }
    else // Sinon, on affiche les erreurs (tel quel, mais on pourra améliorer ça plus tard)
    {
      // On affiche chaque erreurs rencontrée
      foreach($errorList as $error)
      {
        echo $error . "<br>";
      }
    }
  }

  // Page d'affichage du formulaire d'ajout
  public function edit($id)
  {    
    $categoryObject = Category::find($id);

    // dump($categoryObject);

    $this->show("category/edit", [ 
      "categoryObject" => $categoryObject
    ]);
  }

  // Page de traitement du formulaire d'édition
  public function update($id)
  {    
    $name     = filter_input(INPUT_POST, "name",     FILTER_SANITIZE_SPECIAL_CHARS);
    $subtitle = filter_input(INPUT_POST, "subtitle", FILTER_SANITIZE_SPECIAL_CHARS);
    $picture  = filter_input(INPUT_POST, "picture",  FILTER_VALIDATE_URL);

    // Maintenant on vérifie les valeurs de ces variables "filtrées"
    // Pour ça on créé un tableau qui va contenir toutes les erreurs rencontrées
    $errorList = [];

    if(empty($name)) 
    {
      $errorList[] = 'Le nom de la catégorie est vide';
    }

    // Subtitle peut etre null en BDD donc on peut ne pas le vérifier

    // Pour l'URL de l'image "picture", le filtre vérifie forcément sa présence aussi.
    if( $picture === false ) 
    {
      $errorList[] = 'L\'URL d\'image est invalide';
    }

    // Si je n'ai rencontré aucune erreur, $errorList est vide
    if( empty( $errorList ) )
    {
      // On commence par récupérer la catégorie actuellement en BDD
      $category = Category::find($id);

      // On modifie ses propriétés grace aux setters      
      $category->setName($name);
      $category->setSubtitle($subtitle);
      $category->setPicture($picture);
      $category->setHomeOrder(0);

      // Il nous reste a sauvegarder ces modif en BDD
      if($category->save())
      {
        header( "Location: /category/list" );
        exit;
      }
      else
      {
        echo "Une erreur est survenue lors de l'édition de la Categorie";
      }
    }
    else
    {
      // On affiche chaque erreurs rencontrée
      foreach($errorList as $error)
      {
        echo $error . "<br>";
      }
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

  public function delete($id)
  {
    $categoryObject = Category::find($id);  

    if( $categoryObject->delete() )
    {
      header( "Location: /category/list" );
      exit;
    }
    else
    {
      echo "Echec de la suppression de la catégorie";
    }
  }
}