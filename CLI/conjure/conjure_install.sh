#!/usr/bin/env bash
#
#  @details Installation script to get you up and running with a CLI infused
#           vagrant backed containerized wordpress installation. Other features
#           include Composer dependency management, and automated deployement.
#

# Vagrant Variables
# ----------------------------------------------------------------------
BOXNAME="laravel/homestead"
VPRESSZIP="https://bitbucket.org/derekscott_mm/wordpress-automatic/downloads/myriad_wp.zip"

# Core Functions
# ----------------------------------------------------------------------
## Message Out
function GOOD() {
  echo ""
  echo "${BOLD}${WHT}${B_GRN}[ OK ]${NORMAL}${GRN}  $@${NORMAL}"
  return 1
}
function BAD() {
  echo ""
  echo "${BOLD}${WHT}${B_RED}[ OK ]${NORMAL}${RED}  $@${NORMAL}"
  return 0
}
function WHATEVS() {
  echo ""
  echo "${BOLD}${WHT}${B_BLU}[ OK ]${NORMAL}${BLU}  $@${NORMAL}"
}

## User Inputs
function ask() {
  local prompt default reply

  while true; do

    if [ "${2:-}" = "Y" ]; then
      prompt="Y/n"
      default=Y
    elif [ "${2:-}" = "N" ]; then
      prompt="y/N"
      default=N
    else
      prompt="y/n"
      default=
    fi
    echo -en "$1 [$prompt] \n"
    read reply</dev/tty
    if [ -z "$reply" ]; then reply=$default; fi

    USERASK=$reply

    # Check if the reply is valid
    case "$reply" in
    Y* | y*) return 0 ;;
    N* | n*) return 1 ;;
    esac

  done
}

function askDir() {
  local prompt default reply

  while true; do

    if [ "${2:-}" = "Y" ]; then
      prompt="?"
      default=Y
    elif [ "${2:-}" = "N" ]; then
      prompt="?"
      default=N
    else
      prompt="?"
      default=
    fi
    echo -en "$1 [$prompt] \n"
    read reply</dev/tty
    if [ -z "$reply" ]; then reply=$default; fi

    RAW=$(echo $reply | sed 's/[^a-zA-Z]//g')
    USERASK=$(echo "$RAW" | tr '[:upper:]' '[:lower:]')
    case "$reply" in
    N* | n*) return 1 ;;
    *) return 0 ;;
    esac
  done
}

function rando() {
  VVVAR="$(/usr/bin/openssl rand -base64 8)"
  VVAR=$(echo $VVVAR | sed 's/[^a-zA-Z]//g')
  VAR=$(echo "$VVAR" | tr '[:upper:]' '[:lower:]')
}

function randoprefix() {
  VVVAR="$(/usr/bin/openssl rand -base64 3)"
  VVAR=$(echo $VVVAR | sed 's/[^a-zA-Z]//g')
  VAR=$(echo "$VVAR" | tr '[:upper:]' '[:lower:]')
}

# Main Menu
function GETTHISPARTYSTARTED() {
  echo ""
  echo "${WHT}   _______${CYN}_______       "
  echo "${WHT}  |${BLK}${B_BLU}       ${NORMAL}${CYN}       |${YLW}   ||  "
  echo "${WHT}  |${BLK}${B_BLU}     / ${NORMAL}${CYN} \  .  |${YLW}   ||  "
  echo "${WHT}  |${BLK}${B_BLU}  |\/  ${NORMAL}${CYN}  \/|  |${YLW}   ||   ${WHT}${B_BLU} MYRIAD MOBILE ${NORMAL} "
  echo "${WHT}  |${BLK}${B_BLU}  |____${NORMAL}${CYN}____|  |${YLW}   ||   ${WHT}${B_BLU} VPress v${fortressVersion} ${NORMAL}"
  echo "${WHT}   \\${BLK}${B_BLU}      ${NORMAL}${CYN}      /${YLW}    ||    "
  echo "${WHT}    \\${B_BLU}_____${NORMAL}${CYN}_____/${YLW}     ||  ${NORMAL}"
}

# Let's get this party started
# ----------------------------------------------------------------------
USERASK="KEEP"
VAR=""
DIRNAME=""

GETTHISPARTYSTARTED

rulemsg "System Status Check"

if ask "Install (or overwrite existing) required YAML configs?" N; then
  echo "Updating Torchwood resources to reflect current directory..."
  pwdesc=$(echo $SCRIPT | sed 's_/_\\/_g')
  cp $SCRIPT/barracks/resources/Torchwood.yaml $SCRIPT/Torchwood.yaml
  cp $SCRIPT/barracks/resources/Torchwood.json $SCRIPT/Torchwood.json
  cp $SCRIPT/barracks/resources/after.sh $SCRIPT/after.sh
  cp $SCRIPT/barracks/resources/aliases $SCRIPT/aliases

  sed -i -e "s/%SCRIPTPATH%/${pwdesc}/g" $SCRIPT/Torchwood.yaml
  sed -i -e "s/%SCRIPTPATH%/${pwdesc}/g" $SCRIPT/Torchwood.json
  rm $SCRIPT/Torchwood.yaml-e
  rm $SCRIPT/Torchwood.json-e
fi

# Install Requirements [ brew, vagrant, virtualbox ]
# ----------------------------------------------------------------------
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

# Setup Vagrant to manage Virtual Hosts
# ----------------------------------------------------------------------
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

if ask "Update Wordpress DevBox to latest version?" Y; then
  GETNEWWP
  GOOD "Wordpress DevBox Install [ OK ]"
fi

# Final Touches. Where do we go from here?
# ----------------------------------------------------------------------
# Default to No if the user presses enter without giving an answer:
if ask "Bring Vagrant box online? via vagrant up?" Y; then
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
