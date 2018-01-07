# VVoyage
_A VVV 2 & Wordmove site manager_

## About
VVoyage is a cli that can be run inside a VVV installation in order to manage WordPress sites and Wordmove deployments.  It does this by modifying the vvv-custom.yml file and Wordmove "Movefile" configurations.

## Setup
All you need to do to prepare your VVV box is add a provision-pre.sh file under the provision folder and copy the code below into it.  Then, just provision VVV and VVoyage will be installed automatically with Wordmove.

```
#!/bin/bash

if [ $(gem -v|grep '^2.') ]; then
    echo "gem already installed"
else
    apt-add-repository -y ppa:brightbox/ruby-ng
    apt update
    apt-get install -y ruby2.4 ruby2.4-dev sshpass
    echo "ruby2.4 and sshpass installed"
    echo "Installing gem"
    gem2.4 install bundler
fi

# wordmove install
wordmove_install="$(gem list wordmove -i)"
if [ "$wordmove_install" = true ]; then
  echo "Wordmove already installed"
else
  echo "Installing Wordmove"
  gem install wordmove --pre
  wordmove_path="$(gem which wordmove | sed -s 's/.rb/\/deployer\/base.rb/')"
  if [  "$(grep yaml $wordmove_path)" ]; then
    echo "can require yaml"
  else
    echo "can't require yaml"
    echo "set require yaml"
    sed -i "7i require\ \'yaml\'" $wordmove_path
    echo "can require yaml"
  fi
fi

echo "Installing VVoyage"
composer require aprivette/vvoyage -d=/vagrant
composer update aprivette/vvoyage -d=/vagrant
```

We also need to add the composer bin folder to our path.  In the vvv config folder, add the following to `bash_profile`.

```
# Composer bin path
export PATH="$PATH:/vagrant/vendor/bin"
```
## Commands
The following commands are available.  There are no arguments, just follow the prompts.

- `vvoyage env:create` - Creates a new Wordmove environment in the site's Movefile.
- `vvoyage env:delete` - Deletes a Wordmove enviroment
- `vvoyage site:create` - Adds a new site config to vvv-custom.yml
- `vvoyage site:delete` - Deletes a site config from vvv-custom.yml, deletes the site's folder, and drops the database
- `vvoyage site:migrate` - Pushes or pulls a site from a specified environment

## Development
This is literally my first composer package, so if you find something wrong with it feel free to yell at me / contribute.
