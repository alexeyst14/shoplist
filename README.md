Installation guide:

1) clone/download git repository

2) download composer (http://getcomposer.org/)

3) install dependencies: php composer.phar install

4) edit db config /app/config/parameters.yml

5) php app/console doctrine:schema:update --force
