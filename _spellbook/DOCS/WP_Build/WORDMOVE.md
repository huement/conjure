# WORDPRESS SYNCHRONIZATIONS 

### Synchronization with advanced fields ###

> For a really great overview of requirements, installation, and usage, checkout this article:
> [move from local to remote servers](https://www.cloudways.com/blog/use-wordmove-to-move-code-and-databases-from-local-to-remote-servers/)

This will be a quick, no frills walk through. With that being entered, we are going to need a few things. 
If you have used the installer, you should have most of them already on your VM.
You will likely only need to setup your machine.

* [Wordmove](https://github.com/welaika/wordmove)
* [RSync](https://linux.die.net/man/1/rsync)


### Wordmove Install

Wordmove uses Ruby, which is already installed on MacOS. `gem install wordmove`

> If your Ruby version does not meet the minimium requirements, simply use **Ruby Version Manager**

> If you get a permissions error, you may have to run `sudo gem install wordmove`

If you need to update your Ruby version, consider using Ruby Version Manager. It can make your ruby requirements a lot easier for all your projects.
[RVM](https://rvm.io/) Install with `\curl -sSL https://get.rvm.io | bash -s stable`


### RSync

RSync should already be installed on your Mac, and installed on the remote wordpress vagrant install. We will be using RSync to ensure that all the uploads, themes, and anything else in wp-content is GTG. If you need anything else outside of wp-content, simply run more RSync commands.


## GET UP TO GET DOWN

Assuming the requirements and setup went okay, it should be time to sync your sites. First, you will need to create a **"Movefile"**. This is fairly easy to do. You simply run `wordmove init` from the wordpress install directory (the one with wp-config.php).

After that, you will need to open and edit that file, as only some of the information will be autofilled. 

Example Movefile that has been filled out for a Vagrant Box installation. 

```bash
global:
  sql_adapter: "default"
  
local:
  vhost: "http://mmwp.app"
  wordpress_path: "/var/www/html" # use an absolute path here

  database:
    name: "wordpress"
    user: "wordpress"
    password: "wordpress"
    host: "localhost"
    charset: "utf8"
```

That should have been generated and filled out via the `wordmove init` command. However, the tricky part comes when you need to define other targets, such as your production server.

Assuming you have a completly stock, vanilla wordpress install somewhere, you should be GTG. You will just need to make sure that your local dev wordpress can commmunicate with your fancy production installation. 

```bash
...

production:
  vhost: "http://bb9e.local/wordpress"                    # My macbook hosted site.
  wordpress_path: "/Users/derekscott/WebServer/wordpress" # use an absolute path here

  database:
    name: "wordpress"
    user: "root"                                          # locally installed mysql
    password: "parad3"
    host: "10.0.2.2"                                      
    port: "3306"
    
...
```

Finally the last part of the Movefile that really matters, is the "Sync" command, which is handeled via SSH.

**REMEMBER** the host will need to be the IP address of whatever your vagrant box is using. 
```bash
ssh:
  host: "10.0.2.2"
  user: "derekscott"
  rsync_options: --verbose
```


## TIPS AND TRICKS ##

If you are unsure about your virtual machines SSH settings, (basically what is really ran when you run vagrant ssh) you can easily output a config file that will make pulling from Vagrant Wordpress, onto a different server. To get the helpful file run `vagrant ssh-config > vagrant-ssh` and whatever your directory your in should now have the config file. Open it to read what Vagrant is up to you when you're not looking.

Its important that your local wordpress install, and your remote wordpress install, share the same configurations. This means that they have the same "db_prefix", as well as he same basic URL structure. If your dev admin address is dev.local/wp/wordpress/base/wp-admin and your production is dev.com/wp-admin, that could cause some issues. 


### Finishing up your synchronize ###

If you do get your poop in a group, and have made it through the bullshit, be pumped! All you need to do is run:

```bash
# Running this from my staging server wordpress install folder. 
wordmove pull -e production --debug --all       # Verbose, pull all options.
```

If everything has been configured correctly, you should very quickly have a complete DB mirror of your localdev project.

The only thing missing are any system files you may want synced. IE your theme, your media folder etc. To do that we will use one of the most tried and true options available: RSYNC.

```bash
# Sync my Vagrant wp-content folder with my production wp-content folder
rsync -avz -e "ssh -p 2200" vagrant@127.0.0.1:/var/www/html/wp-content ~/WebServer/wordpress/wp-content
```

Aside from possibly having to manually enable a plugin in the wp-admin UI, you should have a perfect mirrored image. 


### What about my posts and pages? ###

One thing we don't want to do is overwrite a production database with our demo data. Which is why we will intentionally not target those particular colums. For safety and peace of mind, you should backup and user posts, pages, or comments with the bundled **Wordpress Export Tool**. 

