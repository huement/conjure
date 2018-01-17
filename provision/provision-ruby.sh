#!/bin/bash

#sh /home/vagrant/bin/xdebug_off
start_seconds="$(date +%s)"
sudo -s

echo ""
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 2 | RUBY and the GEMS                                                 ||"
echo "---------------------------------------------------------------------------------"
echo ""

# Update all of the package references before installing anything
echo "Running apt-get update..."
sudo apt-get -y --force-yes update &>/dev/null

# VVoyage | https://github.com/aprivette/vvoyage
# - `vvoyage env:create` - Creates a new Wordmove environment in the site's Movefile.
# - `vvoyage env:delete` - Deletes a Wordmove enviroment
# - `vvoyage site:create` - Adds a new site config to vvv-custom.yml
# - `vvoyage site:delete` - Deletes a site config from vvv-custom.yml, deletes the site's folder, and drops the database
# - `vvoyage site:migrate` - Pushes or pulls a site from a specified environment


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


echo " ------ [ RUBY + GEMS ] ------ "

# Ruby


function check_rvm() {
	local result=$(type rvm >/dev/null 2>&1 || echo 'nope');

	printf "Checking %s...\n" "RVM";

	if [[ ${result} = 'nope' ]]; then
		printf "\n";
		install_rvm;
	else
		printf " * RVM is installed\n";
	fi

	if [ -f "/etc/profile.d/rvm.sh" ]; then
		source /etc/profile.d/rvm.sh
	fi
	if [ -f "/usr/local/rvm/scripts/rvm" ]; then
		source /usr/local/rvm/scripts/rvm
	fi
	if [ -f "/home/vagrant/.rvm/scripts/rvm" ]; then
		source /home/vagrant/.rvm/scripts/rvm
	fi
}

function install_rvm() {
	# @url https://www.digitalocean.com/community/tutorials/deploying-a-rails-app-on-ubuntu-14-04-with-capistrano-nginx-and-puma
	# @url https://rvm.io/rvm/install

	gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3;

	curl -sSL https://get.rvm.io | bash -s stable --ruby;

	source /home/vagrant/.rvm/scripts/rvm;

	rvm requirements;
}

check_rvm

# wordmove install
echo "Installing Ruby Gems................."
gem install bundler
#gem install mailcatcher
gem install compass
gem install sass
gem install rake
gem install serverspec
gem install gemcutter
gem install compass-wordpress
gem install wordpress_tools


echo "W O R D  M O V E....................."
wordmove_install="$(gem list wordmove -i)"
if [ "$wordmove_install" = true ]; then
	echo "Wordmove already installed"
else
	echo "Installing Wordmove"
	gem install wordmove --pre
	wordmove_path="$(gem which wordmove | sed -s 's/.rb/\/deployer\/base.rb/')"
	if [  "$(grep yaml $wordmove_path)" ]; then
		echo "gtg on require yaml"
	else
		sed -i "7i require\ \'yaml\'" $wordmove_path
		echo "can now require yaml"
	fi
fi


end_seconds="$(date +%s)"
echo " "
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 2 | Completed in "$(( end_seconds - start_seconds ))" seconds.        ||"
echo "|| Moving onto provisioning stage 3 of 4                                       ||"
echo "---------------------------------------------------------------------------------"
echo " "
