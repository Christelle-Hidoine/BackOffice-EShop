<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController

{
  public function list()
  {
    // Récupérer les données grace au Model
    $type = Type::findAll();

    // Les transmettre à la vue
    $this->show("type/list", ["type" => $type]);

  }
}