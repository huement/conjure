#!/usr/bin/env bash

# ------------------ ---------  ------   ----    ---     --      -
#   BASE VARIABLES
# ------------------ ---------  ------   ----    ---     --      -
SCRIPT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)" # PATH
SCRIPTNAME=$(basename $0)
SCRIPTBASENAME="$(basename ${SCRIPTNAME} .sh)"
SCRIPT_HEADSIZE=$(head -200 ${0} | grep -n "^# END_OF_HEADER" | cut -f1 -d:)
SCRIPT_NAME="$(basename ${0})"
vVPress="0.7.0";
scriptPath="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
scriptName=$(basename $0)                      # Set Script Name variable
scriptBasename="$(basename ${scriptName} .sh)" # Strips '.sh' from scriptName
args=()

# COLOR SETUP
if tput setaf 1&>/dev/null;then BLK="$(tput setaf 8)";RED="$(tput setaf 9)";GRN="$(tput setaf 10)";YLW="$(tput setaf 11)";BLU="$(tput setaf 12)";PUR="$(tput setaf 13)";CYN="$(tput setaf 14)";WHT="$(tput setaf 15)";B_BLK="$(tput setab 8)";B_RED="$(tput setab 124)";B_GRN="$(tput setab 10)";B_YLW="$(tput setab 11)";B_BLU="$(tput setab 12)";B_PUR="$(tput setab 13)";B_CYN="$(tput setab 14)";NORMAL="$(tput sgr0)";BOLD="$(tput bold)";else BLK="\e[1;30m";RED="\e[1;31m";GRN="\e[1;32m";YLW="\e[1;33m";BLU="\e[1;34m";PUR="\e[1;35m";CYN="\e[1;36m";WHT="\e[1;37m";B_BLK="\e[40m";B_RED="\e[41m";B_GRN="\e[42m";B_YLW="\e[43m";B_BLU="\e[44m";B_PUR="\e[45m";B_CYN="\e[46m";B_WHT="\e[47m";NORMAL="\e[0m";BOLD="\e[1m";fi;

# Core Functions
# ----------------------------------------------------------------------
## Message Out
function GOOD {
  echo "";
  echo "${BOLD}${WHT}${B_GRN}[ OK ]${NORMAL}${GRN}  $@${NORMAL}";
  return 1;
}
function BAD {
  echo "";
  echo "${BOLD}${WHT}${B_RED}[ OK ]${NORMAL}${RED}  $@${NORMAL}";
  return 0;
}
function WHATEVS {
  echo "";
  echo "${BOLD}${WHT}${B_BLU}[ OK ]${NORMAL}${BLU}  $@${NORMAL}";
}
## User Inputs
function ask {
    local prompt default reply

    while true; do

        if [ "${2:-}" = "Y" ];then prompt="Y/n";default=Y;elif [ "${2:-}" = "N" ];then prompt="y/N";default=N;else prompt="y/n";default=;fi;echo -en "$1 [$prompt] \n";read reply</dev/tty;if [ -z "$reply" ];then reply=$default;fi

        USERASK=$reply

        # Check if the reply is valid
        case "$reply" in
            Y*|y*) return 0 ;;
            N*|n*) return 1 ;;
        esac

    done
}
function askDir {
    local prompt default reply

    while true; do

        if [ "${2:-}" = "Y" ];then prompt="?";default=Y;elif [ "${2:-}" = "N" ];then prompt="?";default=N;else prompt="?";default=;fi;echo -en "$1 [$prompt] \n";read reply</dev/tty;if [ -z "$reply" ];then reply=$default;fi

        RAW=$(echo $reply | sed 's/[^a-zA-Z]//g')
        USERASK=$(echo "$RAW" | tr '[:upper:]' '[:lower:]')
        case "$reply" in
            N*|n*) return 1 ;;
            *) return 0 ;;
        esac
    done
}
function rando {
  VVVAR="$(/usr/bin/openssl rand -base64 8)"
  VVAR=$(echo $VVVAR | sed 's/[^a-zA-Z]//g')
  VAR=$(echo "$VVAR" | tr '[:upper:]' '[:lower:]')
}
# Main Menu
function startup {
  cat ./config/mage.txt
}

function setupalready {
	echo "             ${WHT}${B_BLU} WP_CONJURE ver. ${vVPress} ${NORMAL}"
  echo ""
}

function header() {
  FN="figlet"
  if [ "$(fn_exists $FN)" == 1 ]; then
    e_header $SCRIPTBASENAME
  else
    FIG="$(figlet -w 80 -c -f graffiti ${SCRIPTBASENAME})"
    echo "${BBLU}${FIG}${NORMAL}"
  fi
}

# Setup VV tool
function setup_vv {
  if [ ! -f "/usr/local/bin/vv" ]; then
    cd ~/;
    sudo mkdir -p ./.wp-cli;
    sudo mkdir -p ./.wp-cli/source;
    sudo chmod 777 ./.wp-cli/source;
    cd ./.wp-cli/source;
    git clone https://github.com/bradp/vv.git;
    cd vv;
    sudo cp vv /usr/local/bin;
    sudo cp vv-completions /usr/local/bin;
  else
    if [ -d "~/.wp-cli/source/vv" ]; then
      echo "WP VV UPDATE CHECK..."
      cd ~/.wp-cli/source/vv
      vv --update
    fi
  fi
}

function sys_check {
  # Install Requirements [ brew, vagrant, virtualbox ]
  # ----------------------------------------------------------------------
  if ! type "brew" > /dev/null; then
    WHATEVS "Installing Homebrew . . .";
    ruby -e "$(curl -fsSL https://raw.github.com/Homebrew/homebrew/go/install)";
  else
    GOOD "Homebrew already installed";
  fi

  # Check for Vagrant + Virtualbox
  if command -v vagrant >/dev/null 2>&1 && command -v virtualbox >/dev/null 2>&1 ; then
    GOOD "Vagrant + Virtualbox installed";
    echo ""
  else
    brew tap phinze/homebrew-cask && brew install brew-cask;
    # Vagrant
    command -v vagrant >/dev/null 2>&1 || { WHATEVS "Brewing Vagrant . . ."; brew cask install vagrant; }
    # Virtualbox
    command -v virtualbox >/dev/null 2>&1 || { WHATEVS "Brewing Virtualbox . . ."; brew cask install virtualbox; }
  fi

  if [! command -v vagrant >/dev/null 2>&1 ] || [ ! command -v virtualbox >/dev/null 2>&1 ] ; then
    BAD "Something went wrong. Vagrant and/or Virtualbox were not installed.";
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

# function setup_wpcli {
#   wp package install aaemnnosttv/wp-cli-dotenv-command
# }

function wpupdate() {
  ilibrary="${SCRIPT}/barracks/torchwood_install.sh"
  if [[ ! -f "${ilibrary}" ]]; then
    echo "barracks/torchwood_install.sh not found. Cannot start."
    exit 1
  fi
  source $ilibrary
}


startup

if [ ! -f "./.conjure.json" ]; then
  #Roll a dice using bash
  for i in {1..5}
  do
  	MSG="You rolled a..."
  	FATE=$(($RANDOM % 6 + 1))
  done

  declare -a titles=('King_of' 'Lord_of' 'Lady_of' 'Daemon_of' 'Knights_of' 'Queen_of')
  index=$( jot -r 1  0 $((${#titles[@]} - 1)) )
  rsN=${titles[index]}
  declare -a suffixes=('Oak-Island' 'Black-Marsh' 'Dark-Harbor' 'Devils-Canyon' 'Frozen-Flats' 'Shakey-Graves')
  index=$( jot -r 1  0 $((${#suffixes[@]} - 1)) )
  rsS=${suffixes[index]}
	hostName=$(echo ${rsS} | tr '[:upper:]' '[:lower:]')

  fileDate=$(date "+%H:%M %D")
	jsonData="{\"wizard_title\":\"${rsN}_${rsS}\",\"wizard_ip\":\"192.168.23.13\",\"wizard_host\":\"${hostName}\",\"created_on\":\"${fileDate}\"}"
  fileName="./.conjure.json"
  echo $jsonData > $fileName

  sys_check

	echo " "
  echo -e "\t     NEW CONJURE SETUP  "
  echo -e "\t         ---------      "
  echo -e "\t   ID : ${rsN}_${rsS}"
  echo -e "\t   IP : 192.168.23.13"
  echo -e "\t  HOST: ${hostName}"
  echo " "
  echo -e "\t   RUN: vagrant up --provision"
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
