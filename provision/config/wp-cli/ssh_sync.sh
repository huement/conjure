#!/usr/bin/env bash

#
# SSH SYNC SCRIPT
#
# QUICKLY MOVE BETWEEN DEV/STAGE/PROD
# REQUIRES SSH ON REMOTE
#

DEVDIR="/home/vagrant/code/wpdev/"
DEVSITE="https://wpdev.app"

PRODDIR="myriadmobile@35.184.184.103:49142/www/myriadmobile_606/public"
PRODSITE="https://myriadmobile.com/"

STAGDIR="myriadmobile@35.184.184.103:51840/www/myriadmobile_606/public"
STAGSITE="https://staging-myriadmobile.kinsta.com"

FROM=$1
TO=$2

case "$1-$2" in
development-production) DIR="up";  FROMSITE=$DEVSITE;  FROMDIR=$DEVDIR;  TOSITE=$PRODSITE; TODIR=$PRODDIR; ;;
development-staging)    DIR="up"   FROMSITE=$DEVSITE;  FROMDIR=$DEVDIR;  TOSITE=$STAGSITE; TODIR=$STAGDIR; ;;
production-development) DIR="down" FROMSITE=$PRODSITE; FROMDIR=$PRODDIR; TOSITE=$DEVSITE;  TODIR=$DEVDIR; ;;
staging-development)    DIR="down" FROMSITE=$STAGSITE; FROMDIR=$STAGDIR; TOSITE=$DEVSITE;  TODIR=$DEVDIR; ;;
*) echo "usage: $0 development production | development staging | production development | production staging" && exit 1 ;;
esac

read -r -p "Would you really like to reset the $TO database and sync $DIR from $FROM? [y/N] " response

if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
  cd ../ &&
  wp "@$TO" db export &&
  wp "@$FROM" db export - | wp "@$TO" db import - &&
  wp "@$TO" search-replace "$FROMSITE" "$TOSITE" &&
  rsync -az --progress "$FROMDIR" "$TODIR"
fi


## USAGE
# ./sync.sh
# usage: ./sync.sh development production | development staging | production development | production staging

## EXAMPLES
# ./sync.sh development production
# ./sync.sh production development
