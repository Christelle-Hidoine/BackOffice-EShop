<?php
namespace App\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;

class CatalogController extends CoreController
{

    //----------------------------- CATEGORY ---------------------------------------

    /**
     * Method to display the category_list's template
     */
    public function categoryList()
    {
       //affichage de la liste des catégories 
       $categoryList = Category::findAll();

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
        // ------------------------------------------ GESTION DES ERREURS via un tableau -----------------------------------------------------
            // On doit vérifier que $_POST n'est pas vide et contient bien les clés
            // les clés sont données par la valeur des attributs name des champs du form
            // nos clés : name, subtitle et picture
        // if (!empty($_POST)) {

                // On peut passer directement la string de l'attribut name car on utilise la fonction
                // PHP filter_input
            // $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            // $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
            // $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);

            // TODO
                // On doit gérer les éventuelles erreurs
                // On créer un array (vide) qui stockera les erreurs
            // $errorList = [];

            // On ne fait jamais confiance à l'utilisateur
            // On va vérifier pour chaque champ si :
                // - le champ n'est pas null
                // - et le champ est valide : si le champ ne passe pas le test du filter_input (via le 3ème argument FILTER_SANITIZE_...) alors filter_input renvoie "false"

            // if (empty($name)) {
            //     $errorList[] = 'Merci de renseigner le nom de la catégorie';
            // }

            // if ($name === false) {
            //     $errorList[] = 'Merci de renseigner un nom valide';
            // }

            // if (empty($subtitle)) {
            //     $errorList[] = 'Merci de renseigner le sous-titre de la catégorie';
            // }

            // if ($subtitle === false) {
            //     $errorList[] = 'Merci de renseigner un sous-titre valide';
            // }

            // if (empty($picture)) {
            //     $errorList[] = 'Merci de renseigner l\'image de la catégorie';
            // }

            // if ($picture === false) {
            //     $errorList[] = 'Merci de renseigner une image valide';
            // }

                // Avant de créer la nouvelle catégorie, on doit vérfier si on a eu une ou plusieurs erreurs
                // cad si $errorList n'est pas vide

            // if (empty($errorList)) {
                // On utilise le model pour interagir avec la BDD
                // $modelCategory = new Category();

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

            // on passe notre méthode insert à notre objet category -> return un bool true or false
            // $isInsert contient un booléen (true / false)
            $isInsert = $category->insert();

            // Si l'insertion est OK => redirection vers category/list
            if ($isInsert) {
                // Redirection vers category/list
                // on redirige vers la page category-list une fois le formulaire soumis
                header('Location: category-list');
            } else {
                echo '<script type="text/javascript">';
                echo ' alert("Le formulaire n\'a pas été soumis, merci de compléter les champs obligatoires avec les bonnes données")';
                echo '</script>';

                // ---------------------------------- SUITE GESTION DES ERREURS via un tableau--------------------------------
                    // Sinon => message d'erreur et redirection vers le form (pas besoin ici car notre attribut action du form est vide, et donc on reste sur la page)
                // $errorList[] = 'La création de la catégorie a échoué';
            };
            // else {
                // Ici, on a au moins une erreur
                // On reste sur le formulaire et on souhaite transmettre à show() les champs saisis et les erreurs obtenues
                // Pour que plus tard, le template récupère ces données pour :
                // - pré-remplir les input du form avec les données qui ont été saisies
                // - afficher les erreurs
                
                    // 1. On instancie un model Catégory
                // $modelCategory = new Category();

                    // 2. On sette les propriétés de Category
                // $modelCategory->setName($name);
                // $modelCategory->setSubtitle($subtitle);
                // $modelCategory->setPicture($picture);

                    // 3. On appelle la méthode show() en lui passanrt les données (cad valeurs des champs + erreur(s))
                // $this->show('category/category-add', [
                //     'category' => $modelCategory,
                //     'errors' => $errorList
                // ]);

            // }
        }
                
                $this->show('catalog/category_add');
    }

    /**
     * Method to display the category_update's template
     *
     * @param [int] $id
     */
    public function categoryUpdateDisplay($id)
    {
        $categoryModel = new Category;
        $categoryById = $categoryModel->find($id);
        $this->show('catalog/category_update', ['categoryById' => $categoryById]);
        dump($id, $categoryById);
    }

    /**
     * Method to retrieve data from template category_update with the form
     * 
     */
    public function categoryUpdate($id)
    {

        if (!empty($_POST)) {

            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
            $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
            

            // on modifie les valeurs des propriétés correspondantes dans notre model
            $categoryModel = new Category;
            $category = $categoryModel->find($id);
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);

            // on passe notre méthode update à notre objet category -> return un bool true or false
            $category->update();

            
        }
        
        $this->show('catalog/category_update', ['category' => $category]);
        dump($_POST);
    }


    // ----------------------------------- PRODUCT -----------------------------

    /**
     * Method to display the product_list's template
     */
    public function productList()
    {
        //affichage de la liste des produits
        $productList = Product::findAll();

        $this->show('catalog/product_list', ['productList' => $productList]);
    }

    /**
     * Method to display the product_add's template
     */
    public function productAdd()
    {
        $productList = Product::findAll();
        $brandList = Brand::findAll();
        $categoryList = Category::findAll();
        $typeList = Type::findAll();

        $this->show('catalog/product_add', ['productList' => $productList, 'brandList' => $brandList, 'categoryList' => $categoryList, 'typeList' => $typeList]);
    }
    
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