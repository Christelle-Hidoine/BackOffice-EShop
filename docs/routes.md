# Routes

## Sprint 1

| URL | HTTP Method | Controller | Method | Title | Content | Comment |
|--|--|--|--|--|--|--|
| `/` | `GET` | `MainController` | `home` | oShop BackOffice | display 3 categories and 3 products | - |
| `/category-list` | `GET` | `CatalogController` | `categoryList` | Liste des Catégories | display all categories | - |
| `/category-add` | `GET` | `CatalogController` | `categoryAdd` | Ajouter une catégorie | form to add new categories | - |
| `/category-add` | `POST` | `CatalogController` | `categoryCreate` | Ajouter une catégorie | retrieve and send form field completed to DB oshop | - |
| `/category-update/[i:categoryId]` | `GET`| `CatalogController` | `categoryUpdate` | Éditer une catégorie | Form to update a category | [i:categoryId] is the category to update |
| `/category-delete/[i:categoryId]` | `GET`| `CatalogController` | `categoryDelete` | Supprimer une catégorie | Category delete | [i:categoryId] is the category to delete |
| `/product-list` | `GET` | `CatalogController` | `productList` | Liste des Produits | display all products | - |
| `/product-add` | `GET` | `CatalogController` | `productAdd` | Ajouter un produit | form to add new products | - |
| `/product-add` | `POST` | `CatalogController` | `productCreate` | Ajouter un produit | retrieve and send form field completed to DB oshop | - |
| `/product-update/[i:productId]` | `GET`| `CatalogController` | `update` | Éditer un produit | Form to update a product | [i:productId] is the product to update |
| `/product-delete/[i:productId]` | `GET`| `CatalogController` | `delete` | Supprimer un produit | Product delete | [i:productId] is the product to delete |
