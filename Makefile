.PHONY: deploy

deploy:
	git pull origin main
	composer install
	composer dump-autoload
	npm install
	npm run build
	php artisan optimize:clear
	php artisan migrate
	php artisan serve --host=$$(hostname -I | awk '{print $$1}')

refresh:
	git pull origin main
	npm run build
	composer dump-autoload
	php artisan migrate