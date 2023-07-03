<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
  /**
   * Method to display homepage
   *
   * @return void
   */
  public function home()
  {
    
    // Récupération des données grace au model
    $category = Category::findAll();
    $product = Product::findAll();

    // Bonus : n'afficher que les 5 premiers éléments de chaque tableau
    $category = array_slice($category, 0, 5);
    $product = array_slice($product, 0, 5);

    // On appelle la méthode show() de l'objet courant
    // En argument, on fournit le fichier de Vue
    // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
    $this->show('main/home', ["category" => $category,"product" => $product, 'token' => $this->generateToken()]);
  }
}