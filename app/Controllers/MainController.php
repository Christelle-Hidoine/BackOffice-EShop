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
    $category = Category::findAll();
    $product = Product::findAll();

    $category = array_slice($category, 0, 5);
    $product = array_slice($product, 0, 5);

    $this->show('main/home', ["category" => $category,"product" => $product, 'token' => $this->generateToken()]);
  }
}