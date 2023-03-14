<?php
namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class CatalogController extends CoreController
{
    /**
     * Method to display the category_list's template
     */
    public function categoryList()
    {
       //dd($categoryList);
       //affichage de la liste des catégories 
       $categoryModel = new Category;
       $categoryList = $categoryModel->findAll();


        // On veut appeler la méthode findAll() du Model Category
        // Cette méthode findAll() étant à présent "static", on peut l'appeler directement
        // via le model Category
        //$categories = Category::findAll();
       
       $this->show('catalog/category_list', ['categoryList' => $categoryList]);
    }

    /**
     * Method to display the category_add's template
     */
    public function categoryAdd()
    {
        $this->show('catalog/category_add');
    }

    /**
     * Method to display the product_list's template
     */
    public function productList()
    {
        //affichage de la liste des produits
        $productModel = new Product;
        $productList = $productModel->findAll();

        $this->show('catalog/product_list', ['productList' => $productList]);
    }

    /**
     * Method to display the product_add's template
     */
    public function productAdd()
    {
        $this->show('catalog/product_add');
    }

};