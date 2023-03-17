<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category

use App\Models\Brand;

class BrandController extends CoreController

{
  public function list()
  {
    // Récupérer les données grace au Model
    $brand = Brand::findAll();

    // Les transmettre à la vue
    $this->show("brand/list", ["brand" => $brand]);

  }
}