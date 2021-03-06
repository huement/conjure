#!/usr/bin/env bash

# ------------------ ---------  ------   ----    ---     --      -
# WP_Conjure | Installer
# ------------------ ---------  ------   ----    ---     --      -
#%
#%
#%    		Lorem ipsum dolor sit amet, consectetur adipisicing elit.
#%         -------------------------------------------------------
#%             Excepteur sint occaecat cupidatat non proident
#%
#+ COMMANDS
#+ ===========
#+    cmd_one     . . . . . . . .  Duis aute irure dolor in reprehenderit in voluptate veli.
#+    cmd_two     . . . . . . . .  Esse cillum dolore eu fugiat nulla pariatur.
#+
#% INFO
#% ===========
#%    -h, --help    . . . . . .  Print this help
#%    -v, --version . . . . . .  Print script information
#%
# ------------------ ---------  ------   ----    ---     --      -
## TITLE:    blank.sh
## DETAILS:  Sample bash script starter
## AUTHOR:   derek@huement.com
## VERSION:  0.0.1
## DATE:     01.01.2018
# ------------------ ---------  ------   ----    ---     --      -

SVersion="0.0.1"

scriptPath="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
libraryScript="${scriptPath}/library.sh"

if [[ ! -f "${libraryScript}" ]]; then
  echo ""
  echo "${libraryScript} not found. Cannot start."
  echo " "
  exit 1
fi
#source $libraryScript

USERASK=""
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

    #RAW=$(echo $reply | sed 's/[^a-zA-Z]//g')
    #USERASK=$(echo "$RAW" | tr '[:upper:]' '[:lower:]')
		USERASK=$reply
		
    case "$reply" in
    N* | n*) return 1 ;;
    *) return 0 ;;
    esac
  done
}

function setupInstallerDir(){
	clear
	
	echo ""
	echo "${BGRN}Getting started. We need a folder.${NORMAL}"
	if askDir "ENTER FULL SYSTEM PATH FOR NEW INSTALL: " N; then
	
		if is_dir $USERASK; then 
			BAD "Directory already exists! Fatal Error!"
		else
			echo "Okay great choice! Using ${USERASK}";
			mkdir -p $USERASK;
		fi
	
	else
	  BAD "Directory not provided. Fatal Error!"
		exit 0;
	fi
	
	runInstaller;
}

function runInstaller(){
	echo ""
	echo "${BGRN}ENTER REQUIRED ${BCYN}WP_Config.php ${BGRN}PARAMS"
	echo ""
	echo "Database Name: "
	read -e dbname
	echo "Database User: "
	read -e dbuser
	echo "Database Password: "
	read -s dbpass
	echo "run install? (y/n)"
	read -e run
	if [ "$run" == n ] ; then
	exit
	else
	echo "====================================================================="
	echo "     ${BCYN}WordPress CORE Installing"
	echo "====================================================================="
	#download wordpress
	curl -O https://wordpress.org/latest.tar.gz
	#unzip wordpress
	mv ./latest.tar.gz $USERASK
	cd $USERASK
	tar -zxvf latest.tar.gz
	#change dir to wordpress
	cd wordpress
	#copy file to parent dir
	cp -rf . ..
	#move back to parent dir
	cd ..
	#remove files from wordpress folder
	rm -R wordpress
	#create wp config
	cp wp-config-sample.php wp-config.php
	#set database details with perl find and replace
	perl -pi -e "s/database_name_here/$dbname/g" wp-config.php
	perl -pi -e "s/username_here/$dbuser/g" wp-config.php
	perl -pi -e "s/password_here/$dbpass/g" wp-config.php

	#set WP salts
	perl -i -pe'
	  BEGIN {
	    @chars = ("a" .. "z", "A" .. "Z", 0 .. 9);
	    push @chars, split //, "!@#$%^&*()-_ []{}<>~\`+=,.;:/?|";
	    sub salt { join "", map $chars[ rand @chars ], 1 .. 64 }
	  }
	  s/put your unique phrase here/salt()/ge
	' wp-config.php

	#create uploads folder and set permissions
	mkdir wp-content/uploads
	chmod 775 wp-content/uploads
	echo "Cleaning..."
	#remove zip file
	rm latest.tar.gz
	#remove bash script
	echo "${BPUR}=================================================="
	echo "     ${BCYN}CORE Installation is complete."
	echo "${BPUR}==================================================${NORMAL}"
	fi
	
	wpplugins_setup
}

# ------------- | PLUGINS
function wpplugins_setup(){
	echo "Installing PLUGINS | TODO....."
	echo ""
	wp plugin delete akismet
	wp plugin delete hello.php

	read -r -p "${BOLD}${BBLU}Do you want install some useful plugins? ${NORMAL}[y/N] " response
	response=${response,,}    # tolower
	if [[ $response =~ ^(yes|y)$ ]]  
	then 
	  # plugins_array=(
# 	    "contact-form-7"
# 	    "cyr3lat"
# 	#    "all-in-one-seo-pack"
# 	    "pods"
# 	#    "google-sitemap-generator"
# 	#    "hypercomments"
# 	    "w3-total-cache"
# 	#    "siteorigin-panels"
# 	    "ari-adminer"
# 	    "all-in-one-wp-security-and-firewall"
# 	    "http://prosto-tak.ru/wphide.zip"
# 	    );

		mapfile -t wpArray <"${scriptPath}/default_packages.txt"

	  for i in "${wpArray[@]}"
	  do
	    read -r -p "${bold}Do you want to install $i?${normal} [y/N] " response
	    response=${response,,}    # tolower
	    if [[ $response =~ ^(yes|y)$ ]]  
	    then 
	      wp plugin install $i
	      # wp plugin activate $i
	    fi
	  done
	fi
}

