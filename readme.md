


```
docker-compose up -d

symfony console doctrine:database:create --if-not-exists
symfony console doctrine:migrations:migrate -q
symfony console doctrine:fixtures:load -q 

 yarn install && yarn build
 
 symfony serve
 ```