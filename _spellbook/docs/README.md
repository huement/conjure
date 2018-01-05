#.     Fortified Wordpress Automation  #

```bash
    ___________   .        __                           .    
    \_   ______|__________|  |_ ______  ____   ______ ______
     |    ___/    \_  __ \    _\_  __ \/ __ \ /  ___//  ___/ .
     |     \(  [ ] |  | \/|  |  |  |  \  ___/ \___ \ \__  \ 
     \___  / \____/|__|   |__|  |__|.  \___ _/____ /_____  >
         \/        ,            .                        \/ .      
```

### Wordpress Framework for Automation and Dependency Management ###

* [Composer](https://bitbucket.org/tutorials/markdowndemo)
* [Webpack](https://bitbucket.org/tutorials/markdowndemo)
* [Vagrant Box](https://bitbucket.org/tutorials/markdowndemo)


## SETUP + INSTALLING ##

This section will get you off and running with a proper wordpress development stack.

#### Install ####
`install.sh` can be found in the root directory. Running this script should make sure your machine meets all requirements. 
It will also download any required materials.

```bash
wget -O install.sh https://bitbucket.org/derekscott_mm/wordpress-automatic/downloads/install.sh
chmod +x ./install.sh
./install.sh
```

####  Custom Configurations  ####
Before you run the script, if you need any particular plugins, or themes installed, simply edit the **default.yml** file located in the provision directory. `/your_wordpress_install/provision/default.yml`

That file will allow you to make any changes or tweaks to your configuration. It will also allow you to manage any default composer dependecies, 
for both the wordpress site, and the wp-cli. 


## WHATS NEXT? ##

Once the script has finished, you should have a fresh copy of wordpress, setup with any plugins or themes you included. If you choose not to run vagrant up, your virtual machine won't be online, and you won't be able to inspect your handy work. 

However running `vagrant up` from your new WP directory, should allow you to visit **mmwp.app** in your web browser, From there you can get to getting it done development wise.


## SYNC TO PRODUCTION? ##

Well, for that we are going to use a Wordpress Command Line approach. 

For more information on that, please checkout the **WORDMOVE.md** file in this repository. It will walk you through the process.

