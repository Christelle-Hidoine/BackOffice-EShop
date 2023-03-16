<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;

/**
 * Controller dédié à l'affichage des produits.
 */
class ProductController extends CoreController 
{

  /**
   * Liste des produits
   *
   * @return void
   */
  public function list()
  {
    // On récupère tous les produits
    $products = Product::findAll();
    
    // On les envoie à la vue
    $this->show('product/list', [
      "products" => $products
    ]);
  }

  /**
   * Ajout d'un produit.
   *
   * @return void
   */
  public function add()
  {
    $productList = Product::findAll();
    $brandList = Brand::findAll();
    $categoryList = Category::findAll();
    $typeList = Type::findAll();

    $this->show('product/add', ['productList' => $productList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList]);
  }

  
  

  public function create()
  {
    // On tente de récupèrer les données venant du formulaire.
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

    // Pour le "name", faut vérifier si la chaîne est présente *et* si elle
    // a passé le filtre de validation.
    if (empty($name)) {
        $errorList[] = 'Le nom est vide';
    }
    // Pareil pour la "description".
    if (empty($description)) {
        $errorList[] = 'La description est vide';
    }
    // Pour l'URL de l'image "picture", le filtre vérifie forcément sa présence aussi.
    if ($picture === false) {
        $errorList[] = 'L\'URL d\'image est invalide';
    }
    // Etc.
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
    // NOTE: clairement, ces validations ne sont pas suffisantes
    // (ex. relations par clé étrangère : comment vérifier que les autres ressources
    // existent vraiment ?)

    // S'il n'y a aucune erreur dans les données...
    if(empty($errorList)) 
    {
      // On instancie un nouveau modèle de type Product.
      $product = new Product();

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

      // On tente de sauvegarder les données en DB...
      if($product->insert()) 
      {
        // Si la sauvegarde a fonctionné, on redirige vers la liste des produits.
        header('Location: /product/list');
        exit;
      }
      else 
      {
        echo "Echec de la sauvegarde en BDD";
      }
    }
    else // Sinon, on affiche les erreurs (tel quel, mais on pourra améliorer ça plus tard)
    {
      // On affiche chaque erreurs rencontrée
      foreach( $errorList as $error )
      {
        echo $error . "<br>";
      }
    }
  }

  // Page d'affichage du formulaire d'ajout
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
      "product" => $product, 'productList' => $productList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList, 'typeListById' => $typeListById, 'categoryListById' => $categoryListById, 'brandListById' => $brandListById
    ]);
  }

  // Page de traitement du formulaire d'édition
  public function update($id)
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

    // On vérifie l'existence et la validité de ces données (gestion d'erreur).
    $errorList = [];

    // Pour le "name", faut vérifier si la chaîne est présente *et* si elle
    // a passé le filtre de validation.
    if (empty($name)) {
        $errorList[] = 'Le nom est vide';
    }
    // Pareil pour la "description".
    if (empty($description)) {
        $errorList[] = 'La description est vide';
    }
    // Pour l'URL de l'image "picture", le filtre vérifie forcément sa présence aussi.
    if ($picture === false) {
        $errorList[] = 'L\'URL d\'image est invalide';
    }
    // Etc.
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
    // NOTE: clairement, ces validations ne sont pas suffisantes
    // (ex. relations par clé étrangère : comment vérifier que les autres ressources
    // existent vraiment ?)

    // S'il n'y a aucune erreur dans les données...
    if(empty($errorList)) 
    {
      // On commence par récupérer le produit actuellement en BDD
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
        header( "Location: /product/list" );
        exit;
      }
      else
      {
        echo "Une erreur est survenue lors de l'édition du produit";
      }
    }
    else
    {
      // On affiche chaque erreurs rencontrée
      foreach($errorList as $error)
      {
        echo $error . "<br>";
      }
    }
  }

  public function delete($id)
  {
    $product = Product::find($id);  

    if( $product->delete() )
    {
      header( "Location: /product/list" );
      exit;
    }
    else
    {
      echo "Echec de la suppression du produit";
    }
  }
}