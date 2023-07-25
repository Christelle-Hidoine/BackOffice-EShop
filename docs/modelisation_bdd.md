# Modélisation de la base de données oShop

## 5 sortes d'objets dans notre projet (Entité)

- Category : catégories des produits
- Product : Nos produits
- Brand : Les marques des produits
- Type : Les types de produits
- Tag : Les tags de produits
- AppUser : Les utilisateurs du backoffice

Pour chacune de ces entité, on aura une table en BDD.

CATEGORY : category code, name, subtitle, picture, home order
PRODUCT : product code, name, description, picture, price, rate, status
BRAND : brand code, name
TYPE : type code, name [chaussures de ville, sport, pantoufles, etc]
TAG : tag code, tag name
APPUSER : user code, email, password, firstname, lastname, role, status

## MCD

```
CATEGORY: category code, category name, subtitle, picture, home order

TAG: tag code, tag name
is tagged as, 01 PRODUCT, 0N CATEGORY

has, 0N TAG, 0N PRODUCT
PRODUCT: product code, product name, description, picture, price, rate, status
made, 0N BRAND, 11 PRODUCT

TYPE: type code, type name
is a, 0N TYPE, 11 PRODUCT
BRAND: brand code, brand name

APPUSER: appuser code, email, password, firstname, lastname, role, status
```

## MLD

**BRAND** (<ins>brand code</ins>, brand name)

**PRODUCT** (<ins>product code</ins>, product name, description, picture, price, rate, status, _category code_, _brand code_, _type code_)

**CATEGORY** (<ins>category code</ins>, category name, subtitle, picture, home order)

**TYPE** (<ins>type code</ins>, type name)

**TAG** (<ins>tag code</ins>, tag name)

**PRODUCT_HAS_TAG** (<ins>tag code</ins>, <ins>product code</ins>)

**APP_USER** (<ins>app_user code</ins>, email, password, firstname, lastname, role, status)
