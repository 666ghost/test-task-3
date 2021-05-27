
## **Deploying:**

0. Copy .env.example to .env
2. Run containers: `docker-compose up -d`
3. Open php-fpm terminal: `docker exec -it test-task_php-fpm bash`
4. Run: `composer install`
5. Run: `php artisan migrate --seed`
6. Open node terminal: `docker exec -it test-task_node bash`
7. Install packages: `npm i`
8.  Build frontend: `npm run prod`

**

`API_SEARCH_COUNTRY` -  this variable designates the country by which the search for universities will be entered(Turkey, Germany and France tested)
