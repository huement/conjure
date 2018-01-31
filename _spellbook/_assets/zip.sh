#!/usr/bin/env bash

DIR="/Volumes/FloppyDisk/Code/WP_Conjure/_spellbook/PLUGINS/enhance"

for folder in $DIR/*
do
	zip -r "${folder%/}" "${folder%/}"
done

