#!/bin/bash
#
# By storing the date now, we can calculate the duration of provisioning at the
# end of this script.
start_seconds="$(date +%s)"
#sh /home/vagrant/bin/xdebug_off
sudo -s

echo ""
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 3 | Developer Tools + Wordpress Optimizations                         ||"
echo "---------------------------------------------------------------------------------"
echo ""

# PACKAGE INSTALLATION
#
# Build a bash array to pass all of the packages we want to install to a single
# apt-get command. This avoids doing all the leg work each time a package is
# set to install. It also allows us to easily comment out or add single
# packages. We set the array as empty to begin with so that we can append
# individual packages to it as required.
apt_package_install_list=()

# Start with a bash array containing all packages we want to install in the
# virtual machine. We'll then loop through each of these and check individual
# status before adding them to the apt_package_install_list array.
apt_package_check_list=(
  # Please avoid apostrophes in these comments - they break vim syntax
  # highlighting.

  # PHP7
  #
  # Our base packages for php7.0. As long as php7.0-fpm and php7.0-cli are
  # installed, there is no need to install the general php7.0 package, which
  # can sometimes install apache as a requirement.
  php7.0-fpm
  php7.0-cli
  php7.1-fpm
  php7.1-cli
  php7.2-fpm
  php7.2-cli

  # Common and dev packages for php
  php7.0-common
  php7.0-dev
  php7.1-common
  php7.1-dev

  libpcre3

  # Extra PHP modules that we find useful
  #php-pear
  php-imagick
  php-ssh2
  #php-xdebug

  php7.0-bcmath
  php7.0-gd
  php7.0-mcrypt
  php7.0-zip

  php7.1-bcmath
  php7.1-gd
  php7.1-mcrypt
  php7.1-zip

  php7.2-bcmath
  php7.2-gd
  php7.2-zip

  zip
  ngrep
  curl
  make
  vim
  colordiff
  python-pip

  # ntp service to keep clock current
  ntp

  # Required for i18n tools
  gettext

  # Required for Webgrind
  graphviz

  # dos2unix
  # Allows conversion of DOS style line endings to something less troublesome
  # in Linux.
  dos2unix

  # nodejs for use by grunt
  g++
  #nodejs

  # Mailcatcher requirement
  libsqlite3-dev

)

### FUNCTIONS

network_detection() {
  # Network Detection
  #
  # Make an HTTP request to google.com to determine if outside access is available
  # to us. If 3 attempts with a timeout of 5 seconds are not successful, then we'll
  # skip a few things further in provisioning rather than create a bunch of errors.
  if [[ "$(wget --tries=3 --timeout=5 --spider --recursive --level=2 http://google.com 2>&1 | grep 'connected')" ]]; then
    echo "Network connection detected..."
    ping_result="Connected"
  else
    echo "Network connection not detected. Unable to reach google.com..."
    ping_result="Not Connected"
  fi
}

network_check() {
  network_detection
  if [[ ! "$ping_result" == "Connected" ]]; then
    echo -e "\nNo network connection available, skipping package installation"
    exit 0
  fi
}

noroot() {
  sudo -EH -u "vagrant" "$@";
}

profile_setup() {

  # If a bash_prompt file exists in the VVV config/ directory, copy to the VM.
  if [[ -f "/home/vagrant/config/bash_prompt" ]]; then
    cp "/home/vagrant/config/bash_prompt" "/home/vagrant/.bash_prompt"
    echo " * Copied /home/vagrant/config/bash_prompt to /home/vagrant/.bash_prompt"
  fi

  if [[ -f "/home/vagrant/config/bash_aliases" ]]; then
    cp "/home/vagrant/config/bash_aliases" "/home/vagrant/.bash_aliases"
    echo " * Copied /home/vagrant/config/bash_aliases to /home/vagrant/.bash_aliases"
  fi

  if [[ -f "/home/vagrant/config/bash_profile" ]]; then
    cp "/home/vagrant/config/bash_profile" "/home/vagrant/.bash_profile"
    echo " * Copied /home/vagrant/config/bash_profile to /home/vagrant/.bash_profile"
  fi
}

not_installed() {
  dpkg -s "$1" 2>&1 | grep -q 'Version:'
  if [[ "$?" -eq 0 ]]; then
    apt-cache policy "$1" | grep 'Installed: (none)'
    return "$?"
  else
    return 0
  fi
}

print_pkg_info() {
  local pkg="$1"
  local pkg_version="$2"
  local space_count
  local pack_space_count
  local real_space

  space_count="$(( 20 - ${#pkg} ))" #11
  pack_space_count="$(( 30 - ${#pkg_version} ))"
  real_space="$(( space_count + pack_space_count + ${#pkg_version} ))"
  printf " * $pkg %${real_space}.${#pkg_version}s ${pkg_version}\n"
}

package_check() {
  # Loop through each of our packages that should be installed on the system. If
  # not yet installed, it should be added to the array of packages to install.
  local pkg
  local pkg_version

  for pkg in "${apt_package_check_list[@]}"; do
    if not_installed "${pkg}"; then
      echo " *" "$pkg" [not installed]
      apt_package_install_list+=($pkg)
    else
      pkg_version=$(dpkg -s "${pkg}" 2>&1 | grep 'Version:' | cut -d " " -f 2)
      print_pkg_info "$pkg" "$pkg_version"
    fi
  done
}

package_install() {
  package_check

  if [[ ${#apt_package_install_list[@]} = 0 ]]; then
    echo -e "No apt packages to install.\n"
  else
    # Before running `apt-get update`, we should add the public keys for
    # the packages that we are installing from non standard sources via
    # our appended apt source.list

    # Install required packages
    echo "Installing apt-get packages..."
    apt-get -y --force-yes install ${apt_package_install_list[@]}

  fi
}

# NODE TOOLS
tools_install() {
  # Disable xdebug before any composer provisioning.
  #sh /home/vagrant/bin/xdebug_off

  # nvm
  if [[ ! -d "/srv/config/nvm" ]]; then
    echo -e "\nDownloading nvm, see https://github.com/creationix/nvm"
    git clone "https://github.com/creationix/nvm.git" "/srv/config/nvm"
    cd /srv/config/nvm
    git checkout `git describe --abbrev=0 --tags --match "v[0-9]*" origin`
  else
    echo -e "\nUpdating nvm..."
    cd /srv/config/nvm
    git fetch origin
    git checkout `git describe --abbrev=0 --tags --match "v[0-9]*" origin` -q
  fi
  # Activate nvm
  source /srv/config/nvm/nvm.sh

  # npm
  #
  # Make sure we have the latest npm version and the update checker module
  echo "Installing/updating npm..."
  npm install -g npm
  echo "Installing/updating npm-check-updates..."
  npm install -g npm-check-updates

  # ack-grep
  #
  # Install ack-rep directory from the version hosted at beyondgrep.com as the
  # PPAs for Ubuntu Precise are not available yet.
  if [[ -f /usr/bin/ack ]]; then
    echo "ack-grep already installed"
  else
    echo "Installing ack-grep as ack"
    curl -s https://beyondgrep.com/ack-2.16-single-file > "/usr/bin/ack" && chmod +x "/usr/bin/ack"
  fi

  # @TODO Add in option for setting Github Token
  # if [[ -f /vagrant/provision/github.token ]]; then
  #   ghtoken=`cat /vagrant/provision/github.token`
  #   composer config --global github-oauth.github.com $ghtoken
  #   echo "Your personal GitHub token is set for Composer."
  # fi
}

phpfpm_setup() {
  # Copy php-fpm configuration from local
  cp "/home/vagrant/config/php-config/php7.0-fpm.conf" "/etc/php/7.0/fpm/php-fpm.conf"
  cp "/home/vagrant/config/php-config/php7.0-www.conf" "/etc/php/7.0/fpm/pool.d/www.conf"
  cp "/home/vagrant/config/php-config/php7.0-custom.ini" "/etc/php/7.0/fpm/conf.d/php-custom.ini"

  cp "/home/vagrant/config/php-config/php7.1-fpm.conf" "/etc/php/7.1/fpm/php-fpm.conf"
  cp "/home/vagrant/config/php-config/php7.1-www.conf" "/etc/php/7.1/fpm/pool.d/www.conf"
  cp "/home/vagrant/config/php-config/php7.1-custom.ini" "/etc/php/7.1/fpm/conf.d/php-custom.ini"

  cp "/home/vagrant/config/php-config/php7.2-fpm.conf" "/etc/php/7.2/fpm/php-fpm.conf"
  cp "/home/vagrant/config/php-config/php7.2-www.conf" "/etc/php/7.2/fpm/pool.d/www.conf"
  cp "/home/vagrant/config/php-config/php7.2-custom.ini" "/etc/php/7.2/fpm/conf.d/php-custom.ini"

  cp "/home/vagrant/config/php-config/opcache.ini" "/etc/php/7.0/fpm/conf.d/opcache.ini"
  #cp "/home/vagrant/config/php-config/xdebug.ini" "/etc/php/7.0/mods-available/xdebug.ini"

  cp "/home/vagrant/config/php-config/opcache.ini" "/etc/php/7.1/fpm/conf.d/opcache.ini"
  #cp "/home/vagrant/config/php-config/xdebug.ini" "/etc/php/7.1/mods-available/xdebug.ini"

  cp "/home/vagrant/config/php-config/opcache.ini" "/etc/php/7.2/fpm/conf.d/opcache.ini"
  #cp "/home/vagrant/config/php-config/xdebug.ini" "/etc/php/7.2/mods-available/xdebug.ini"

  echo " * PHP 7 [ 7.0 , 7.1 , 7.2 ] Configurations ---------------------------------------------------------"
  echo " * Copied /home/vagrant/config/php-config/php7.X-fpm.conf   to /etc/php/7.X/fpm/php-fpm.conf"
  echo " * Copied /home/vagrant/config/php-config/php7.X-www.conf   to /etc/php/7.X/fpm/pool.d/www.conf"
  echo " * Copied /home/vagrant/config/php-config/php7.X-custom.ini to /etc/php/7.X/fpm/conf.d/php-custom.ini"
  echo " * Copied /home/vagrant/config/php-config/opcache.ini       to /etc/php/7.X/fpm/conf.d/opcache.ini"
  #echo " * Copied /home/vagrant/config/php-config/xdebug.ini        to /etc/php/7.X/mods-available/xdebug.ini"

  # Copy memcached configuration from local
  cp "/home/vagrant/config/memcached-config/memcached.conf" "/etc/memcached.conf"
  cp "/home/vagrant/config/memcached-config/memcached.conf" "/etc/memcached_default.conf"

  echo " * Copied /home/vagrant/config/memcached-config/memcached.conf to /etc/memcached.conf and /etc/memcached_default.conf"
}

mysql_setup() {
  # If MariaDB/MySQL is installed, go through the various imports and service tasks.
  local exists_mysql

  exists_mysql="$(service mysql status)"
  if [[ "mysql: unrecognized service" != "${exists_mysql}" ]]; then
    echo -e "\nSetup MySQL configuration file links..."

    # Copy mysql configuration from local
    cp "/home/vagrant/config/mysql-config/my.cnf" "/etc/mysql/my.cnf"
    cp "/home/vagrant/config/mysql-config/root-my.cnf" "/home/vagrant/.my.cnf"

    echo " * Copied /home/vagrant/config/mysql-config/my.cnf               to /etc/mysql/my.cnf"
    echo " * Copied /home/vagrant/config/mysql-config/root-my.cnf          to /home/vagrant/.my.cnf"

    # MySQL gives us an error if we restart a non running service, which
    # happens after a `vagrant halt`. Check to see if it's running before
    # deciding whether to start or restart.
    if [[ "mysql stop/waiting" == "${exists_mysql}" ]]; then
      echo "service mysql start"
      service mysql start
      else
      echo "service mysql restart"
      service mysql restart
    fi

    # IMPORT SQL
    #
    # Create the databases (unique to system) that will be imported with
    # the mysqldump files located in database/backups/
    if [[ -f "/srv/database/init-custom.sql" ]]; then
      mysql -u "homestead" -p "secret" < "/srv/database/init-custom.sql"
      echo -e "\nInitial custom MySQL scripting..."
    else
      echo -e "\nNo custom MySQL scripting found in database/init-custom.sql, skipping..."
    fi

    # Setup MySQL by importing an init file that creates necessary
    # users and databases that our vagrant setup relies on.
    mysql -u "homestead" -p "secret" < "/srv/database/init.sql"
    echo "Initial MySQL prep..."

    # Process each mysqldump SQL file in database/backups to import
    # an initial data set for MySQL.
    "/srv/database/import-sql.sh"
  else
    echo -e "\nMySQL is not installed. No databases imported."
  fi
}

services_restart() {
  # RESTART SERVICES
  #
  # Make sure the services we expect to be running are running.
  echo -e "\nRestart services..."
  service nginx restart
  service memcached restart
  #service mailcatcher restart

  # Disable PHP Xdebug module by default
  #phpdismod xdebug

  # Enable PHP mcrypt module by default
  #phpenmod mcrypt

  # Restart all php-fpm versions
  #find /etc/init.d/ -name "php*-fpm" -exec bash -c 'sudo service "$(basename "$0")" restart' {} \;

  # Add the vagrant user to the www-data group so that it has better access
  # to PHP and Nginx related files.
  usermod -a -G www-data vagrant
}

wp_cli() {
  # WP-CLI Install
  local exists_wpcli

  # Remove old wp-cli symlink, if it exists.
  if [[ -L "/usr/local/bin/wp" ]]; then
    echo "\nRemoving old wp-cli"
    rm -f /usr/local/bin/wp
  fi

  exists_wpcli="$(which wp)"
  if [[ "/usr/local/bin/wp" != "${exists_wpcli}" ]]; then
    echo -e "\nDownloading wp-cli, see http://wp-cli.org"
    curl -sO https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli-nightly.phar
    chmod +x wp-cli-nightly.phar
    sudo mv wp-cli-nightly.phar /usr/local/bin/wp

    # Install bash completions
    curl -s https://raw.githubusercontent.com/wp-cli/wp-cli/master/utils/wp-completion.bash -o /home/vagrant/config/wp-cli/wp-completion.bash

    /usr/local/bin/wp package install aaemnnosttv/wp-cli-dotenv-command:1.0.*

  else
    echo -e "\nUpdating wp-cli..."
    wp --allow-root cli update --nightly --yes
  fi
}


### SCRIPT
#set -xv

network_check
# Profile_setup
echo " "
echo " ------ [ BASH SETUP ] ------ "
profile_setup

# Package and Tools Install
echo " "
echo " ------ [ EXTRA PACKAGES ] ------ "
package_install

echo " "
echo " ------ [ NODE VERSION MANAGER ] ------ "
tools_install

echo " "
echo " ------ [ PHP EXTRAS ] ------ "
phpfpm_setup

echo " "
echo " ------ [ WP CLI ] ------ "
wp_cli

echo " "
echo " ------ [ RESTART SERVICES ] ------ "
services_restart

end_seconds="$(date +%s)"
echo " "
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 3 | Completed in "$(( end_seconds - start_seconds ))" seconds.        ||"
echo "|| Moving onto the final stage 4/4 provisioning.....                           ||"
echo "---------------------------------------------------------------------------------"
echo " "
