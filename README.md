# WP_Conjure
## A magical gateway into the Dark Arts

> I hate good wizards in fairy tales — they always turn out to be _him_.
>     -- River Song


### Recomended Magic

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