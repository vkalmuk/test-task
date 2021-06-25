#### Installation guide

Clone the repository. Execute the following commands in the console:

```
docker-compose up -d

symfony console doctrine:database:create --if-not-exists
symfony console doctrine:migrations:migrate -q
symfony console doctrine:fixtures:load -q 

yarn install && yarn build
 
symfony serve
 ```

To view a list of users, go to -- /backend and use

```
login: admin
password: P@ssw0rd
```
