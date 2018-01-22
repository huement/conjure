```bash                                                                                                   
                                                                                                         
  ________/\\\\\\\\\_______/\\\\\_______/\\\\\_____/\\\______/\\\\\\\\\\\__/\\\________/\\\____/\\\\\\\\\______/\\\\\\\\\\\\\\\_
   _____/\\\////////______/\\\///\\\____\/\\\\\\___\/\\\_____\/////\\\///__\/\\\_______\/\\\__/\\\///////\\\___\/\\\///////////__
    ___/\\\/_____________/\\\/__\///\\\__\/\\\/\\\__\/\\\_________\/\\\_____\/\\\_______\/\\\_\/\\\_____\/\\\___\/\\\_____________
     __/\\\______________/\\\______\//\\\_\/\\\//\\\_\/\\\_________\/\\\_____\/\\\_______\/\\\_\/\\\\\\\\\\\/____\/\\\\\\\\\\\_____
      _\/\\\_____________\/\\\_______\/\\\_\/\\\\//\\\\/\\\_________\/\\\_____\/\\\_______\/\\\_\/\\\//////\\\____\/\\\///////______
       _\//\\\____________\//\\\______/\\\__\/\\\_\//\\\/\\\_________\/\\\_____\/\\\_______\/\\\_\/\\\____\//\\\___\/\\\_____________
        __\///\\\___________\///\\\__/\\\____\/\\\__\//\\\\\\__/\\\___\/\\\_____\//\\\______/\\\__\/\\\_____\//\\\__\/\\\_____________
         ____\////\\\\\\\\\____\///\\\\\/_____\/\\\___\//\\\\\_\//\\\\\\\\\_______\///\\\\\\\\\/___\/\\\______\//\\\_\/\\\\\\\\\\\\\\\_
          _______\/////////_______\/////_______\///_____\/////___\/////////__________\/////////_____\///________\///__\///////////////__    
        
                     
            
```

## Wordpress Wizardry

> I hate good wizards in fairy tales — they always turn out to be _him_.
>     -- River Song


### Table Of Contents
===============================

**TODO**
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.


### Directory Details
===============================

* _docs
  Docs & Info for Wordpress details, plugins, and/or functions.

* _spellbook
  Important plugins, templates and design files.

* _taskrunner
  Conjure automation, docs building, or other random tasks are kept locked inside.

* database
  Portal between the Vagrant virtual machine and your local dev box. **NOTE** `vagrant up --provision` creates DB Backup files using Vagrant hooks. 
  The reason being you can easily reload your data after vagrant boots. Never loose your box data.

* log
  Another portal from virtauls box to dev box. Here all the PHP error logs are symlinked. 
  So if any of your apps is having an issue, you can easily grab the logs and see whats up.

* provision
  Used to run `vagrant up --provision` to initially create the box. They install all the server side code, such as Ruby, Node (NVM), Composer packages etc etc.

* utilities
  This is a folder full of helper websites and the main **Conjure** Dashboard.
  You can easy see your memcache status, opcache, and much more! Flush WP Caches etc.

* www
  Imporant Public Folder that holds the websites / dev sites you're coding outand on go in this public folder.


```js
			                          ____ 
		+-- composer.json			          |            
		+-- conjure.sh			            |            
		+-- Homestead.yaml			         >-- Command & Configure          
		+-- package.json			          |            
		+-- Vagrantfile			        ____|
		│                           
		+-- _docs/			            ____              
		│   +-- WP_Code/			           |             
		│   +-- WP_Build/			          >-- Documentation           
		│   +-- WP_Stacks/			     ____|               
		│
		+-- _spellbook/			        ____             
		│   +-- Backend/			           |           
		│   +-- CLI/			               |           
		│   +-- Design/			           |         
		│   +-- Develop/			           |          
		│   +-- Document/			         |           
		│   +-- Enhance/			           |           
		│   +-- Logging/			            >-- WP Plugins, Templates, Testing tools           
		│   +-- NodeJS/			           |          
		│   +-- Page_Builders/	         |          
		│   +-- Performance/		         |          
		│   +-- Security/			         |         
		│   +-- Templates/			      ___|             
		│
		+-- _taskrunner/			       ___                      
		│   +-- config/			           |                  
		│   +-- tasks/			              >-- Task Automation                
		│   +-- webpack/			        ___|                    
		│
		+-- database/			                          
		│   +-- backups/			                       
		│   +-- db_backup.sh		                     
		│   +-- import-sql.sh		                   
		│   +-- init.sql			                       
		│
		+-- provision/			                        
		│   +-- config/			                       
		│   +-- provision-*.sh	                     
		│   +-- scripts/			                       
		│   +-- utilities.yaml	                     
		│
		+-- utilities/			                        
		│   +-- dashboard/			                     
		│   +-- database-admin/			               
		│   +-- files/			                         
		│   +-- memcached-admin/		                 
		│   +-- opcache-status/			               
		│   +-- php-cache-dashboard/                
		│   +-- status/			                       
		│
		+-- www/			                              
		    +-- webpress/			                      
		    +-- wp_dev/		
```


