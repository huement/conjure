#!/usr/bin/env bash
# ------------------ ---------  ------   ----    ---     --      -
# WP_Conjure | Installer
# ------------------ ---------  ------   ----    ---     --      -
#% SYNOPSIS
#+    ${SCRIPT_NAME} [-hv] command [command_args] ...
#%
#% DESCRIPTION
#%    Magical Wordpress development environment
#%    Based on Laravel Homestead, modified to include
#%    plenty of wordpress specific tools and optimizations
#%    for development and deployment.
#%
#% COMMANDS
#%    install                       Installs required dependencies
#%    wpdev                         Updates Wordpress test dev site to latest
#%    list                          Lists container IPs and URLSs
#%    wordmove                      Create a new MOVEFILE for a wordpress deployement
#%    wpnew                         Setup a new Wordpress site
#%
#% COMMAND PARAMS
#%    -o [file], --output=[file]    Set log file (default=/dev/null)
#%
#% INFO
#%    -h, --help                    Print this help
#%    -v, --version                 Print script information
#%
#% EXAMPLES
#%    ${SCRIPT_NAME} install
#%
# ------------------ ---------  ------   ----    ---     --      -
## TITLE:    init.sh
## AUTHOR:   dscott@myriadmobile.com
## VERSION:  0.0.1
## DATE:     12.21.2017
# ------------------ ---------  ------   ----    ---     --      -

# ------------------ ---------  ------   ----    ---     --      -
#   BASE VARIABLES
# ------------------ ---------  ------   ----    ---     --      -
SCRIPT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)" # PATH
SCRIPTNAME=$(basename $0)
SCRIPTBASENAME="$(basename ${SCRIPTNAME} .sh)"
SCRIPT_HEADSIZE=$(head -200 ${0} | grep -n "^# END_OF_HEADER" | cut -f1 -d:)
SCRIPT_NAME="$(basename ${0})"
args=()

library="${SCRIPT}/conjure_library.sh"
if [[ ! -f "${library}" ]]; then
  echo "conjure_library.sh not found. Cannot start."
  exit 1
fi
source $library

# ------------------ ---------  ------   ----    ---     --      -
#   EXIT STAGE LEFT
# ------------------ ---------  ------   ----    ---     --      -
# if [[ "${BASH_SOURCE[0]}" = "$0" ]]; then
#     safeExit
# fi
tmpDir="/tmp/${SCRIPTNAME}.$RANDOM.$RANDOM.$RANDOM.$$"
(umask 077 && mkdir "${tmpDir}") || {
  die "Could not create temporary directory! Exiting."
}

# ------------------ ---------  ------   ----    ---     --      -
#   SCRIPT CORE
# ------------------ ---------  ------   ----    ---     --      -

# Exit Script
# -----------------------------------
# Non destructive exit for when script exits naturally.
# Usage: Add this function at the end of every script
# -----------------------------------
function safeExit() {
  # Delete temp files, if any
  if is_dir "${tmpDir}"; then
    rm -r "${tmpDir}"
  fi
  trap - INT TERM EXIT
  exit 0
}

function optList() {
  echo "${BGRN}list [l] command passed${NORMAL}\n"
  exit 1
}

function optX() {
  echo "${BBLU}Xtreme [x] command passed${NORMAL}\n"
  exit 1
}

function logicUnknown() {
  printf "${B_RED}[FAIL]${NORMAL} You made an unknown request.\nGet it together!${NORMAL}\n"
  exit 1
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
unset options

# Print help if no arguments were passed.
# Uncomment to force arguments when invoking the script
# [[ $# -eq 0 ]] && set -- "--help"

# Read the options and set stuff
printLog=0
quiet=0
debug=0
force=0
while [[ $1 == -?* ]]; do
  case $1 in
  -h | --help)
    usagefull >&2
    safeExit
    ;;
  -v | --version)
    scriptinfo
    safeExit
    ;;
  -l | --log) printLog=1 ;;
  -q | --quiet) quiet=1 ;;
  -d | --debug) debug=1 ;;
  --force) force=1 ;;
  --endopts)
    shift
    break
    ;;
  esac
  shift
done

############### UNIQUE PARTS HERE ####################
function installhs() {
  ilibrary="${SCRIPT}/conjure_install.sh"
  if [[ ! -f "${ilibrary}" ]]; then
    echo "conjure_install.sh not found. Cannot start."
    exit 1
  fi
  source $ilibrary
}

function wpupdate() {
  ilibrary="${SCRIPT}/conjure_install.sh"
  if [[ ! -f "${ilibrary}" ]]; then
    echo "conjure_install.sh not found. Cannot start."
    exit 1
  fi
  source $ilibrary
}

function mainScript() {
  ############## Begin Script Here ###################
  ####################################################
  case $1 in
  install) installhs ;;
  wpdev) wpupdate ;;
  esac

  # If no params (argument array 0 is null)
  if [ -z ${args[0]} ]; then
    header
    echo "${BGRN}Heyo there buddy. You didnt provide any arguments so I'm not doing anything.${NORMAL}"

    usage
    safeExit
  fi

  # otherwise lets see what we have to do.

  ####################################################
  ############### End Script Here ####################
}

mainScript $@
