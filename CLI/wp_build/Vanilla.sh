#!/usr/bin/env bash
#           __      ___________________
#          /  \    /  \______   \      \   ______  _  __
#          \   \/\/   /|     ___/   |   \_/ __ \ \/ \/ /
#           \        / |    |  /    |    \  ___/\     /
#            \__/\  /  |____|  \____|__  /\___  >\/\_/
#                 \/                   \/     \/
#
#  @details Download and Install the latest Wordpress
#  @todo    Allow for optionally setting a specific version of Wordpress

function randoprefix() {
  VVVAR="$(/usr/bin/openssl rand -base64 3)"
  VVAR=$(echo $VVVAR | sed 's/[^a-zA-Z]//g')
  VAR=$(echo "$VVAR" | tr '[:upper:]' '[:lower:]')
}

function GETNEWWP() {
  clear
  cd ../../www
  mkdir -p ./wpdev
  cd wpdev
  rulemsg "A totally chill WordPress Install Script."
  $dbpref=randoprefix
  echo "Torchwood options are automatically applied."
  echo "DB NAME: torchwood"
  echo "DB USER: homestead"
  echo "DB PASS: secret"
  echo "DB PREF: ${dbpref}"
  echo "run install? (y/n)"
  read -e run

  if [ "$run" == n ]; then
    exit
  else
    WHATEVS "Okay WordPress for you."
    #download wordpress
    curl -O https://wordpress.org/latest.tar.gz
    #unzip wordpress
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
    $dbname="torchwood"
    $dbuser="homestead"
    $dbpass="secret"

    perl -pi -e "s/database_name_here/$dbname/g" wp-config.php
    perl -pi -e "s/username_here/$dbuser/g" wp-config.php
    perl -pi -e "s/password_here/$dbpass/g" wp-config.php
    sed -i -e "s/wp_/$dbpref/g" wp-config.php
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
    #remove zip file
    rm latest.tar.gz
  fi
}

exit 0
