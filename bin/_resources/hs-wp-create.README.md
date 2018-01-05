# Homestead Wordpress Generator

Tools to generate and remove Homestead projects. Supports UNIX based OS's.

## Requirements

 - Homestead and its requirements: https://laravel.com/docs/5.4/homestead
   - Tested version: v6.1.0
 - Node, NPM (Yarn) (All optional)
   - Node: https://nodejs.org/
   - NPM: https://www.npmjs.com/
   - Yarn: https://yarnpkg.com/
 - Composer (Optional): https://getcomposer.org/

## Installation
Clone this repo to a folder (for example ~/workspace/homestead-wp-generator).
Continue to the next step by your OS.

### Linux
```
echo "PATH=$PATH:~[folder the repo is in]/bin" >> ~/.bashrc
```

### Mac
```
echo "[folder the repo is in]/bin" | sudo tee -a /etc/paths
```

## Usage
You can run the script by reopening the terminal after the last step. 
Run it by typing `hs-wp-create`.

### Defaults
You can change the defaults for your needs. Defaults.ini file can be found in this project's root folder.

### Our default Wordpress boilerplate project
https://github.com/phzfi/wordpress-boilerplate
### Our local Jenkins Docker
https://github.com/phzfi/bedrock-jenkins-docker

## Possible issues
  codesniffer requires php-simplexml  
Try `apt install php-xml`. Now you should have PHP-simplexml installed.

## Honorable mentions
This script was inspired and started from this thread's starting post:  
https://laracasts.com/discuss/channels/tips/automatically-create-new-project-in-homestead-20  
  
Jenkins Job creation adjusted from this repo  
https://github.com/adampats/bash

## License
Can be found in the LICENSE file.
