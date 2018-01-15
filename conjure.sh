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
#+
#+ GENERAL CMDS
#+ ===========
#+    setup     . . . . . . . .  Installs WP_Conjure core system files
#+    wordmove  . . . . . . . .  Create a new MOVEFILE for a wordpress deployement. Smarter than wordmove init
#+
#+
#+ SITE CMDS
#+ ===========
#+    wpnew     . . . . . . . .  Installs new Wordpress site + reloads vagrant environment
#+                                 <stack name> Required. Use supported WordPress stack for the new install
#+    wpver     . . . . . . . .  Create basic WordPress install from a specific version.
#+                                 <version> Required. IE conjure.sh wpver 3.4.1
#+    wpgit     . . . . . . . .  Use a Git repo for your new site install
#+                                 <git url> Required. IE: conjure.sh wpgit https://github.com/me/site.git
#+    stacks    . . . . . . . .  Display a list of alternative Wordpress stacks to try out
#+    update    . . . . . . . .  Requires <site slug> for whatever you want updated. IE conjure.sh update mydevsite
#+
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
## VERSION:  0.9.0
## DATE:     12.21.2017
# ------------------ ---------  ------   ----    ---     --      -




#   BASE VARIABLES
# ----------------------------------------------------------------
CONJUREVersion="0.9.0"
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

if [[ ! -f "${libraryScript}" ]]; then
  echo ""
  echo "${libraryScript} not found. Cannot start."
  echo ""
  exit 1
fi
source $libraryScript
source $installScript

# Core Functions
# ----------------------------------------------------------------
# Main Menu
# mageHatLogo

function installhs() {
  WHATEVS "Running Install script..."

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
  BAD "---- TODO ----"
  #new_cubi
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

# Store the remaining part as arguments.
args+=("$@")

mainInitScript $@
