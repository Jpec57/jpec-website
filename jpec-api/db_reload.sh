#!/usr/bin/env bash

bin/console doctrine:database:drop --force
rm -rf src/Migrations/Version*
bin/console doctrine:database:create
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load

