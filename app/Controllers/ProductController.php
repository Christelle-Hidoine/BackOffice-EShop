<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use App\Models\Tag;

class ProductController extends CoreController 
{
  /**
   * Method to display product's list
   *
   * @return void
   */
  public function list()
  {
    // On récupère tous les produits
    $products = Product::findAll();
    
    // On les envoie à la vue
    $this->show('product/list', ["products" => $products, 'token' => $this->generateToken()]);
  }

  /**
   * Method to display product's add
   *
   * @return void
   */
  public function add()
  {
    $productList = Product::findAll();
    $brandList = Brand::findAll();
    $categoryList = Category::findAll();
    $typeList = Type::findAll();

    $this->show('product/add', ['productList' => $productList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList, 'product' => new Product, 'token' => $this->generateToken()]);
  }
  
  /**
   * Method to retrieve data from product's add form
   *
   * @return void
   */
  public function create()
  {
    // On récupère les données venant du formulaire.
    $name        = filter_input(INPUT_POST, 'name',        FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $picture     = filter_input(INPUT_POST, 'picture',     FILTER_VALIDATE_URL);
    $price       = filter_input(INPUT_POST, 'price',       FILTER_VALIDATE_FLOAT);
    $rate        = filter_input(INPUT_POST, 'rate',        FILTER_VALIDATE_INT);
    $status      = filter_input(INPUT_POST, 'status',      FILTER_VALIDATE_INT);
    $brand_id    = filter_input(INPUT_POST, 'brand',       FILTER_VALIDATE_INT);
    $category_id = filter_input(INPUT_POST, 'category',    FILTER_VALIDATE_INT);
    $type_id     = filter_input(INPUT_POST, 'type',        FILTER_VALIDATE_INT);

    // On vérifie l'existence et la validité de ces données (gestion d'erreur).
    $errorList = [];

    if (empty($name)) {
        $errorList[] = 'Le nom est vide';
    }
    if (empty($description)) {
        $errorList[] = 'La description est vide';
    }
    if ($picture === false) {
        $errorList[] = 'L\'URL de l\'image est invalide';
    }
    if ($price === false) {
        $errorList[] = 'Le prix est invalide';
    }
    if ($rate === false) {
        $errorList[] = 'La note est invalide';
    }
    if ($status === false) {
        $errorList[] = 'Le statut est invalide';
    }
    if ($brand_id === false) {
        $errorList[] = 'La marque est invalide';
    }
    if ($category_id === false) {
        $errorList[] = 'La catégorie est invalide';
    }
    if ($type_id === false) {
        $errorList[] = 'Le type est invalide';
    }
  
    // Si aucune erreur 
    if(empty($errorList)) 
    {
      // On instancie un nouveau modèle de type Product
      $product = new Product();

      // On met à jour les propriétés de l'instance
      $product->setName($name);
      $product->setDescription($description);
      $product->setPicture($picture);
      $product->setPrice($price);
      $product->setRate($rate);
      $product->setStatus($status);
      $product->setBrandId($brand_id);
      $product->setCategoryId($category_id);
      $product->setTypeId($type_id);

      // On sauvegarde dans la BDD
      if($product->insert()) 
      {
        // Si la sauvegarde a fonctionné, on redirige vers la liste des produitS
        // header('Location: /product/list');
        header("Location: " . $this->router->generate('product-list'));
        exit;
      }
      else 
      {
        $message = "Echec de la sauvegarde en BDD";
        $this->show("product/add", ['error' => $message, 'token' => $this->generateToken()]);
      }
    }
    else 
    {
      // On affiche chaque erreurs rencontrée
      $product = new Product();

      // On met à jour les propriétés de l'instance pour l'affichage dans le formulaire
      $product->setName($name);
      $product->setDescription($description);
      $product->setPicture($picture);
      $product->setPrice($price);
      $product->setRate($rate);
      $product->setStatus($status);
      $product->setBrandId($brand_id);
      $product->setCategoryId($category_id);
      $product->setTypeId($type_id);

      $productList = Product::findAll();
      $brandList = Brand::findAll();
      $categoryList = Category::findAll();
      $typeList = Type::findAll();

      $message = $errorList;

      $this->show('product/add', ['productList' => $productList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList, 'product' => $product, 'error' => $message, 'token' => $this->generateToken()]);
    }
  }

  /**
   * Method to display Product's edit form
   *
   * @param [int] $id
   * @return void
   */
  public function edit($id)
  {    
    $product = Product::find($id);
    $productList = Product::findAll();
    $brandList = Brand::findAll();
    $categoryList = Category::findAll();
    $typeList = Type::findAll();

    $typeListById = [];
        foreach ($typeList as $typeElement) {
            $typeListById[$typeElement->getId()] = $typeElement;
        }

        $categoryListById = [];
        foreach ($categoryList as $categoryElement) {
            $categoryListById[$categoryElement->getId()] = $categoryElement;
        }

        $brandListById = [];
        foreach ($brandList as $brandElement) {
            $brandListById[$brandElement->getId()] = $brandElement;
        }

    $this->show("product/edit", [ 
      "product" => $product, 'productList' => $productList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList, 'typeListById' => $typeListById, 'categoryListById' => $categoryListById, 'brandListById' => $brandListById,  'token' => $this->generateToken()
    ]);
  }

  /**
   * Method to retrieve data from product's edit form
   *
   * @param [int] $id
   * @return void
   */
  public function update($id)
  {    

    $name = filter_input(INPUT_POST, 'name',  FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
    $brand_id = filter_input(INPUT_POST, 'brand', FILTER_VALIDATE_INT);
    $category_id = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
    $type_id = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT);

    // On vérifie l'existence et la validité de ces données (gestion d'erreur).
    $errorList = [];

    if (empty($name)) {
        $errorList[] = 'Le nom est vide';
    }
    if (empty($description)) {
        $errorList[] = 'La description est vide';
    }
    if ($picture === false) {
        $errorList[] = 'L\'URL de l\'image est invalide';
    }
    if ($price === false) {
        $errorList[] = 'Le prix est invalide';
    }
    if ($rate === false) {
        $errorList[] = 'La note est invalide';
    }
    if ($status === false) {
        $errorList[] = 'Le statut est invalide';
    }
    if ($brand_id === false) {
        $errorList[] = 'La marque est invalide';
    }
    if ($category_id === false) {
        $errorList[] = 'La catégorie est invalide';
    }
    if ($type_id === false) {
        $errorList[] = 'Le type est invalide';
    }

    // Si aucune erreur dans les données
    if(empty($errorList)) 
    {
      // On récupère le produit actuellement en BDD
      $product = Product::find($id);

      // On met à jour les propriétés de l'instance.
      $product->setName($name);
      $product->setDescription($description);
      $product->setPicture($picture);
      $product->setPrice($price);
      $product->setRate($rate);
      $product->setStatus($status);
      $product->setBrandId($brand_id);
      $product->setCategoryId($category_id);
      $product->setTypeId($type_id);

      // Il nous reste a sauvegarder ces modif en BDD
      if($product->save())
      {
        // header( "Location: /product/list" );
        header("Location: " . $this->router->generate('product-list'));
        exit;
      }
      else
      {
        $message = "Une erreur est survenue lors de l'édition du produit";
        $this->show("product/edit", ['error' => $message, 'token' => $this->generateToken()]);
      }
    }
    else
    {
      // On affiche chaque erreurs rencontrée
      $product = new Product();

      // On met à jour les propriétés de l'instance pour l'affichage dans le formulaire
      $product->setName($name);
      $product->setDescription($description);
      $product->setPicture($picture);
      $product->setPrice($price);
      $product->setRate($rate);
      $product->setStatus($status);
      $product->setBrandId($brand_id);
      $product->setCategoryId($category_id);
      $product->setTypeId($type_id);

      $productList = Product::findAll();
      $brandList = Brand::findAll();
      $categoryList = Category::findAll();
      $typeList = Type::findAll();

      $message = $errorList;

      $this->show('product/edit', ['productList' => $productList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList, 'product' => $product, 'error' => $message, 'token' => $this->generateToken()]);
    }
  }

  /**
   * Method to delete a product from product's list
   *
   * @param [int] $id
   * @return void
   */
  public function delete($id)
  {
    $product = Product::find($id);  

    if($product->delete())
    {
      // header("Location: /product/list");
      header("Location: " . $this->router->generate('product-list'));
      exit;
    }
    else
    {
      $message = "Echec de la suppression du produit";
      $product = Product::findAll();
    
      $this->show("product/list", ['product' => $product, ['error' => $message, 'token' => $this->generateToken()]]);
    }
  }
}