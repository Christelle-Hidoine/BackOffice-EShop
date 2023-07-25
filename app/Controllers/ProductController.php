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

    $products = Product::findAll();

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
    $tagList = Tag::findAll();

    $this->show('product/add', ['productList' => $productList, 'tagList' =>$tagList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList, 'product' => new Product, 'token' => $this->generateToken()]);
  }
  
  /**
   * Method to retrieve data from product's add form
   *
   * @return void
   */
  public function create()
  {
    $name        = filter_input(INPUT_POST, 'name',        FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $picture     = filter_input(INPUT_POST, 'picture',     FILTER_VALIDATE_URL);
    $price       = filter_input(INPUT_POST, 'price',       FILTER_VALIDATE_FLOAT);
    $rate        = filter_input(INPUT_POST, 'rate',        FILTER_VALIDATE_INT);
    $status      = filter_input(INPUT_POST, 'status',      FILTER_VALIDATE_INT);
    $brand_id    = filter_input(INPUT_POST, 'brand',       FILTER_VALIDATE_INT);
    $category_id = filter_input(INPUT_POST, 'category',    FILTER_VALIDATE_INT);
    $type_id     = filter_input(INPUT_POST, 'type',        FILTER_VALIDATE_INT);
    
    $tag_ids = []; 
    foreach ($_POST['tag'] as $tag_id)
      {
        $tag_id = filter_var($tag_id, FILTER_VALIDATE_INT);
        if ($tag_id !== false) {
          $tag_ids[] = $tag_id;
        }
      }

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
    if ($tag_id === false) {
      $errorList[] = 'Le tag est invalide';
    }
  
    if(empty($errorList)) 
    {
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

      if($product->insert()) 
      {
        $product_id = $product->getId();
        foreach ($tag_ids as $tag_id) {
          $product->setTagId($tag_id);
          $product->setProductId($product_id);
          $product->insertTagProduct();
        }

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

      $productList = Product::findAll();
      $brandList = Brand::findAll();
      $categoryList = Category::findAll();
      $typeList = Type::findAll();
      $tagList = Tag::findAll();

      $message = $errorList;

      $this->show('product/add', ['productList' => $productList, 'tagList' => $tagList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList, 'product' => $product, 'error' => $message, 'token' => $this->generateToken()]);
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
    $tagList = Tag::findAll();

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
    $tagListById = [];
        foreach ($tagList as $tagElement) {
          $tagListById[$tagElement->getId()] = $tagElement;
        }

    $this->show("product/edit", [ 
      "product" => $product, 'productList' => $productList, 'tagList' => $tagList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList, 'tagListById' => $tagListById, 'typeListById' => $typeListById, 'categoryListById' => $categoryListById, 'brandListById' => $brandListById,  'token' => $this->generateToken()
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

    $tag_ids = []; 
    foreach ($_POST['tag'] as $tag_id)
      {
        $tag_id = filter_var($tag_id, FILTER_VALIDATE_INT);
        if ($tag_id !== false) {
          $tag_ids[] = $tag_id;
        }
      }

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
    if ($tag_id === false) {
      $errorList[] = 'Le tag est invalide';
    }

    if(empty($errorList)) 
    {
      $product = Product::find($id);

      $product->setName($name);
      $product->setDescription($description);
      $product->setPicture($picture);
      $product->setPrice($price);
      $product->setRate($rate);
      $product->setStatus($status);
      $product->setBrandId($brand_id);
      $product->setCategoryId($category_id);
      $product->setTypeId($type_id);

      $product_tag = $product->findTagsByProductId($id);
      $tagsInProduct = [];
      foreach ($product_tag as $tag)
      {
        if ($tag !== false) {
          $tagsInProduct[] = $tag->getId();
        }
      }
      
      if($product->save())
      {
        $tagsToAdd = array_diff($tag_ids, $tagsInProduct);
        $tagsToRemove = array_diff($tagsInProduct, $tag_ids);

        foreach ($tagsToAdd as $tag_id) {
          $product->setProductId($id);
          $product->setTagId($tag_id);
          $product->insertTagProduct();
        }
        foreach ($tagsToRemove as $tag_id) {
          $product->setTagId($tag_id);
          $product->setProductId($id);
          $product->deleteTagProduct();
      }
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
      $product->deleteTagProduct();
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