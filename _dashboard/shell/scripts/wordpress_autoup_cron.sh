#!/bin/bash

### Variables
today=$(date +%A\ %F\ %T)
installs=$(find /home/*/public_html/ -type f -iname wp-config.php|sed -r 's/\/wp-config\.php$//g')
logfile="/var/log/wordpress_autoupdate.log"

### Create variable arrays
installs=($installs)

### Wordpress Autoupdate Function

wp_update () {
  cpuser=$(pwd | cut -d/ -f3)
  wp="sudo -u $cpuser -i -- wp"
  path="--path=$i"
echo "Update Started: $today"
echo $i
echo "-----------------------------------"
$wp core update $path ;
$wp plugin update --all $path ;
$wp theme update --all $path ;
$wp core update-db $path 
echo "-----------------------------------"
echo
}

exec >> $logfile
for i in "${installs[@]}" ; do cd $i ; wp_update ; done
exit 0

