#!/usr/bin/env bash

# ------------------ ---------  ------   ----    ---     --      -
# WP_Conjure | Installer
# ------------------ ---------  ------   ----    ---     --      -
#%
#% DESCRIPTION
#% ===========
#%    Magical Wordpress development environment, Based on Laravel Homestead!
#%    Modified to include plenty of Wordpress tools and optimizations
#%
#+ COMMANDS
#+ ===========
#+    setup     . . . . . . . .  Installs WP_Conjure core system files
#+    wpnew     . . . . . . . .  Installs new Wordpress site into WP_Conjure directory: www
#+
#+    vagrant   . . . . . . . .  Run WP_Conjure vagrant commands when outside WP_Conjure directory.
#+    wordmove  . . . . . . . .  Create a new MOVEFILE for a wordpress deployement. Smarter than wordmove init
#+
#+    stacks    . . . . . . . .  Display a list of alternative Wordpress stacks to try out
#+    stackadd  . . . . . . . .  Downloads a new Wordpress for a given webstack. [plate,rock,web]
#+
#% INFO
#% ===========
#%    -h, --help    . . . . . .  Print this help
#%    -v, --version . . . . . .  Print script information
#%
# ------------------ ---------  ------   ----    ---     --      -
## TITLE:    init.sh
## DETAILS:  Fortified Wordpress development environment
## AUTHOR:   dscott@myriadmobile.com
## VERSION:  0.9.0
## DATE:     12.21.2017
# ------------------ ---------  ------   ----    ---     --      -
CONJUREVersion="0.9.0"
# ------------------ ---------  ------   ----    ---     --      -
#   BASE VARIABLES
# ------------------ ---------  ------   ----    ---     --      -
SCRIPT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)" # PATH
SCRIPTNAME=$(basename $0)
SCRIPTBASENAME="$(basename ${SCRIPTNAME} .sh)"
SCRIPT_HEADSIZE=$(head -200 ${0} | grep -n "^# END_OF_HEADER" | cut -f1 -d:)
SCRIPT_NAME="$(basename ${0})"
vVPress="0.7.0"
scriptPath="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
scriptName=$(basename $0)                      # Set Script Name variable
scriptBasename="$(basename ${scriptName} .sh)" # Strips '.sh' from scriptName
args=()

installScript="${SCRIPT}/CLI/conjure/install.sh"
libraryScript="${SCRIPT}/CLI/conjure/library.sh"

if [[ ! -f "${libraryScript}" ]]; then
  echo ""
  echo "conjure_library.sh not found. Cannot start."
  echo ""
  exit 1
fi
source $libraryScript
source $installScript

# Core Functions
# ----------------------------------------------------------------------
# Main Menu
# mageHatLogo

function installhs() {
  echo "Running Install script..."

  if [ -f "./.conjure.json" ]; then
    mv ./.conjure.json ./conjure-old.json
  fi

  if [ -f "./.env" ]; then
    mv ./.env ./env-old.txt
  fi

  #rm -R ./cache
  if [ -f "./log/*.log" ]; then
    rm -R ./log/*.log
  fi

  conjureFileRoll
}

function listStacks() {
  GRAY="$(tput setaf 244)"
  echo "${NORMAL}
 Wordpress Stacks
 ==========="
  echo ""
  echo "${BGRN}  Slug                   Fullname   DIF    URL "
  echo "${GRAY}  -----------------------------------------------------------"
  echo "${BBLU}  plate ${NORMAL}. . . . . . . .  ${BBLU}Wordplate ${GRAY}| ${YLW}xxx  ${GRAY}| ${CYN}https://wordplate.github.io/"
  echo "${BBLU}  rock  ${NORMAL}. . . . . . . .  ${BBLU}Bedrock   ${GRAY}| ${YLW}xxxx ${GRAY}| ${CYN}https://roots.io/bedrock/"
  echo "${BBLU}  web   ${NORMAL}. . . . . . . .  ${BBLU}Webpress  ${GRAY}| ${YLW}xx   ${GRAY}| ${CYN}https://bitbucket.org/derekscott_mm/webpress"
  echo "${BBLU}  plain ${NORMAL}. . . . . . . .  ${BBLU}Wordpress ${GRAY}|      ${GRAY}| ${CYN}https://github.com/johnpbloch/wordpress-core-installer"
  echo ""
  echo ""
  echo "${YLW}  * [DIF]FERENTIATE = How different that stack is compared to default Wordpress"
  echo "${NORMAL}"
  safeExit
}

function newStack() {
  local item
  item="${args[1]}"
  case $item in
  plate) addStackPlate ;;
  rock) addStackRock ;;
  web) addStackWeb ;;
  plain) addStackOrig ;;
  esac
}

function addStackPlate() {
  echo "Adding Wordplate site..."
  cd ./CLI/wp_build && bash Wordplate.sh
}

function addStackRock() {
  echo "Adding Bedrock site..."
  new_bedrock
}

function addStackOrig() {
  echo "Adding Wordpress site..."
  GETNEWWP
}

function addStackWeb() {
  echo "Adding WebPress site..."
  new_webpress
}

function vagrantCMD() {
  echo "$@"
}

# Print help if no arguments were passed.
# Uncomment to force arguments when invoking the script
# [[ $# -eq 0 ]] && set -- "--help"

# Read the options and set stuff
printLog=0
quiet=0
debug=0
force=0

function mainInitScript() {
  ############## Begin Script Here ###################
  ####################################################

  GETTHISPARTYSTARTED

  # Read the options and set stuff
  while [[ $1 == -?* ]]; do
    case $1 in
    -h | --help)
      echo "${NORMAL}" && usagefull && listStacks >&2
      safeExit
      ;;
    -v | --version)
      echo "WP_Conjure | version ${CONJUREVersion}"
      safeExit
      ;;
    -l | --log) printLog=1 ;;
    -d | --debug) debug=1 ;;
    --force) force=1 ;;
    --endopts)
      shift
      break
      ;;
    esac
    shift
  done

  case $1 in
  setup) installhs ;;
  wpnew) GETNEWWP ;;
  vagrant) vagrantCMD $args ;;
  wordmove) newMoveFile ;;
  stacks) listStacks ;;
  stackadd) newStack $args ;;
  esac

  # If no params (argument array 0 is null)
  if [ -z ${args[0]} ]; then
    echo
    echo "${BGRN}Try harder next time.${NORMAL}. You didnt provide any arguments, so I'm doing nothing..."
    echo "${NORMAL}"
    #usage
    safeExit
  fi

  ####################################################
  ############### End Script Here ####################
}

optstring=h
unset options
while (($#)); do
  case $1 in
  # If option is of type -ab
  -[!-]?*)
    # Loop over each character starting with the second
    for ((i = 1; i < ${#1}; i++)); do
      c=${1:i:1}

      # Add current char to options
      options+=("-$c")

      # If option takes a required argument, and it's not the last char make
      # the rest of the string its argument
      if [[ $optstring == *"$c:"* && ${1:i+1} ]]; then
        options+=("${1:i+1}")
        break
      fi
    done
    ;;

  # If option is of type --foo=bar
  --?*=*) options+=("${1%%=*}" "${1#*=}") ;;
  # add --endopts for --
  --) options+=(--endopts) ;;
  # Otherwise, nothing special
  *) options+=("$1") ;;
  esac
  shift
done
set -- "${options[@]}"

# Store the remaining part as arguments.
args+=("$@")

mainInitScript $@
