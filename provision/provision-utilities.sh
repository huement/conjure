#!/bin/sh
#
#
#
#sh /home/vagrant/bin/xdebug_off
start_seconds="$(date +%s)"
sudo -s

echo ""
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 4 | COMPOSER, Various Utilities, Finalizations                        ||"
echo "---------------------------------------------------------------------------------"
echo ""

#sh /home/vagrant/bin/xdebug_on
sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php7.0-fpm
sudo a2enconf php7.1-fpm
sudo phpenmod mcrypt
sudo service nginx restart

 # make tab complete case insensitive
echo set completion-ignore-case on | tee -a /etc/inputrc

# set up global gitignore
if [ -f ~/.gitignore_global ]; then
  echo "Global Gitignore found!";
else
  echo "Gitignore setup happening.  .   .";
  git config --global core.excludesfile ~/.gitignore_global
  echo ".DS_Store" > ~/.gitignore_global;
fi


echo " ------ [ COMPOSER PACKAGES ] ------ "
# Update both Composer and any global packages. Updates to Composer are direct from
# the master branch on its GitHub repository
echo "Composer updates are always run on provision...."
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction pyrech/composer-changelogs:*
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi self-update --no-progress --no-interaction
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction phpunit/phpunit:6.*
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction phpunit/php-invoker:1.1.*
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction mockery/mockery:0.9.*
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction d11wtq/boris:v1.0.8
#COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction squizlabs/php_codesniffer:*
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction stevegrunwell/wp-enforcer:^0.5.0
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction kilroyweb/homeboy:*
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction aprivette/vvoyage:*
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction inpsyde/Wonolog:*



#COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global require --no-update --no-progress --no-interaction 10up/wpsnapshots:*

COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global config bin-dir /usr/local/bin
COMPOSER_HOME=/usr/local/src/composer composer --no-ansi global update --no-progress --no-interaction


WPCS="/home/vagrant/wpcs"
if [ ! -d "$WPCS" ]; then

  echo "------ [ PHP_CodeSniffer ] ------"

  # Control will enter here if $DIRECTORY doesn't exist.
  mkdir $WPCS
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


# echo "------ [ PHPMyAdmin ] ------"
# if [ ! -f "/home/vagrant/utilities/dbadmin/config.inc.php" ]; then
#   echo "Downloading phpMyAdmin..."
#   sudo mv "/home/vagrant/config/pma.config.inc.php" "home/vagrant/utilities/dbadmin/config.inc.php"
#   sudo chmod 755 /home/vagrant/utilities/dbadmin
#   echo "Finished phpMyAdmin..."
# else
#   echo "phpMyAdmin already configured"
# fi


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


echo "------ [ Finishing Moves ] ------"

# Remove unnecessary packages
echo "Removing unnecessary packages..."
sudo apt-get autoremove -y &>/dev/null

# Clean up apt caches
sudo apt-get clean -y &>/dev/null

echo "------ [ GruntJS ] ------"
# sudo chown -R vagrant:vagrant /usr/lib/node_modules/
# echo "@TODO GRUNT-SASS INSTALLER...."
function program_is_installed {
  # set to 1 initially
  local return_=1
  # set to 0 if not found
  type $1 >/dev/null 2>&1 || { local return_=0; }
  # return value
  echo "$return_"
}

$TESTVAR="$(program_is_installed grunt)"
if [ "$TESTVAR" == 1 ]; then
  echo "Updating Grunt CLI"
  yarn global update grunt-cli node-sass
else
  echo "Installing Grunt CLI"
  yarn global add grunt-cli node-sass
fi

end_seconds="$(date +%s)"
echo " "
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 4 | Completed in "$(( end_seconds - start_seconds ))" seconds.        ||"
echo "|| Provisioning has finished. Ready to Develop!                                ||"
echo "---------------------------------------------------------------------------------"
echo " "
