.PHONY: install release

test:
	vendor/bin/phpunit

coverage:
	vendor/bin/phpunit --coverage-clover 'build/coverage.xml'

analyze:
	vendor/bin/psalm

release:
	php release