#!/usr/bin/env bash

set -e

if [[ -d /home/vagrant/database/backup ]]; then
	echo "exist /home/vagrant/database/backup"
else
	mkdir /home/vagrant/database/backup
	echo "create /home/vagrant/database/backup"
fi

wp db export /home/vagrant/database/backup/backup-`date +%Y%m%d%H%M%S`.sql

exit
