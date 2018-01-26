#!/bin/bash
#
# By storing the date now, we can calculate the duration of provisioning at the
# end of this script.
start_seconds="$(date +%s)"
#sh /home/vagrant/bin/xdebug_off
sudo -s
sudo mkdir -p /home/vagrant/.cache
sudo chmod -R 777 /home/vagrant/.cache

echo ""
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 2 | Developer Tools + Wordpress Optimizations                         ||"
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

	# Extra PHP modules
	php-imagick
	php-ssh2
	#php-xdebug
	php7.0-mcrypt
	php7.1-mcrypt

	zip
	ngrep

	colordiff
	# Required for Webgrind
	graphviz

  pkg-config
  libxslt1-dev
  libxml2-dev

  # deployment tools
  sshpass
  gpgv2
  gnupg2
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
		sudo apt-get -y --no-upgrade --no-install-recommends install ${apt_package_install_list[@]}

	fi
}

# WEB TOOLS
tools_install() {
	# Disable xdebug before any composer provisioning.
	#sh /home/vagrant/bin/xdebug_off

  #
	# Node Version Manager [nvm]
	#      - automated migration for npm packages
	#      - triggered if NodeJS updates between provisions.
	#

	export NVM_DIR="/home/vagrant/.nvm"
  if [ ! -d "$NVM_DIR" ]; then

    npm uninstall -g bower
    npm uninstall -g grunt-cli
    npm uninstall -g gulp
    npm uninstall -g yarn

    sudo mkdir -p $NVM_DIR
    sudo cp /home/vagrant/config/default-packages $NVM_DIR/default-packages

    export USER="vagrant"
    export HOME="/home/vagrant"

		echo "Node Version Manager [NVM] installing....."
		curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.8/install.sh | NVM_DIR=$NVM_DIR bash >> /home/vagrant/log/install.log


    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
    [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion
    source /home/vagrant/.bash_profile
		nvm install node
    nvm use node

    TRIMVER="$(node --version | tr -d '[:space:]')"
    echo $TRIMVER > "/home/vagrant/config/nodelast.txt"

	else
    echo "Compare NVM previous to current build......"

    if [ -f "/home/vagrant/config/nodelast.txt" ]; then
        while IFS= read -r line; do
          echo $line
        done < nvmfile
        checkver=$(<nvmfile)
        TRIMVER="$(node --version | tr -d '[:space:]')"

        if [ "$checkver" == $TRIMVER ]; then
          echo "NVM migration not needed. Idential NVMs"
        else
          echo "Starting Automated NVM Migration from ${checkver} to $TRIMVER"
          nvm install node --reinstall-packages-from=$checkver
        fi
    fi

	fi

  YDIR=$(which yarn)

  if [ "$YDIR" == "" ]; then
    echo "Installing YARN the offial way..........."
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
    sudo apt-get update && sudo apt-get -y install yarn

    echo "Setting up the Conjure Dashboard........."
    cd /home/vagrant/dashboard
    yarn install
  fi

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
  local pseven="/home/vagrant/config/php-config/php7."
	# Copy php-fpm configuration from local
	cp "${pseven}0-fpm.conf" "/etc/php/7.0/fpm/php-fpm.conf"
	cp "${pseven}0-www.conf" "/etc/php/7.0/fpm/pool.d/www.conf"
	cp "${pseven}0-custom.ini" "/etc/php/7.0/fpm/conf.d/php-custom.ini"

	cp "${pseven}1-fpm.conf" "/etc/php/7.1/fpm/php-fpm.conf"
	cp "${pseven}1-www.conf" "/etc/php/7.1/fpm/pool.d/www.conf"
	cp "${pseven}1-custom.ini" "/etc/php/7.1/fpm/conf.d/php-custom.ini"

	cp "${pseven}2-fpm.conf" "/etc/php/7.2/fpm/php-fpm.conf"
	cp "${pseven}2-www.conf" "/etc/php/7.2/fpm/pool.d/www.conf"
	cp "${pseven}2-custom.ini" "/etc/php/7.2/fpm/conf.d/php-custom.ini"

	cp "/home/vagrant/config/php-config/opcache.ini" "/etc/php/7.0/fpm/conf.d/opcache.ini"
	cp "/home/vagrant/config/php-config/xdebug.ini" "/etc/php/7.0/mods-available/xdebug.ini"

	cp "/home/vagrant/config/php-config/opcache.ini" "/etc/php/7.1/fpm/conf.d/opcache.ini"
	cp "/home/vagrant/config/php-config/xdebug.ini" "/etc/php/7.1/mods-available/xdebug.ini"

	cp "/home/vagrant/config/php-config/opcache.ini" "/etc/php/7.2/fpm/conf.d/opcache.ini"


  echo "  ----------------------* PHP [7.0, 7.1, 7.2] *----------------------"
  echo " "
	echo "  php-fpm.conf | www.conf | php-custom.ini | opcache.ini | xdebug.ini"
  echo " "

  # @TODO something with xdebug. Shit is dead in PHP 7.2
	#echo " * Copied /home/vagrant/config/php-config/xdebug.ini to /etc/php/7.X/mods-available/xdebug.ini"

	# Copy memcached configuration from local
	cp "/home/vagrant/config/memcached-config/memcached.conf" "/etc/memcached.conf"
	cp "/home/vagrant/config/memcached-config/memcached.conf" "/etc/memcached_default.conf"

	echo "Configs set for Memcached here: /etc/memcached.conf and /etc/memcached_default.conf"
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
		if [[ -f "/home/vagrant/database/init-custom.sql" ]]; then
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
		"/home/vagrant/database/import-sql.sh"
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

### SCRIPT
#set -xv

# Profile_setup
echo " "
echo " -------------* [ BASH SETUP ] *------------- "
profile_setup

# Package and Tools Install
echo " "
echo " -----------* [ EXTRA PACKAGES ] *----------- "
package_install

echo " "
echo " --------* [ NODE VERSION MANAGER ] *-------- "
tools_install

echo " "
echo " -* [ PHP 7.0 , 7.1 , 7.2 ] Configurations ] *-"
phpfpm_setup

end_seconds="$(date +%s)"
echo " "
echo "---------------------------------------------------------------------------------"
echo "   STAGE 2 / 4 "
echo "   Completed in $(( end_seconds - start_seconds )) seconds "
echo "---------------------------------------------------------------------------------"
echo " "
