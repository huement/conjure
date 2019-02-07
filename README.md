```    

              o         _______              __
          o   .        |       |-----.-----.|__|.--.--.----.-----.
        ________       |   ----|  _  |      |  |   |  |   _|  -__|
      c(` |   ' )o     |_______|_____|___|__|  |______|__| |_____|
        \   ` ,/         ---------------|______|----------------
       _//^-^ ^\\_            Wondrous Wordpress Wizardry
      
```

>  Klaatu Barada Nikto. I got it, I got it! I know your damn words, alright?
>     -- Ashley J. Williams

# Magic Wordpress Box
This README file covers the basics for setting up and using Conjure. For further details download the reposity and you can view full documentation as well as play around with some sample code to get you familiar with how things are done. 

If you have setup a Wordpress site, you should be plenty familiar with whats going on. If you have ever tried to locally develop a Wordpress site and later deploy that site to staging and production, you will appreciate exactly how much work has been put into making developing and deploying multiple sites easy to do.

## Directory Details
Here is a quick overview of the main Conjure directories. If you start making any changes to the heirarchy, expect things to break. 
Otherwise this layout is fairly robust and should adapt itself easily to any user environment. 

#### _docs
The projects documentation, as well as, any info regarding specific plugins, functions, or other relevant wordpress details.

#### _spellbook
Here you can find zipped up versions of important plugins, templates and design files.

#### _taskrunner
Any and all **Conjure** automation, docs building, or other random tasks are kept locked inside.

#### database
This is a portal between the Vagrant virtual machine and your local dev box. When vagrant goes down, all DB tables are backed up and sync'd back to the host.
Reason being, you can then run `vagrant destroy` on the VM, without having to start all over with your Wordpress customizations.

#### log
Another portal from virtauls box to dev box. Here all the PHP error logs are symlinked. So if any of your apps is having an issue, you can easily grab the logs and see whats up.

#### provision
These scripts and bits are used when you run `vagrant up --provision` or initially create the box. They install all the server side code, such as Ruby, Node (NVM), Composer packages etc etc.

#### utilities
This is a folder full of helper websites and the main **Conjure** Dashboard. Very helpful when you're developing. You can easy see your memcache status, opcache, and much more! Flush WP Caches etc.

#### www
This is a very important folder, and should be where you put all your development sites, cloned customer sites, etc. Basically anything you want to work on.


## Conjure Commands
There area a few general commands and functions that you will need to familiarize yourself with to take full advantage of this codebase. They generally revolve around either setting up a new Wordpress site, or optimizing an exsisting site. Conjure does not actually touch your Wordpress site, or alter its file structure in any way. It is more of a wrapper around the Wordpress codebase. Allowing you to find problem areas, test out updates, and of course, provide a straightforward way to develop locally. 






====================

#### Homeshed
A small CLI application for updating your Laravel Homestead configuration file, allows you to quickly update your Homestead.yaml file using simple commands. The tool is especially useful for creating development shortcuts and workflows.

To install, simply require it as a global composer dependency.
```bash
$ composer global require "eoghanobrien/homeshed" dev-master
```

To configure it, place a file called `.homeshed.json` in your $HOME directory. That file should contain a single reference to your local WP_Conjure location. 

The following commands will get that all setup nice and snappy like. Make sure you replace `/Users/YOUR_NAME/WP_Conjure` with your actual path.
```bash
$ touch ~/.homeshed.json
$ echo "{ \"homestead\": { \"path\": \"/Users/YOUR_NAME/WP_Conjure\" }}" | ~/.homeshed.json
```

#### Homeshed Commands
Once installed you can quickly and easily add/edit/remove all the important options from your WP_Conjure instance.
```bash
$ homeshed list                                                 # show all commands
$ homeshed add:site example.app Code/example                    # Adds a new site or updates an existing site
$ homeshed add:site example.app Code/example -t symfony4        # Add new site based on a type https://laravel.com/docs/5.5/homestead#site-types
$ homeshed add:site example.app Code/example -c                 # add cron schedule to site
$ homeshed add:database my_db                                   # add a new database
$ homeshed add:folder ~/my/local/folder /home/vagrant/folder    # add a shared folder from local to VM
```

You can also adjust the Virtual Machine's global settings, such as the CPU and Memory allowances.
```bash
$ homeshed set:cpus 2
$ homeshed set:memory 512
```