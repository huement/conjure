#!/usr/bin/env bash

echo ''
echo 'Installing A modern WordPress stack (non standard folders).'
echo 'It simplifies the fuzziness around WordPress development.'
echo 'More info here: https://wordplate.github.io/'
echo ''
cd ../../www
composer create-project wordplate/wordplate
echo ''
echo '----- ALL DONE -----'
echo ''
