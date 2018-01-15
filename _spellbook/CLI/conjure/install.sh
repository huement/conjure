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

function conjureFileRoll {
  if [ ! -f "./.conjure.json" ]; then
    #Roll a dice using bash
    for i in {1..5}; do
      MSG="You rolled a..."
      FATE=$(($RANDOM % 6 + 1))
    done

    declare -a titles=('King_of' 'Lord_of' 'Lady_of' 'Daemon_of' 'Knights_of' 'Queen_of')
    index=$(jot -r 1 0 $((${#titles[@]} - 1)))
    rsN=${titles[index]}
    declare -a suffixes=('Oak-Island' 'Black-Marsh' 'Dark-Harbor' 'Devils-Canyon' 'Frozen-Flats' 'Shakey-Graves')
    index=$(jot -r 1 0 $((${#suffixes[@]} - 1)))
    rsS=${suffixes[index]}
    hostName=$(echo ${rsS} | tr '[:upper:]' '[:lower:]')

    fileDate=$(date "+%H:%M %D")
    jsonData="{\"wizard_title\":\"${rsN}_${rsS}\",\"wizard_ip\":\"192.168.23.13\",\"wizard_host\":\"${hostName}.dash\",\"created_on\":\"${fileDate}\"}"
    fileName="./.conjure.json"
    echo $jsonData >$fileName

    #sys_check

    echo " "
    echo -e "\t\t     NEW CONJURE SETUP  "
    echo -e "\t\t         ---------      "
    echo -e "\t\t   ID : ${rsN}_${rsS}"
    echo -e "\t\t   IP : 192.168.23.13"
    echo -e "\t\t  HOST: ${hostName}.dash"
    echo " "
    echo -e "\t\t   RUN: vagrant up --provision"
    echo ""
    setupalready
    echo ""
  else
    setupalready
    echo -e "            CONJURE CONFIGURED ALREADY "
    echo -e "           see ${CYN}.conjure.json${NORMAL} for details   "
    echo " "
    echo -e "          ------ADDITIONAL COMMANDS------"
    echo -e "             ${GRN}SSH: ${NORMAL}vagrant ssh"
    echo -e "           ${GRN}RESET: ${NORMAL}vagrant up --provision"
    echo "     "
    echo -e "            ${GRN}SYNC: ${NORMAL}vagrant box update"
    echo -e "            ${GRN}TODO: ${NORMAL}conjure.sh update"
    echo -e "            ${GRN}TODO: ${NORMAL}conjure.sh wordpress update"
    echo -e "          -------------------------------"
    echo ""

  fi
}

# Grab git repos
# ----------------------------------------------------------------------
function cleanLiftGit {
  rm -R ./tmp_*/.git*
  cp -R ./tmp_* ./
  rm -R ./tmp_*
}

function downloadGit {
  repoToGet=$1
  tmpName=$($(randomString 3))
  # your real command here, instead of sleep
  fetchURL &
  PID=$!
  i=1
  sp="/-\|"
  echo -n ' '
  while [ -d /proc/$PID ]; do
    printf "\b${sp:i++%${#sp}:1}"
  done
}

function fetchURL {
  git clone -q -n $CONJUREBASE "tmp_${tmpName}"
}

# System Requirements [ brew, vagrant, virtualbox ]
# ----------------------------------------------------------------------
function insallRequirements {
  echo ""
  rulemsg "Homebrew"
  if ! type "brew" >/dev/null; then
    WHATEVS "Installing Homebrew . . ."
    ruby -e "$(curl -fsSL https://raw.github.com/Homebrew/homebrew/go/install)"
  else
    GOOD "Homebrew already installed"
  fi

  # Check for Vagrant + Virtualbox
  echo ""
  rulemsg "Vagrant + VirtualBox"
  if command -v vagrant >/dev/null 2>&1 && command -v virtualbox >/dev/null 2>&1; then
    GOOD "Vagrant + Virtualbox installed"
    echo ""
  else
    brew tap phinze/homebrew-cask && brew install brew-cask
    # Vagrant
    command -v vagrant >/dev/null 2>&1 || {
      WHATEVS "Brewing Vagrant . . ."
      brew cask install vagrant
    }
    # Virtualbox
    command -v virtualbox >/dev/null 2>&1 || {
      WHATEVS "Brewing Virtualbox . . ."
      brew cask install virtualbox
    }
  fi

  if [! command -v vagrant ] >/dev/null 2>&1 || [ ! command -v virtualbox ] >/dev/null 2>&1; then
    BAD "Something went wrong. Vagrant and/or Virtualbox were not installed."
    echo -e "\n\n\t You will need to manually correct this error and rerun the script again.\n"
    echo -e "\t VIRTUALBOX: https://www.virtualbox.org/ \n"
    echo -e "\t VAGRANT:    http://www.vagrantup.com/ \n"
  fi
}
function sys_check {
  if ! type "brew" >/dev/null; then
    WHATEVS "Installing Homebrew . . ."
    ruby -e "$(curl -fsSL https://raw.github.com/Homebrew/homebrew/go/install)"
  else
    GOOD "Homebrew already installed"
  fi

  # Check for Vagrant + Virtualbox
  if command -v vagrant >/dev/null 2>&1 && command -v virtualbox >/dev/null 2>&1; then
    GOOD "Vagrant + Virtualbox installed"
    echo ""
  else
    brew tap phinze/homebrew-cask && brew install brew-cask
    # Vagrant
    command -v vagrant >/dev/null 2>&1 || {
      WHATEVS "Brewing Vagrant . . ."
      brew cask install vagrant
    }
    # Virtualbox
    command -v virtualbox >/dev/null 2>&1 || {
      WHATEVS "Brewing Virtualbox . . ."
      brew cask install virtualbox
    }
  fi

  if [! command -v vagrant ] >/dev/null 2>&1 || [ ! command -v virtualbox ] >/dev/null 2>&1; then
    BAD "Something went wrong. Vagrant and/or Virtualbox were not installed."
    echo -e "\n\n\t You will need to manually correct this error and rerun the script again.\n"
    echo -e "\t VIRTUALBOX: https://www.virtualbox.org/ \n"
    echo -e "\t VAGRANT:    http://www.vagrantup.com/ \n"
  fi

  # Setup Vagrant to manage Virtual Hosts
  # ----------------------------------------------------------------------
  # Default to No if the user presses enter without giving an answer:
  if ask "Install the vagrant-hostsupdater plugin? [Optional]" N; then
    WHATEVS "Installing vagrant-hostsupdater"
    vagrant plugin install vagrant-hostsupdater
  fi

}

# Setup Vagrant to manage Virtual Hosts
# ----------------------------------------------------------------------
function setupVagrant {
  # Default to No if the user presses enter without giving an answer:
  echo ""
  rulemsg "Vagrant Recommended Plugins"
  echo "${BLU}vagrant-hostsupdater, vagrant-bindfs vagrant-triggers"
  echo ""
  if ask "Install the Recommended Plugins?" N; then
    WHATEVS "Installing file system plugins!........................................"
    vagrant plugin install vagrant-hostsupdater vagrant-bindfs vagrant-triggers
  fi

  echo ""
  rulemsg "Vagrant VirtualBox Plugins"
  echo "${BLU}vagrant-vbinfo, vagrant-vbguest ${NORMAL}"
  if ask "Would you like to install the Virtual Box addons?" N; then
    WHATEVS "Installing vagrant-vbinfo vagrant-vbguest.............................."
    vagrant plugin install vagrant-vbinfo vagrant-vbguest
  fi

  echo ""
  rulemsg "Vagrant Development Plugins"
  echo "${BLU}vagrant-trellis-cert, vagrant-notify ${NORMAL}"
  if ask "Would you like to install the Virtual Box addons?" N; then
    WHATEVS "Installing vagrant-trellis-cert vagrant-notify vagrant-notify-forwarder"
    vagrant plugin install vagrant-notify vagrant-notify-forwarder
  fi

  echo ""
  rulemsg "WP-CLI"
  echo "${BLU}Wordpress Command Line Interface ${NORMAL}"
  echo "This will be installed on the VM. However you may want a local install for convience. "
  if ask "Would you like to install WP-CLI and its addons?" N; then
    WHATEVS "Installing WP-CLI......................................................"
    # @TODO add the required install commands
    wp package install aaemnnosttv/wp-cli-dotenv-command
    # @TODO add the required install commands
  fi

  WHATEVS "Downloading Vagrant Box - ${BOXNAME} . . ."
  echo "${RED}-----------------------------------------${NORMAL}"
  vagrant box add $BOXNAME

  echo "${RED}-----------------------------------------${NORMAL}"
  GOOD "System status [ OK ]"
  echo ""
}

function vanillaWordpress {
  if ask "Install/Update Wordpress DevBox to latest version?" Y; then
    GETNEWWP
    GOOD "Wordpress DevBox Install [ OK ]"
  fi
}

# Setup VV tool [NOT USED]
# @todo make this command work w/ WP_Conjure
function setup_vv {
  if [ ! -f "/usr/local/bin/vv" ]; then
    cd ~/
    sudo mkdir -p ./.wp-cli
    sudo mkdir -p ./.wp-cli/source
    sudo chmod 777 ./.wp-cli/source
    cd ./.wp-cli/source
    git clone https://github.com/bradp/vv.git
    cd vv
    sudo cp vv /usr/local/bin
    sudo cp vv-completions /usr/local/bin
  else
    if [ -d "~/.wp-cli/source/vv" ]; then
      echo "WP VV UPDATE CHECK..."
      cd ~/.wp-cli/source/vv
      vv --update
    fi
  fi
}

# Final Touches. Where do we go from here?
# ----------------------------------------------------------------------
function askBootVagrant {

  # Default to No if the user presses enter without giving an answer:

  if ask "Start Conjure Vagrant box? ${GRN}vagrant up --provision command${NORMAL}" Y; then
    echo ""
    echo "     ${CYN}o${YLW}xxxx||${WHT}======================>      " && echo "${NORMAL}"
    WHATEVS "Running vagrant up --provision command"
    cd ../../
    vagrant up --provision
  else
    GOOD "Install completed. Exiting Script."
    echo -e "\nRun 'vagrant up --provision' from main WP_Conjure directory\n"
    echo ""
    echo "     ${CYN}o${YLW}xxxx||${WHT}======================>      " && echo "${NORMAL}"
  fi

  echo ""
  exit 0
}

function RUNINSTALLER {

  echo ""

  if ask "Download latest WP_Conjure repository? (initial setup / hard reset)" N; then
    #
    #
    # Grab Main Git repository
    # Grab Spellbook Git repository
    # Remove .conjure.json (if exists)
    # Create new .conjure.json
    # Run composer install
    # Run yarn install
    # Setup Utilities Folder
    # Setup www
    #
    #
    WHATEVS "Cloning Repositories"

    downloadGit $CONJUREBASE
    cleanLiftGit

    downloadGit $WEBPRESSBASE
    cleanLiftGit

    mv ./env.eample.txt ./.env

    WHATEVS "System Requirements"

    insallRequirements
    setupVagrant
    vanillaWordpress

    conjureFileRoll

    askBootVagrant
    #downloadGit $SPELLBOOKBASE
    #cleanLiftGit
  else
    fatal "nothing to do. . ."
    exit 0
  fi
}

# Install new Vanilla Wordpress Site
# ----------------------------------------------------------------------
SLUG=""
function askSlug {
  local prompt default reply

  echo ""
  echo "What name should we give the new site?"

  read reply</dev/tty
  if [ -z "$reply" ]; then reply=$default; fi

  RAW=$(echo $reply | sed 's/[^a-zA-Z]//g')

  SLUG=$(echo "$RAW" | tr '[:upper:]' '[:lower:]')
}

RSVAR=""
function randomSString {
  command -v openssl >/dev/null 2>&1 || {
    echo "I require foo but it's not installed.  Aborting." >&2
    exit 1
  }
  SSLBASE="$(openssl rand -base64 $1)"
  VVAR=$(echo $VVVAR | sed 's/[^a-zA-Z]//g')
  RSVAR=$(echo "$VVAR" | tr '[:upper:]' '[:lower:]')
}

function updateWP {
  cp $SCRIPT/provision/wp-config-sample.php $SCRIPT/www/$1/wp-config.php

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

function checkwp {
  echo 'More info here: https://github.com/aaemnnosttv/wp-cli-dotenv-command'
  wp package install aaemnnosttv/wp-cli-dotenv-command
}

function new_bedrock {
  echo ''
  askSlug
  echo ''
  cd $SCRIPT/www
  echo 'Installing modern WordPress stack [12-Factor App]'
  echo 'More info here: https://github.com/roots/bedrock'
  composer create-project roots/bedrock $SLUG
  echo ''
  cd $SLUG
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
  cd $SCRIPT/www/$SLUG/web/app/themes
  composer create-project roots/sage
  echo ''
  echo '----- ALL DONE -----'
  echo ''
}

function new_plate {
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
  updateWP
  npm install
  composer install
  echo ''
  echo '----- ALL DONE -----'
  echo ''
}

function new_webpress {
  echo ''
  askSlug
  echo ''
  WHATEVS 'Install WebPress......'
  echo "WebPress is a Morgan Le Fay endorsed, composer / npm backed, drop dead sexy stack"
  echo "More info here: https://bitbucket.org/derekscott_mm/WebPress"
  cd $SCRIPT/www
  git clone -q $WEBPRESSBASE $SLUG
  cd $SLUG
  updateWP
  npm install
  composer install
  rm -R ./.git
  echo ''
  echo '----- ALL DONE -----'
  echo ''
}

function new_vanilla {
  #clear

  #rulemsg "A totally chill WordPress Install Script."
  echo ''
  askSlug
  echo ''
  echo "Creating: ${SCRIPT}/www/${SLUG}"
  mkdir -p $SCRIPT/www/$SLUG
  if is_not_dir "${SCRIPT}/www/${SLUG}"; then
    die "Could not create install directory: ${SCRIPT}/www/${SLUG}"
  fi

  cd $SCRIPT/www/$SLUG

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

  WHATEVS "Installing new WordPress site into: ${GRN}${SCRIPT}/www/${SLUG}${NORMAL}"
  #download wordpress
  curl -O https://wordpress.org/latest.tar.gz
  #unzip wordpress
  tar -zxf latest.tar.gz
  #change dir to wordpress
  cd wordpress
  #copy file to parent dir
  cp -rf . ..
  #move back to parent dir
  cd ..
  #remove files from wordpress folder
  rm -R wordpress
  #create wp config
  updateWP

  #create uploads folder and set permissions
  cd $SCRIPT/www/$SLUG
  mkdir $SCRIPT/www/$SLUG/wp-content/uploads
  chmod 775 $SCRIPT/www/$SLUG/wp-content/uploads
  #remove zip file
  cd $SCRIPT/www/$SLUG
  rm latest.tar.gz

}

function newMoveFile {
  cp $SCRIPT/provision/MOVEFILE.yaml $SCRIPT/www/$1
  open $SCRIPT/www/$1/MOVEFILE.yaml
}
