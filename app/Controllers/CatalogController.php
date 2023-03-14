<?php
namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class CatalogController extends CoreController
{

    //----------------------------- CATEGORY -------------------------------

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
     * Method to retrieve data from template category_add's form
     */
    public function categoryCreate()
    {
        // on vérifie que les champs obligatoires du formulaire sont remplis et on filtre
        if (empty($_POST['name'])) {
            echo '<script type="text/javascript">';
            echo ' alert("Merci de remplir tous les champs obligatoires du formulaire")';
            echo '</script>';
        } else {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
        

            // on modifie les valeurs des propriétés correspondantes dans notre model
            $category = new Category();
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);
            $category->insert();

            // on redirige vers la page category-list une fois le formulaire soumis
            header('Location: category-list');
            exit();
        }

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

    // ----------------------------------- PRODUCT -----------------------------

    /** 
     * Method to retrieve data from template product_add's form
     */
    public function productCreate()
    {
        // on vérifie que les champs du formulaire sont remplis et on filtre
        if (empty($_POST['name']) || empty($_POST['price']) || empty($_POST['rate']) || empty($_POST['status']) || empty($_POST['brand']) || empty($_POST['type']) ) {
            echo '<script type="text/javascript">';
            echo ' alert("Merci de remplir tous les champs obligatoires du formulaire")';
            echo '</script>';
        } else {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_ADD_SLASHES);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
            $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
            $brand_id = filter_input(INPUT_POST, 'brand', FILTER_VALIDATE_INT);
            $category_id = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
            $type_id = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT);


            // on modifie les valeurs des propriétés correspondantes dans notre model
            $product = new Product();
            $product->setName($name);
            $product->setDescription($description);
            $product->setPicture($picture);
            $product->setPrice($price);
            $product->setRate($rate);
            $product->setStatus($status);
            $product->setBrandId($brand_id);
            $product->setCategoryId($category_id);
            $product->setTypeId($type_id);
            $product->insert();

            // on redirige vers la page product-list une fois le formulaire soumis
            header('Location: product-list');
            exit();
        }
        $this->show('catalog/product_add');
    }
    
};