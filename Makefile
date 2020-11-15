test:
	vendor/bin/phpunit

coverage:
	vendor/bin/phpunit --coverage-clover=build/logs/clover.xml

analyze:
	vendor/bin/psalm --show-info=true