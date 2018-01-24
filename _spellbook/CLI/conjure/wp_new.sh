#!/usr/bin/env bash
#
#  @details Installation script to get you up and running with a CLI infused
#           vagrant backed containerized wordpress installation. Other features
#           include Composer dependency management, and automated deployement.
#

WEBPRESSBASE="https://bitbucket.org/derekscott_mm/webpress"
CONJUREBASE="https://bitbucket.org/derekscott_mm/book_of_spells"
SPELLBOOKBASE="https://bitbucket.org/derekscott_mm/book_of_spells"
BOXNAME="laravel/homestead"
VPRESSZIP="https://bitbucket.org/derekscott_mm/wordpress-automatic/downloads/myriad_wp.zip"

# Let's get this party started
# ----------------------------------------------------------------------
USERASK=""
VAR=""
DIRNAME=""
INSTALLDIR=""
repoToGet=""

# Install helper functions
# ----------------------------------------------------------------------
SLUG=""
function askSlug() {
  local prompt default reply

  echo ""
  echo "What name should we give the new site?"

  read reply</dev/tty
  if [ -z "$reply" ]; then reply=$default; fi

  RAW=$(echo $reply | sed 's/[^a-zA-Z]//g')

  SLUG=$(echo "$RAW" | tr '[:upper:]' '[:lower:]')
}

RSVAR=""
function randomSString() {
  command -v openssl >/dev/null 2>&1 || {
    echo "I require foo but it's not installed.  Aborting." >&2
    exit 1
  }
  SSLBASE="$(openssl rand -base64 $1)"
  VVAR=$(echo $VVVAR | sed 's/[^a-zA-Z]//g')
  RSVAR=$(echo "$VVAR" | tr '[:upper:]' '[:lower:]')
}

function updateWP() {
  cp $SCRIPT/config/wordpress-config/wp-config-default.php /home/vagrant/code/$1/wp-config.php

  #set database details with perl find and replace
  perl -pi -e "s/database_name_here/$dbname/g" wp-config.php
  perl -pi -e "s/username_here/$dbuser/g" wp-config.php
  perl -pi -e "s/password_here/$dbpass/g" wp-config.php
  sed -i -e "s/wp_/$dbpref/g" wp-config.php
  #set WP salts
  perl -i -pe'
    BEGIN {
      @chars = ("a" .. "z", "A" .. "Z", 0 .. 9);
      push @chars, split //, "!@#$%^&*()-_ []{}<>~\`+=,.;:/?|";
      sub salt { join "", map $chars[ rand @chars ], 1 .. 64 }
    }
    s/put your unique phrase here/salt()/ge
  ' wp-config.php
}

function wpdotenv() {
  echo -e 'Install wp-cli-dotenv-command...\nMore info available here: https://github.com/aaemnnosttv/wp-cli-dotenv-command\n'
  wp package install aaemnnosttv/wp-cli-dotenv-command
}

function newMoveFile() {
  cp $SCRIPT/config/wordpress-config/MOVEFILE.yaml /home/vagrant/code/$1
  echo "New MOVEFILE.yaml template now available!"
  #open /home/vagrant/code/$1/MOVEFILE.yaml
}

function join_by() {
  local IFS="$1"
  shift
  echo "$*"
}

function defaultPlugins() {
  STRINGPLUG=""
  mapfile -t wpArray <"/home/vagrant/config/wordpress-config/default_packages.json"
  # for i in "${wpArray[@]}"
  # do
  #    STRINGPLUG=" "
  # done
}

# Install new Wordpress Site from Stack
# ----------------------------------------------------------------------
function new_bedrock() {
  echo ''
  askSlug
  echo ''
  cd $SCRIPT/www
  echo 'Installing modern WordPress stack [12-Factor App]'
  echo 'More info here: https://github.com/roots/bedrock'
  composer create-project roots/bedrock $SLUG
  echo ''
  cd $SLUG
  echo 'Updating wp-config...'
  updateWP $SLUG
  echo 'Updating wp-config.php SALT'
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
  cd /home/vagrant/code/$SLUG/web/app/themes
  composer create-project roots/sage
  echo ''
  echo '----- ALL DONE -----'
  echo ''
}

function new_plate() {
  echo ''
  askSlug
  echo ''
  WHATEVS 'Install WordPlate......'
  echo 'WordPlate simplifies the fuzziness around WordPress development.'
  echo 'More info here: https://wordplate.github.io/'
  echo ''
  cd $SCRIPT/www
  composer create-project wordplate/wordplate $SLUG
  cd $SLUG
  echo 'Updating wp-config...'
  updateWP $SLUG
  echo 'Updating wp-config.php SALT'
  wp dotenv salts regenerate
  npm install
  composer install
  echo ''
  echo '----- ALL DONE -----'
  echo ''
}

function new_webpress() {
  echo ''
  askSlug
  echo ''
  WHATEVS 'Install WebPress......'
  echo "WebPress is a Morgan Le Fay endorsed, composer / npm backed, drop dead sexy stack"
  echo "More info here: https://bitbucket.org/derekscott_mm/WebPress"
  cd $SCRIPT/www
  git clone -q $WEBPRESSBASE $SLUG
  cd $SLUG
  echo 'Updating wp-config...'
  updateWP $SLUG
  echo 'Updating wp-config.php SALT'
  wp dotenv salts regenerate
  npm install
  composer install
  rm -R ./.git
  echo ''
  echo '----- ALL DONE -----'
  echo ''
}

function new_vanilla() {
  #clear

  #rulemsg "A totally chill WordPress Install Script."
  echo ''
  askSlug
  echo ''
  WHATEVS "Installing standard Wordpress..."
  echo "Creating in: /home/vagrant/code/${SLUG}"
  mkdir -p /home/vagrant/code/$SLUG
  if is_not_dir "/home/vagrant/code/${SLUG}"; then
    die "Could not create install directory: /home/vagrant/code/${SLUG}"
  fi

  cd /home/vagrant/code/$SLUG

  dbpreS=$($(randomSString 3))
  dbpref="${RSVAR}_"
  dbname="wpdev"
  dbuser="homestead"
  dbpass="secret"

  echo ""
  echo ""
  echo "${SLUG} Wordpress Configuration"
  echo ""
  echo "DB TABLE : wpdev"
  echo "DB PREFIX: ${dbpref}"
  echo "DB USER  : ${dbuser}"
  echo "DB PASS  : ${dbpass}"
  echo ""
  echo ""

  wp core download
  #unzip wordpress

  echo 'Updating wp-config...'
  updateWP $SLUG
  echo 'Updating wp-config.php SALT'
  wp dotenv salts regenerate

  #create uploads folder and set permissions
  mkdir -p /home/vagrant/code/$SLUG/wp-content/uploads
  chmod 775 /home/vagrant/code/$SLUG/wp-content/uploads
  echo ''
  echo '----- ALL DONE -----'
  echo ''
}

function new_cubi() {
  echo ''
  askSlug
  echo ''
  WHATEVS 'Install wp-cubi......'
  echo -e 'Modern stack for developers. \nNote: wp-cubi is under active development \nand is not a final product yet. You should not use it if you dont know PHP development and WordPress basics.\n'
  echo 'More info here: https://github.com/globalis-ms/wp-cubi'
  echo ''
  cd $SCRIPT/www
  composer create-project globalis/wp-cubi $SLUG && cd $SLUG
  cd $SLUG
  echo 'WP_Cubi Installation command....'
  ./vendor/bin/robo install
  echo 'Setup WordPress database'
  ./vendor/bin/robo wp:init
  echo ''
  echo '----- ALL DONE -----'
  echo ''
  echo 'Access your site admin at ./web/wp/wp-admin'
  echo 'Use wp-cli commands with ./vendor/bin/wp'
  echo ''
}
