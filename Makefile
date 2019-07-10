.PHONY: install release

test:
	vendor/bin/phpunit

coverage:
	vendor/bin/phpunit --coverage-clover=build/logs/clover.xml

analyze:
	vendor/bin/psalm

release:
	php release