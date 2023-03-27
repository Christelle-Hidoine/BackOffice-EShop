<?php

namespace App\Controllers;

use App\Models\Product;

class TagController extends CoreController 

{
  /**
   * Method to display tag's list
   *
   * @return void
   */
  public function list()
  {
    $tag = new Product;
    $tags = $tags->findTagById();
    $this->show("brand/list", ["tags" => $tags]);
  }
}