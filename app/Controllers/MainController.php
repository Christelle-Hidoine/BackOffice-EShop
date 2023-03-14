<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller

        // affichage de la liste de 3 catégories
        $categoryModel = new Category;
        $categoryList = $categoryModel->findAllHomepage();

        //affichage de la liste de 3 produits
        $productModel = new Product;
        $productList = $productModel->findAllHomepage();
        $this->show('main/home', ['categoryList' => $categoryList, 'productList' => $productList]);
    }
}
