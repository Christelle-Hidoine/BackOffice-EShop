<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\Category;
use App\Models\Product;
use App\Models\CoreModel;

class MainController extends CoreController
{
  /**
   * Méthode s'occupant de la page d'accueil
   *
   * @return void
   */
  public function home()
  {
    // Récupération des données grace au model
    $allCategories = Category::findAll();
    $allProducts   = Product::findAll();

    // Bonus : n'afficher que les 5 premiers éléments de chaque tableau
    $allCategories = array_slice($allCategories, 0, 5);
    $allProducts   = array_slice($allProducts,   0, 5);

    // Je tente d'instancier un CoreModel ce qui n'a aucun sens 
    // car ça ne correspond a aucune "vraie" entité de notre MCD
    // $pofpof = new CoreModel();
    // dump( $pofpof );

    // On appelle la méthode show() de l'objet courant
    // En argument, on fournit le fichier de Vue
    // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
    $this->show('main/home', [
      "categories" => $allCategories,
      "products"   => $allProducts,
    ]);
  }
}