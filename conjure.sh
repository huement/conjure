#!/usr/bin/env bash

# ------------------ ---------  ------   ----    ---     --      -
# WP_Conjure | Installer
# ------------------ ---------  ------   ----    ---     --      -
#%
#%
#%    Security reporting | Dev toolbox & templates | Performance optimizations
#%         -------------------------------------------------------
#%            Based on Laravel Homestead. Built by MyriadMobile
#+ SETUP
#+ ===========
#+    setup     . . . . . . . .  Installs WP_Conjure core system files
#+    wordmove  . . . . . . . .  Create a new MOVEFILE for a wordpress deployement. Smarter than wordmove init
#+
#+ DEV TOOLS
#+ ===========
#+    wpnew     . . . . . . . .  Installs new Wordpress site + reloads vagrant. Only ONE option at a go.
#+                                   [Optional] Options | -s <stack> -w <wp_ver> -g <git_url>
#+    stacks    . . . . . . . .  Display a list of alternative Wordpress stacks to try out
#+    update    . . . . . . . .  Requires <site slug> for whatever you want updated. IE conjure.sh update mydevsite
#+
#% INFO
#% ===========
#%    -h, --help    . . . . . .  Print this help
#%    -v, --version . . . . . .  Print script information
#%
# ------------------ ---------  ------   ----    ---     --      -
## TITLE:    conjure.sh
## DETAILS:  WP_Conjure main CLI script
## AUTHOR:   dscott@myriadmobile.com
## VERSION:  0.9.5
## DATE:     01.24.2017
# ------------------ ---------  ------   ----    ---     --      -

#   BASE VARIABLES
# ----------------------------------------------------------------
CONJUREVersion="0.9.5"
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

installScript="${SCRIPT}/_spellbook/CLI/conjure/install.sh"
libraryScript="${SCRIPT}/_spellbook/CLI/conjure/library.sh"
wp_newScript="${SCRIPT}/_spellbook/CLI/conjure/wp_new.sh"

if [[ ! -f "${libraryScript}" ]]; then
  echo ""
  echo "${libraryScript} not found. Cannot start."
  echo " "
  exit 1
fi
source $libraryScript
source $installScript
source $wp_newScript

# Core Functions
# ----------------------------------------------------------------
# Main Menu
# mageHatLogo

function installhs() {
  WHATEVS "Running Install script..."

  #cd /home/vagrant/code

  if [ -f "${SCRIPT}/.conjure.json" ]; then
    echo "${BRED}"
    echo "  ALERT: ${RED}setup cmd would RESET exisintg .conjure.json file."
    echo "  ${NORMAL}Manually Remove${CYN} ${SCRIPT}/.conjure.json"
    echo "  ${NORMAL}and then you can rerun this setup command."
    echo " "
    safeExit
  fi

  #rm -R ./cache
  if [ -f "${SCRIPT}/log/*.log" ]; then
    echo "CLEARING OLD LOG FILES"
    rm -R $SCRIPT/log/*.log
  fi

  conjureFileRoll
}

function listStacks() {
  GRAY="$(tput setaf 244)"
  echo "${NORMAL}
 Wordpress Stacks
 ==========="
  echo ""
  echo "${BYLW}  Slug                   Fullname   DIF    URL "
  echo "${GRAY}  -----------------------------------------------------------"
  echo "${BGRN}  word  ${NORMAL}. . . . . . . .  ${BBLU}Wordpress ${GRAY}| ${YLW}     ${GRAY}| ${BCYN}https://github.com/johnpbloch/wordpress-core-installer"
  echo "${BGRN}  plate ${NORMAL}. . . . . . . .  ${BBLU}Wordplate ${GRAY}| ${YLW}xxx  ${GRAY}| ${BCYN}https://wordplate.github.io/"
  echo "${BGRN}  rock  ${NORMAL}. . . . . . . .  ${BBLU}Bedrock   ${GRAY}| ${YLW}xxxx ${GRAY}| ${BCYN}https://roots.io/bedrock/"
  echo "${BGRN}  web   ${NORMAL}. . . . . . . .  ${BBLU}Webpress  ${GRAY}| ${YLW}xx   ${GRAY}| ${BCYN}https://bitbucket.org/derekscott_mm/webpress"
  echo "${BGRN}  cubi  ${NORMAL}. . . . . . . .  ${BBLU}WP_Cubi   ${GRAY}| ${YLW}xxx  ${GRAY}| ${BCYN}https://github.com/globalis-ms/wp-cubi"
  echo ""
  echo ""
  echo "${YLW}  x = [DIF]FERENCE compared to default Wordpress install"
  echo "${NORMAL}"
  safeExit
}

function newStack() {

  askSlug

  local item
  item="${args[1]}"
  case $item in
  plate) addStackPlate ;;
  rock) addStackRock ;;
  web) addStackWeb ;;
  word) addStackOrig ;;
  cubi) addStackCubi ;;
  esac
}

function addStackPlate() {
  WHATEVS "Adding WordPlate site..."
  new_plate
}

function addStackRock() {
  WHATEVS "Adding Bedrock site..."
  new_bedrock
}

function addStackOrig() {
  WHATEVS "Adding Wordpress site..."
  new_vanilla
}

function addStackWeb() {
  WHATEVS "Adding WebPress site..."
  new_webpress
}

function addStackCubi() {
  WHATEVS "Adding WebPress site..."
  new_cubi
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
  # Read the options and set stuff
  while [[ $1 == -?* ]]; do
    case $1 in
    -h | --help)
      echo "${NORMAL}" && GETTHISPARTYSTARTED && usagefull >&2
      exit 0
      ;;
    -v | --version)
      mageHatLogo
      echo -e "               WP_Conjure | v${CONJUREVersion} \n"
      exit 0
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
  wpnew) newStack $args ;;
  wordmove) newMoveFile ;;
  stacks) listStacks ;;
  esac

  # If no params (argument array 0 is null)
  if [ -z ${args[0]} ]; then
    echo
    echo "${BRED} NO ARGUMENTS. EXITING."
    echo -e "${NORMAL} Try ${BGRN}conjure.sh -h${NORMAL} for options + information\n"
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


function grabStyles {
	while IFS='' read -r line || [[ -n "$line" ]]; do
	    echo "Text read from file: $line"
	done < "$1"
}

# Store the remaining part as arguments.
args+=("$@")

mainInitScript $@
