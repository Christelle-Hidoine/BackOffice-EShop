# Requêtes SQL many to many

## Récupération de tous les noms de product à partir de l'id product

On fait correspondre l'id product de la table product avec l'id de la table product_has_tag

```sql
SELECT tag.name AS tag_name, product.name AS product_name, product.id AS product_id
FROM tag
INNER JOIN product ON product.id = tag.id
```

```sql
SELECT * FROM product INNER JOIN product_has_tag ON product.id = product_has_tag.product_id
```
