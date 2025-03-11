
# TP todo app Raphaël Boucheron



## Démarer le projet 

crée la base de données : 

``` Docker compose up --build```

Faire les migrations et ajouter des données : 

``` php bin/console doctrine:migrations:migrate  ```

```  php bin/console doctrine:fixtures:load   ```

Ensuite démarer l'application symfony : 

``` symfony server:start```
