
# TP todo app Raphaël Boucheron



## Démarer le projet 

Créer la base de données :

``` Docker compose up --build```

Faire les migrations et ajouter des données :

``` php bin/console doctrine:migrations:migrate  ```

```  php bin/console doctrine:fixtures:load   ```

Ensuite, démarrer l'application Symfony :

``` symfony server:start```


## Api endpoints

Récupérer toutes les tâches :
```
GET /api/tasks
```

Récupérer une tâche via son ID :

```
GET /api/task/{id}
```

Crée une tâche : 

```
POST /api/task
``` 

Modifier une tâche : 
```
PUT /api/task/{id}
```

Supprimer une tâche : 

``` 
DELETE /api/task/{id}

```
