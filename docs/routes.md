# Routes

## Sprint 2

| URL | HTTP Method | Controller | Method | Title | Content | Comment |
|--|--|--|--|--|--|--|
| `/` | `GET` | `MainController` | `home` | Backoffice oShop | Backoffice dashboard | - |
| `/category/list` | `GET`| `CategoryController` | `list` | Liste des catégories | Categories list | - |
| `/category/add` | `GET`| `CategoryController` | `add` | Ajouter une catégorie | Form to add a category | - |
| `/category/add` | `POST`| `CategoryController` | `create` | Ajouter une catégorie | Form to add a category | - |
| `/category/[i:id]/update` | `GET`| `CategoryController` | `edit` | Éditer une catégorie | Form to update a category | [i:id] is the category to update |
| `/category/[i:id]/update` | `POST`| `CategoryController` | `update` | Éditer une catégorie | Form to update a category | [i:id] is the category to update |
| `/category/[i:id]/delete` | `GET`| `CategoryController` | `delete` | Supprimer une catégorie |
 Category delete | [i:id] is the category to delete |
| `/category/home` | `GET`| `CategoryController` | `homeList` | Gestion de la page d'accueil | Categories list homepage | - |
| `/category/home` | `POST`| `CategoryController` | `homeSelect` | Gestion de la page d'accueil | Categories list homepage | - |
| `/brand/list` | `GET`| `BrandController` | `list` | Liste des marques | Brand list | - |
| `/brand/add` | `GET`| `BrandController` | `add` | Ajouter une marque | Form to add a brand | - |
| `/brand/add` | `POST`| `BrandController` | `createOrEdit` | Ajouter une marque | Form to add a brand | - |
| `/brand/add/[i:id]` | `GET`| `BrandController` | `edit` | Éditer une marque | Form to update a brand | [i:id] is the brand to update |
| `/brand/add/[i:id]` | `POST`| `BrandController` | `createOrEdit` | Éditer une marque | Form to update a brand | [i:id] is the brand to update |
| `/brand/[i:id]/delete` | `GET`| `BrandController` | `delete` | Supprimer une marque | Brand delete | [i:id] is the brand to delete |
| `/product/list` | `GET`| `ProductController` | `list` | Liste des produits | Categories list | - |
| `/product/add` | `GET`| `ProductController` | `add` | Ajouter un produit | Form to add a product | - |
|`/product/add` | `POST`| `ProductController` | `create` | Ajouter un produit | Form to add a product | - |
| `/product/[i:id]/update` | `GET`| `ProductController` | `edit` | Éditer un produit | Form to update a product | [i:id] is the product to update |
| `/product/[i:id]/update` | `POST`| `ProductController` | `update` | Éditer un produit | Form to update a product | [i:id] is the product to update |
| `/product/[i:id]/delete` | `GET`| `ProductController` | `delete` | Supprimer un produit | Product delete | [i:id] is the product to delete |
| `/type/list` | `GET`| `TypeController` | `list` | Liste des types | Types list | - |
| `/type/add` | `GET`| `TypeController` | `add` | Ajouter un type | Form to add a type | - |
| `/type/add` | `POST`| `TypeController` | `createOrEdit` | Ajouter un type | Form to add a type | - |
| `/type/[i:id]/update` | `GET`| `TypeController` | `update` | Éditer un type | Form to update a type | [i:id] is the type to update |
| `/type/[i:id]/delete` | `GET`| `TypeController` | `delete` | Supprimer un type | Type delete | [i:id] is the type to delete |
| `/user/list` | `GET`| `AppUserController` | `list` | Liste des utilisateurs | Users list | - |
| `/user/connection` | `GET`| `AppUserController` | `connect` | Connexion des utilisateurs | Users login | - |
| `/user/connection` | `POST`| `AppUserController` | `check` | Connexion des utilisateurs | Users login | - |
| `/user/add` | `GET`| `AppUserController` | `add` | Ajouter un utilisateur | Form to add a user | - |
| `/user/add` | `POST`| `AppUserController` | `create` | Ajouter un utilisateur | Form to add a user | - |
| `/user/[i:id]/update` | `GET`| `AppUserController` | `edit` | Éditer un utilisateur | Form to update a user | [i:id] is the user to update |
| `/user/[i:id]/update` | `POST`| `AppUserController` | `update` | Éditer un utilisateur | Form to update a user | [i:id] is the user to update |
| `/user/[i:id]/delete` | `GET`| `AppUserController` | `delete` | Supprimer un utilisateur | User delete | [i:id] is the user to delete |
| `/user/logout` | `GET`| `AppUserController` | `logout` | Déconnexion des utilisateurs | Users logout | - |