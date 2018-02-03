#!/usr/bin/env bash

# ------------------ ---------  ------   ----    ---     --      -
#   MENU MAKER
# ------------------ ---------  ------   ----    ---     --      -

export COLS="$(tput cols)"

if [ "$(tput cols)" -lt "120" ]; then
  COLUMNS=120
  COLS=120
fi

function GETTHISPARTYSTARTED() {
  GITDEETS="$(git log --pretty=format:'%h' -n 1)"
  GRAY="$(tput setaf 244)"
  echo ""
  echo "${BGRN}          o       ${BGRN}  _______              __
  ${BGRN}    o   .       ${BGRN} |       |-----.-----.|__|.--.--.----.-----.
  ${GRAY}  _________     ${BGRN} |   ${BYLW}----${BGRN}|  ${BYLW}_${BGRN}  |      |  |   ${BYLW}|${BGRN}  |   _|  ${BYLW}-${BGRN}__|
  ${GRAY}c(${WHT}\` ${GRAY}    ${BGRN}'${GRAY} )o    ${BGRN} |_______|_____|___${BYLW}|${BGRN}__|  |______|__| |_____|
  ${GRAY}  \ ${BYLW}  \` ,${GRAY}/         ${PUR}---------------${BGRN}|______|${PUR}----------------
  ${YLW} _//${BRED}^${RED}-  ${BRED}^${YLW}\\\\_    ${BGRN}    ${CYN}ver${WHT} ${CONJUREVersion}                 ${CYN}git${WHT} ${GITDEETS}${NORMAL}"
}

function mageHatLogo() {
  clear
  echo ""
  echo ""
  cat $SCRIPT/_spellbook/CLI/conjure/mage.txt
}

function setupalready() {
  echo "             ${WHT}${B_BLU} WP_CONJURE ver. ${CONJUREVersion} ${NORMAL}"
  echo ""
}

# ------------------ ---------  ------   ----    ---     --      -
#   USER INTERACTION
# ------------------ ---------  ------   ----    ---     --      -

# Ask user a Yes or No question
# Returns result. 0 = yes. 1 = no.
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

# Prompt User for a String to use as a directory
# Autoformats to all lowercase
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

function header() {
  FN="figlet"
  if [ "$(fn_exists $FN)" == 1 ]; then
    e_header $SCRIPTBASENAME
  else
    FIG="$(figlet -w 80 -c -f graffiti ${SCRIPTBASENAME})"
    echo "${BBLU}${FIG}${NORMAL}"
  fi
}

# ------------------ ---------  ------   ----    ---     --      -
#   OUTPUT HEADERS & LOGGING
# ------------------ ---------  ------   ----    ---     --      -

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
  echo "${BOLD}${WHT}${B_RED}[FAIL]${NORMAL}${RED}  $@${NORMAL}"
  return 0
}
function WHATEVS() {
  echo ""
  echo "${BOLD}${WHT}${B_BLU}[INFO]${NORMAL}${BLU}  $@${NORMAL}"
}

function e_header() {
  printf "\n${BYLW}==========  %s  ==========${NORMAL}\n" "$@"
}
function e_arrow() {
  printf "➜ $@\n"
}
function e_success() {
  printf "${GRN}✔ %s${NORMAL}\n" "$@"
}
function e_error() {
  printf "${RED}✖ %s${NORMAL}\n" "$@"
}
function e_warning() {
  printf "${YLW}➜ %s${NORMAL}\n" "$@"
}

## Print a horizontal rule
## @param $1 default line break char. ie: -
function ruleln() {
  printf '%*s\n' "${COLUMNS:-$(tput cols)}" '' | tr ' ' -
}

## Print horizontal ruler with message
## @param $1 message we are going to display
## @param $2 default line break char. ie: -
function rulemsg() {
  if [ "$#" -eq 0 ]; then
    echo "Usage: rulemsg MESSAGE [RULE_CHARACTER]"
    return 1
  fi

  # Store Cursor.
  # Fill line with ruler character ($2, default "-")
  # Reset cursor
  # move 10 cols right, print message

  tput sc # save cursor
  printf -v _hr "%*s" "$(tput cols)" && echo -e "${YLW}" && echo -en ${_hr// /${2--}} && echo -en "\r\033[2C"
  tput rc

  echo -en "\r\033[10C" && echo -e "${BRED} [ ${BBLU}$1${BRED} ]" # 10 space in

  echo "${NORMAL}" # now we break
  echo " "
}

## READS FROM THE COMMENTS AT THE TOP OF THE FILE
usage() {
  head -${SCRIPT_HEADSIZE:-99} ${0} | grep -e "^#+" | sed -e "s/^#+[ ]*//g" -e "s/\${SCRIPT_NAME}/${SCRIPT_NAME}/g"
}
usagefull() { head -${SCRIPT_HEADSIZE:-99} ${0} | grep -e "^#[%+-]" | sed -e "s/^#[%+-]//g" -e "s/\${SCRIPT_NAME}/${SCRIPT_NAME}/g"; }
scriptinfo() { head -${SCRIPT_HEADSIZE:-99} ${0} | grep -e "^##" | sed -e "s/^##//g" -e "s/\${SCRIPT_NAME}/${SCRIPT_NAME}/g"; }

# ------------------ ---------  ------   ----    ---     --      -
#   LOGIC FUNCTIONS
# ------------------ ---------  ------   ----    ---     --      -
# @param $1 length integer how long the returned string will be
function randomString() {
  command -v openssl >/dev/null 2>&1 || {
    echo "I require foo but it's not installed.  Aborting." >&2
    exit 1
  }
  SSLBASE="$(openssl rand -base64 $1)"
  VVAR=$(echo $VVVAR | sed 's/[^a-zA-Z]//g')
  VAR=$(echo "$VVAR" | tr '[:upper:]' '[:lower:]')
}

# File Checks
# ------------------------------------------------------
# A series of functions which make checks against the filesystem. For
# use in if/then statements.
#
# Usage:
#    if is_file "file"; then
#       ...
#    fi
# ------------------------------------------------------

function is_exists() {
  if [[ -e "$1" ]]; then
    return 0
  fi
  return 1
}

function is_not_exists() {
  if [[ ! -e "$1" ]]; then
    return 0
  fi
  return 1
}

function is_file() {
  if [[ -f "$1" ]]; then
    return 0
  fi
  return 1
}

function is_not_file() {
  if [[ ! -f "$1" ]]; then
    return 0
  fi
  return 1
}

function is_dir() {
  if [[ -d "$1" ]]; then
    return 0
  fi
  return 1
}

function is_not_dir() {
  if [[ ! -d "$1" ]]; then
    return 0
  fi
  return 1
}

function is_symlink() {
  if [[ -L "$1" ]]; then
    return 0
  fi
  return 1
}

function is_not_symlink() {
  if [[ ! -L "$1" ]]; then
    return 0
  fi
  return 1
}

function is_empty() {
  if [[ -z "$1" ]]; then
    return 0
  fi
  return 1
}

function is_not_empty() {
  if [[ -n "$1" ]]; then
    return 0
  fi
  return 1
}

function fn_exists() {
  # appended double quote is an ugly trick to make sure we do get a string -- if $1 is not a known command, type does not output anything
  if [ -n "$(type -t rvm)" ] && [ "$(type -t rvm)" = 'function' ]; then
    return 1
  else
    return 0
  fi
}

# Build Path
# -----------------------------------
# DESC: Combines two path variables and removes any duplicates
# ARGS: $1 (required): Path(s) to join with the second argument
#       $2 (optional): Path(s) to join with the first argument
# OUTS: $build_path: The constructed path
# NOTE: Heavily inspired by: https://unix.stackexchange.com/a/40973
# -----------------------------------
function build_path() {
  if [[ -z ${1-} || $# -gt 2 ]]; then
    script_exit "Invalid arguments passed to build_path()!" 2
  fi

  local new_path path_entry temp_path

  temp_path="$1:"
  if [[ -n ${2-} ]]; then
    temp_path="$temp_path$2:"
  fi

  new_path=
  while [[ -n $temp_path ]]; do
    path_entry="${temp_path%%:*}"
    case "$new_path:" in
    *:"$path_entry":*) ;;
    *) new_path="$new_path:$path_entry"
      ;;
    esac
    temp_path="${temp_path#*:}"
  done

  # shellcheck disable=SC2034
  build_path="${new_path#:}"
}

# Check Binary
# -----------------------------------
# DESC: Check a binary exists in the search path
# ARGS: $1 (required): Name of the binary to test for existence
#       $2 (optional): Set to any value to treat failure as a fatal error
# -----------------------------------
function check_binary() {
  if [[ $# -ne 1 && $# -ne 2 ]]; then
    script_exit "Invalid arguments passed to check_binary()!" 2
  fi

  if ! command -v "$1" >/dev/null 2>&1; then
    if [[ -n ${2-} ]]; then
      script_exit "Missing dependency: Couldn't locate $1." 1
    else
      verbose_print "Missing dependency: $1" "${fg_red-}"
      return 1
    fi
  fi

  verbose_print "Found dependency: $1"
  return 0
}

# Check Super User
# -----------------------------------
# DESC: Validate we have superuser access as root (via sudo if requested)
# ARGS: $1 (optional): Set to any value to not attempt root access via sudo
# -----------------------------------
function check_superuser() {
  if [[ $# -gt 1 ]]; then
    script_exit "Invalid arguments passed to check_superuser()!" 2
  fi

  local superuser test_euid
  if [[ $EUID -eq 0 ]]; then
    superuser="true"
  elif [[ -z ${1-} ]]; then
    if check_binary sudo; then
      pretty_print "Sudo: Updating cached credentials for future use..."
      if ! sudo -v; then
        verbose_print "Sudo: Couldn't acquire credentials..." \
          "${fg_red-}"
      else
        test_euid="$(sudo -H -- "$BASH" -c 'printf "%s" "$EUID"')"
        if [[ $test_euid -eq 0 ]]; then
          superuser="true"
        fi
      fi
    fi
  fi

  if [[ -z $superuser ]]; then
    verbose_print "Unable to acquire superuser credentials." "${fg_red-}"
    return 1
  fi

  verbose_print "Successfully acquired superuser credentials."
  return 0
}

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

# Run Script as Root
# -----------------------------------
# DESC: Run the requested command as root (via sudo if requested)
# ARGS: $1 (optional): Set to zero to not attempt execution via sudo
#       $@ (required): Passed through for execution as root user
# -----------------------------------
function run_as_root() {
  local try_sudo
  if [[ ${1-} =~ ^0$ ]]; then
    try_sudo="true"
    shift
  fi

  if [[ $# -eq 0 ]]; then
    script_exit "Invalid arguments passed to run_as_root()!" 2
  fi

  if [[ $EUID -eq 0 ]]; then
    "$@"
  elif [[ -z ${try_sudo-} ]]; then
    sudo -H -- "$@"
  else
    script_exit "Unable to run requested command as root: $*" 1
  fi
}

if tput setaf 1 &>/dev/null; then
  BLK="$(tput setaf 0)"
  RED="$(tput setaf 124)"
  GRN="$(tput setaf 64)"
  YLW="$(tput setaf 136)"
  BLU="$(tput setaf 33)"
  PUR="$(tput setaf 125)"
  CYN="$(tput setaf 37)"
  WHT="$(tput setaf 15)"
  BLK="$(tput setaf 8)"
  BRED="$(tput setaf 9)"
  BGRN="$(tput setaf 10)"
  BYLW="$(tput setaf 11)"
  BBLU="$(tput setaf 12)"
  BPUR="$(tput setaf 13)"
  BCYN="$(tput setaf 14)"
  BWHT="$(tput setaf 15)"
  B_BLK="$(tput setab 8)"
  B_RED="$(tput setab 9)"
  B_GRN="$(tput setab 10)"
  B_YLW="$(tput setab 11)"
  B_BLU="$(tput setab 12)"
  B_PUR="$(tput setab 13)"
  B_CYN="$(tput setab 14)"
  B_WHT="$(tput setab 15)"
  BB_BLK="$(tput setab 8)"
  BB_RED="$(tput setab 124)"
  BB_GRN="$(tput setab 10)"
  BB_YLW="$(tput setab 11)"
  BB_BLU="$(tput setab 12)"
  BB_PUR="$(tput setab 13)"
  BB_CYN="$(tput setab 14)"
  NORMAL="$(tput sgr0)"
  BOLD="$(tput bold)"
  UNDERLINE="$(tput smul)"
  NOUNDER="$(tput rmul)"
  BLINK="$(tput blink)"
  REVERSE="$(tput rev)"
else
  BLK="\e[1;30m"
  RED="\e[1;31m"
  GRN="\e[1;32m"
  YLW="\e[1;33m"
  BLU="\e[1;34m"
  PUR="\e[1;35m"
  CYN="\e[1;36m"
  WHT="\e[1;37m"
  BLK="\e[1;30m"
  BRED="\e[1;31m"
  BGRN="\e[1;32m"
  BYLW="\e[1;33m"
  BBLU="\e[1;34m"
  BPUR="\e[1;35m"
  BCYN="\e[1;36m"
  BWHT="\e[1;37m"
  B_BLK="\e[40m"
  B_RED="\e[41m"
  B_GRN="\e[42m"
  B_YLW="\e[43m"
  B_BLU="\e[44m"
  B_PUR="\e[45m"
  B_CYN="\e[46m"
  B_WHT="\e[47m"
  BB_BLK="\e[1;40m"
  BB_RED="\e[1;41m"
  BB_GRN="\e[1;42m"
  BB_YLW="\e[1;43m"
  BB_BLU="\e[1;44m"
  BB_PUR="\e[1;45m"
  BB_CYN="\e[1;46m"
  BB_WHT="\e[1;47m"
  NORMAL="\e[0m"
  BOLD="\e[1m"
  UNDERLINE="\e[4m"
  NOUNDER="\e[24m"
  BLINK="\e[5m"
  NOBLINK="\e[25m"
  REVERSE="\e[50m"
fi
