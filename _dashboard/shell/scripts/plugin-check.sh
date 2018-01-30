#!/bin/bash

# Bash script written by Saad Ismail - me@saadismail.net
# https://github.com/saadismail/ - https://www.linkedin.com/in/saaadyi

# Disable wordpress plugin one by one & asks if it resolves the issue
# Helpful to diagnose 500 error or White Page of Death

# Directory where wordpress is installed
dir="" # Must not have back-slash at end

cd ${dir}/wp-content/plugins

for i in *; do
  echo "Checking ${i} now"
  mv $i $i.bak
  echo "Did it work? 0 for no & 1 for yes"
  read confirm
  if [[ $confirm == "1" ]]; then
    echo "${i} had the issue"
    exit
  elif [[ $confirm == "0" ]]; then
    mv $i.bak $i
  else
    echo "I need a 0 or 1"
  fi
done
