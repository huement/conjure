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

# WP_Conjure Install / Update commands
# ----------------------------------------------------------------------
function RUNINSTALLER() {

  echo ""

  if ask "Download latest Conjure repository? (initial setup / hard reset)" N; then

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

    WHATEVS "Cloning Repositories"

    if [[ -d "~/Conjure" ]]; then
      WHATEVS "Updating Conjure..."
    else
      WHATEVS "Cloning Conjure Repo"
      mkdir -p ~/Conjure
      git clone $CONJUREBASE ~/Conjure
      rm -R ~/Conjure/.git*
    fi

    echo "~/Conjure/.env file needs your attention!!"
    mv ~/Conjure/env.eample.txt ~/Conjure/.env

    echo " "
    WHATEVS "System Requirements"

    insallRequirements

    setupVagrant

    vanillaWordpress

    echo "WebPress Suprise Install!"
    git clone $WEBPRESSBASE ~/Conjure/www/webpress
    rm -R ~/Conjure/www/webpress/.git*

    echo "Generating your Vagrant Fortune.  .   ."
    conjureFileRoll

    askBootVagrant

  else
    fatal "nothing to do. . ."
    exit 0
  fi
}

function conjureFileRoll() {
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
  fi

  #results

  echo " "
  setupalready
  echo "                    ${WHT}---------      "
  echo -e "             ${GRN}ID :${BBLU} ${rsS}"
  echo -e "             ${GRN}IP :${BBLU} 192.168.23.13"
  echo -e "             ${GRN}URL:${BBLU} magic.app"
  echo " "
  echo -e "             ${GRN}RUN:${BBLU} vagrant up --provision"
  echo "                    ${WHT}---------      "
  echo " "
  echo -e "            ${BCYN} ~/Conjure/.conjure.json   "
  echo " "
  echo -e "          ${WHT}------ VAGRANT  COMMANDS ------"
  echo -e "             ${GRN}SSH: ${BBLU}vagrant ssh"
  echo -e "           ${GRN}RESET: ${BBLU}vagrant up --provision"
  echo -e "             ${GRN}NEW: ${BBLU}vagrant box update"
  echo -e "          ${WHT}-------------------------------"
  echo "${NORMAL}"
  echo ""

}

#    echo -e "           ${GRN}@TODO: ${BBLU}conjure.sh update"
#    echo -e "           ${GRN}@TODO: ${BBLU}conjure.sh wordpress update"

# Grab git repos [ Remove .git dir ]
# ----------------------------------------------------------------------
function cleanLiftGit() {
  rm -R ./tmp_*/.git*
  cp -R ./tmp_* ./
  rm -R ./tmp_*
}

function downloadGit() {
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

function fetchURL() {
  git clone -q -n $CONJUREBASE "tmp_${tmpName}"
}

# System Requirements [ brew, vagrant, virtualbox ]
# ----------------------------------------------------------------------
function insallRequirements() {
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
function sys_check() {
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
function setupVagrant() {
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

function askBootVagrant() {

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
