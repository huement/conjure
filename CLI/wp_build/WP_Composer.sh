#!/usr/bin/env bash

local PROJECT="wordpress-default"

echo ''
cd ../../www
echo 'Installing WP_Vanilla. A Composer backed WordPress stack'
echo 'More info here: http://composer.rarst.net/recipe/site-stack'
composer create-project WP_Vanilla $PROJECT dev-master --repository-url=https://rarst.net --dev
echo ''
cd $PROJECT
echo ''
wp dotenv salts regenerate
echo ''
echo '----- ALL DONE -----'
echo ''
