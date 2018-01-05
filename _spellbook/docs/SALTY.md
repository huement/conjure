# Homestead-Salty
Simple way to communicate with vagrant Homestead.

![salty example](https://i.imgur.com/NEree8o.png)

## Motivation

After a while using 'vagrant ssh' to enter on the homestead box and execute simple commands like 'php artisan make:controller FooController' and such, i start noticing the waste of time doing that. After see the shipping-docker/vessel package where you can do the commands on you project directory and that will reflect on the server. I built a small script to do the same with Laravel homestead.


## Example
```
./salty art route:list
```
In this example we are doing the same as:
```
cd Homestead
vagrant ssh
cd /Code/[project_folder]
art route:list
```

## Configurations
Thats not much to talk here, the only configurations that are used in this script is the .env file so if it is configured properly everything will work fine.
Your project files should be inside ~/Code folder on the homestead box in order this script to work.
Example of Homestead.yaml config:
```
...
folders:
    - map: ~\code
      to: /home/vagrant/Code
      ...
sites:
    - map: blog.dev
      to: /home/vagrant/Code/blog/public
    ...
```
if you don't follow this convention you can change the path to you project defining the DIR variable on the salty script:
```
DIR="[path]/${CURRENT_FOLDER}"
```
Default:
```
DIR="~/Code/${CURRENT_FOLDER}"
```
> Note: The first time you run ```./salty ... ``` will be shown something like ```Enter passphrase for ~/.ssh/id_rsa: ``` , you have to give your password that you enter when you done ```ssh-keygen ``` configure homestead.

## What's available ?
| Command       | Similar       |
| ------------- |:-------------:|
| ./salty artisan [args]     | same thing as 'php artisan' on homestead machine |
| ./salty art [args]      | short form to './salty artisan [args]'      |
| ./salty composer [args] | same thing as 'composer [args]' on homestead machine      |
| ./salty comp [args] | short form to './salty composer [args]'      |
| ./salty phpunit |  same thing as 'phpunit' on homestead machine      |
| ./salty test [args] | short form to './salty phpunit [args]'     |
| ./salty filter [args] |  same thing as 'phpunit --filter [args]' on homestead machine      |
| ./salty pf [args] | short form to './salty phpunit --filter [args]'     |
| ./salty migrate |  same thing as 'php artisan migrate' on homestead machine      |
| ./salty seed |  same thing as 'php artisan db:seed' on homestead machine      |
| ./salty dump |  creates a dump of the database specified on .env file as DB_DATABASE      |
| ./salty create:db |  creates a database based on DB_DATABASE specified on .env file      |
| ./salty npm |  runs npm on the server    |
| ./salty watch |  same thing as 'npm run watch-poll' no the server     |

## Instalation
You just need to download the salty script to you project folder.

Wget:
```
cd [project_folder]
wget https://raw.githubusercontent.com/namadnuno/Homestead-Salty/master/salty
```
CURL:
```
cd [project_folder]
curl https://raw.githubusercontent.com/namadnuno/Homestead-Salty/master/salty --output salty
```

## Support
> Right now i only have tested on windows with git-bash, but i will give feedback on Linux and Mac soon.

## Shortcuts
For a simple daily usage you can set an alias on .bashrc, .zshrc or on aliases.shs (Windows, C:\Program Files\Git\etc\profile.d\aliases.sh).
```
alias salty="./salty "
```
# Happy Coding
Give me some love [here!](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TATZK7AHTJP2E)

