up:
	docker-compose up -d

psalm:
	docker-compose exec php-fpm vendor/bin/psalm

csfix:
	docker-compose exec php-fpm vendor/bin/php-cs-fixer fix

pu:
	docker-compose exec php-fpm bin/phpunit

puf:
	docker-compose exec php-fpm bin/phpunit --filter $(F)

qa:
	make pu csfix psalm