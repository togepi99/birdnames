#!/bin/bash

./bin/console doctrine:database:drop --force -e test
./bin/console doctrine:database:create -e test
./bin/console doctrine:schema:update --force -e test