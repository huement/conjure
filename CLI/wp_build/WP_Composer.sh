#!/usr/bin/env bash

local PROJECT="wordpress-default"

echo ''
cd ../www
echo 'Installing Composer backed WordPress stack'
echo 'More info here: http://composer.rarst.net/recipe/site-stack'
composer create-project rarst/install-test $PROJECT dev-master --repository-url=http://rarst.net --prefer-dist
echo ''
cd $PROJECT
echo ''
wp dotenv salts regenerate
echo ''
echo '----- ALL DONE -----'
echo ''
