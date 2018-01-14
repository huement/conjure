#!/usr/bin/env bash
#
# SFTP_SYNC.sh [ v0.0.1 ]
#
# This script is perfect for managing Wordpress installs when you dont have WP_CLI or SSH access.
# IE: WP Engine or other shared hosts. 
# Unlike most options this will allow for a 2 way pipe, not limiting you to just deployment from local to stage/prod.
#

SCRIPT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)" # PATH
SCRIPTNAME=$(basename $0)
SCRIPTBASENAME="$(basename ${SCRIPTNAME} .sh)"
SCRIPT_HEADSIZE=$(head -200 ${0} | grep -n "^# END_OF_HEADER" | cut -f1 -d:)
SCRIPT_NAME="$(basename ${0})"
vVPress="0.7.0"
scriptPath="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
scriptName=$(basename $0)                      # Set Script Name variable
scriptBasename="$(basename ${scriptName} .sh)" # Strips '.sh' from scriptName
libraryScript="../../CLI/conjure/library.sh"

args=()

if [[ ! -f "${libraryScript}" ]]; then
  echo ""
  echo "conjure_library.sh not found. Cannot start."
  echo ""
  exit 1
fi
source $libraryScript


function checkPIP {
  if fn_exists "pip"; then
    echo -e ""
  else
    if fn_exists "pip3"; then
      echo -e ""
    else
      echo "pip nor pip3 were found. Please install one. cannot continue!"
      echo "$ sudo easy_install pip"
      safeExit
    fi
  fi
}

function checkPySync {
  if fn_exists "sftpclone"; then
    echo -e ""
  else
    echo "pip nor pip3 were found. Please install one. cannot continue!"
    echo "read more: https://github.com/unbit/sftpclone or try running this..."
    echo "$ pip install sftpclone --user"
    safeExit
  fi
}

function helpCMD {
  echo -e "\nusage: sftpclone [-h] [-k private-key-path]\n
                 [-l {CRITICAL,ERROR,WARNING,INFO,DEBUG,NOTSET}] [-p PORT]\n
                 [-f] [-a] [-c ssh config path] [-n known_hosts path] [-d]\n
                 [-e exclude-from-file-path] [-t] [-o]\n
                 local-path user[:password]@hostname:remote-path\n";
}

function buildCMD {
  PORT=2222
  EXCLUDE_FILE="exclude.txt"
  LPATH="/Users/derekscott/Code/10th_stage"
  
  SURL="tenthmagnitude.sftp.wpengine.com"
  USER="tenthmagnitude-dscott"
  PASS="BL\$CKparad3"
  
  FTPURL="${USER}:${PASS}@${SURL}:${LPATH}"
  
  echo "sftpclone -l WARNING -o -d -t -p $PORT -e $EXCLUDE_FILE -o -local-path $LPATH -sftp-url $FTPURL"
}

# function promptUpDown {
#
# }

SITEUSER=""
function askSiteUSER() {
  local prompt default reply

  read reply</dev/tty
  if [ -z "$reply" ]; then reply=$default; fi

  SITEUSER="${reply}"
}

SITEURL=""
function askSiteURL() {
  local prompt default reply

  read reply</dev/tty
  if [ -z "$reply" ]; then reply=$default; fi

  SITEURL="${reply}"
}

SITEPW=""
function askSitePW() {
  local prompt default reply

  read reply</dev/tty
  if [ -z "$reply" ]; then reply=$default; fi

  SITEPW="${reply}"
}

SITEPATH=""
function askSitePATH() {
  local prompt default reply

  read reply</dev/tty
  if [ -z "$reply" ]; then reply=$default; fi

  SITEPATH="${reply}"
}

function saveSite {
  echo "REMOTE USERNAME: "
  askSiteUSER
  echo "REMOTE PASSWORD: "
  askSitePW
  echo "REMOTE URL: "
  askSiteURL
  echo "REMOTE WP-CONTENT PATH: (ie /public/wp/wp-content) "
  askSitePATH
  
  echo $SITEUSER > "./saved_sites/${SITESLUG}.txt"
  echo $SITEPW >> "./saved_sites/${SITESLUG}.txt"
  echo $SITEURL >> "./saved_sites/${SITESLUG}.txt"
  echo $SITEPATH >> "./saved_sites/${SITESLUG}.txt"
}

SITESLUG=""
function askSiteSlug {
  local prompt default reply

  read reply</dev/tty
  if [ -z "$reply" ]; then reply=$default; fi

  RAW=$(echo $reply | sed 's/[^a-zA-Z]//g')

  SITESLUG=$(echo "$RAW" | tr '[:upper:]' '[:lower:]')
}

function promptSite {
  echo "What site should we sync with?"
  askSiteSlug
  
  if is_not_dir "./saved_sites/${SITESLUG}.txt"; then
    echo "Adding new site to saved sync list"
    saveSite
  else
    echo "${SITESLUG} found. Loading config!"
  fi
}

echo ""
echo "---- Wordpress SFTP Sync ----"
echo ""
#promptSite
buildCMD
echo ""
echo ""