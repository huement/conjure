#!/usr/bin/env bash

# update packages
sudo apt-get update && sudo apt-get upgrade

# prerequisites
sudo apt-get install -y less libpcre3 git

# clone htan to /usr/lib/htan
sudo git clone https://github.com/adminstock/htan.git /usr/lib/htan

# create symbolic links to htan
[[ -f /sbin/htan ]] || sudo ln -s /usr/lib/htan/run /sbin/htan
[[ -f /usr/sbin/htan ]] || sudo ln -s /usr/lib/htan/run /usr/sbin/htan

# set permissions
sudo chmod u=rwx /usr/lib/htan/run

# run
sudo htan --yes --install=ssa
