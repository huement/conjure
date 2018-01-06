#!/usr/bin/env bash

PROJECT="bedrock"
  THEME="myriad_sage"

echo ''
cd ../../www
echo 'Installing modern WordPress stack [12-Factor App]'
echo 'More info here: https://github.com/roots/bedrock'
composer create-project roots/bedrock $PROJECT
echo ''
cd $PROJECT
echo 'Environment Variables'
echo 'More info here: https://github.com/aaemnnosttv/wp-cli-dotenv-command'
wp package install aaemnnosttv/wp-cli-dotenv-command
echo ''
wp dotenv salts regenerate
echo ''
echo 'Installing SAGE Theme'
echo 'More info here: https://github.com/roots/sage'
echo ''
echo 'During theme installation you will have the options to:'
echo '  * Update theme name, description, author, etc.'
echo '  * Select a CSS framework (Bootstrap, Bulma, Foundation, Tachyons, none)'
echo '  * Add Font Awesome'
echo '  * Configure Browsersync'
echo ''
composer create-project roots/sage $THEME dev-master
echo ''
echo ''
echo ''
echo ''
echo '----- ALL DONE -----'
echo ''
