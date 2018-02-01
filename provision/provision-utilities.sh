#!/usr/bin/env bash

#
#
#
#sh /home/vagrant/bin/xdebug_off
start_seconds="$(date +%s)"

echo ""
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 4 | COMPOSER, Various Utilities, Finalizations                        ||"
echo "---------------------------------------------------------------------------------"
echo ""

#sh /home/vagrant/bin/xdebug_on
# sudo a2enmod proxy_fcgi setenvif
# sudo a2enconf php7.0-fpm
# sudo a2enconf php7.1-fpm
# sudo phpenmod mcrypt
# sudo service nginx restart

# set up global gitignore
if [ -f /home/vagrant/.gitignore_global ]; then
  echo "Global Gitignore found!"
else
  echo "Gitignore setup happening.  .   ."
  git config --global core.excludesfile /home/vagrant/.gitignore_global
  echo ".DS_Store" > /home/vagrant/.gitignore_global
fi

MICRO="/usr/local/bin/micro"
if [ ! -f "$MICRO"]; then
  echo " ----- [ MICRO EDITOR ] ----- "
  cd /home/vagrant
  curl https://getmic.ro | bash
  sudo mv ./micro /usr/local/bin/
fi;


echo " ------ [   COMPOSER   ] ------ "

# @TODO Grab the readmes from these and put in the docs.
export COMPOSER_HOME=/home/vagrant/.cache/composer
composer --no-ansi global require --no-update --no-progress --no-interaction "pyrech/composer-changelogs:*"
composer --no-ansi global require --no-update --no-progress --no-interaction "phpunit/phpunit:6.*"
composer --no-ansi global require --no-update --no-progress --no-interaction "phpunit/php-invoker:1.1.*"
composer --no-ansi global require --no-update --no-progress --no-interaction "mockery/mockery:0.9.*"
composer --no-ansi global require --no-update --no-progress --no-interaction "d11wtq/boris:v1.0.8"
composer --no-ansi global require --no-update --no-progress --no-interaction "stevegrunwell/wp-enforcer:^0.5.0"
composer --no-ansi global require --no-update --no-progress --no-interaction "kilroyweb/homeboy:*"
composer --no-ansi global require --no-update --no-progress --no-interaction "aprivette/vvoyage:*"
composer --no-ansi global require --no-update --no-progress --no-interaction "inpsyde/Wonolog:*"
composer --no-ansi global config bin-dir /usr/local/bin
composer --no-ansi global update --no-progress --no-interaction

echo "Updating Composer permissions....................."
sudo chown -R vagrant:vagrant /home/vagrant/.composer


echo "------ [ PHP_CodeSniffer ] ------"
WPCS="/home/vagrant/wpcs"
if [ ! -d "$WPCS" ]; then

  echo "Fresh install in the works......................."

  # Control will enter here if $DIRECTORY doesn't exist.
  mkdir -p $WPCS
  cd $WPCS
  git clone https://github.com/squizlabs/PHP_CodeSniffer.git phpcs
  git clone -b master https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards.git wpcs
  cd phpcs

  #PHPCS 2.x
  if [ -f "./scripts/phpcs" ]; then
    ./scripts/phpcs --config-set installed_paths ../wpcs
  fi

  #PHPCS 3.x
  if [ -f "./bin/phpcs" ]; then
    ./bin/phpcs --config-set installed_paths ../wpcs
  fi

else
  echo "PHP_CodeSniffer already setup and configured!"
fi

# VVoyage | https://github.com/aprivette/vvoyage
# - `vvoyage env:create` - Creates a new Wordmove environment in the site's Movefile.
# - `vvoyage env:delete` - Deletes a Wordmove enviroment
# - `vvoyage site:create` - Adds a new site config to vvv-custom.yml
# - `vvoyage site:delete` - Deletes a site config from vvv-custom.yml, deletes the site's folder, and drops the database
# - `vvoyage site:migrate` - Pushes or pulls a site from a specified environment

#
# Graphviz
#
# Set up a symlink between the Graphviz path defined in the default Webgrind
# config and actual path.
echo "Adding graphviz symlink for Webgrind..."
sudo ln -sf "/usr/bin/dot" "/usr/local/bin/dot"

#
# Shyaml
#
# Used for passing custom parameters to the bash provisioning scripts
echo "------ [ Python ] ------"
pip install --upgrade pip
pip install shyaml

function program_is_installed {
  # set to 1 initially
  local return_=1
  # set to 0 if not found
  type $1 >/dev/null 2>&1 || { local return_=0; }
  # return value
  echo "$return_"
}

echo " "
echo " ------ [ WP CLI ] ------ "

# WP-CLI Install

# Remove old wp-cli symlink, if it exists.
# if [ -L "/usr/local/bin/wp" ]; then
# 	echo "\nRemoving old wp-cli"
# 	rm -f /usr/local/bin/wp
# fi
#
TESTWVAR="$(program_is_installed wp)"

if [[ "$TESTWVAR" == 0 ]]; then
  echo "Downloading wp-cli, see http://wp-cli.org"
  curl -sO https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli-nightly.phar
  chmod +x wp-cli-nightly.phar
  sudo mv wp-cli-nightly.phar /usr/local/bin/wp

  # Install bash completions
  mkdir -p /home/vagrant/.wp-cli
  sudo cp -R /home/vagrant/config/wp-cli/* /home/vagrant/.wp-cli
  #curl -s https://raw.githubusercontent.com/wp-cli/wp-cli/master/utils/wp-completion.bash -o /home/vagrant/.wp-cli/wp-completion.bash
  #sudo cp /home/vagrant/config/wp-cli/wp-completion.bash /home/vagrant/.wp-cli/wp-completion.bash

  /usr/local/bin/wp package install aaemnnosttv/wp-cli-dotenv-command:1.0.*

else
  echo "Updating wp-cli..."
  cd /home/vagrant/.wp-cli/packages
  composer install
fi

# make tab complete case insensitive
echo set completion-ignore-case on | tee -a /etc/inputrc

end_seconds="$(date +%s)"
echo " "
echo "---------------------------------------------------------------------------------"
echo "   STAGE 4 / 4 "
echo "   Completed in $((end_seconds - start_seconds)) seconds "
echo " "
echo "   SUCCESS! PROVISIONING HAS FINSIHED!"
echo "---------------------------------------------------------------------------------"
echo " "
