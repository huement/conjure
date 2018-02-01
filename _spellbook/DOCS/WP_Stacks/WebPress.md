# WORDPRESS

## VAGRANT INSTALL TODO LIST
*   Use VCCW Custom Config File
*   Base Plugin Packages (SPEED, DEBUG, BLOG, WOO)
*   Install new WP Dev site
*   Kinsta Importing into Wordmove
*   Elastic Search
*   REMOVE PHPMYADMIN for [https://www.adminer.org/](https://www.adminer.org/)
*   SnapShots [https://github.com/10up/wpsnapshots](https://github.com/10up/wpsnapshots)

## Wordpress Customizations
*   DATABSE Backups on Vagrant Halt
*   Logging [Event notifications](https://cramer.co.za/2016/11/02/event-notifier-1-2/)
*   Admin Area Upgrades
*   Documentation Generation [https://github.com/matzeeable/wp-hookdoc](https://github.com/matzeeable/wp-hookdoc)
*   Customizer Updates
*   Editor Upgrades
*   Plugin Groups [plugin-groups](https://wordpress.org/plugins/plugin-groups/)


## Wordpress Devtools
*   Plugin Boilerplate
*   Theme Boilerplate
*   Modern WP Stack (Trellis Bedrock Roots)
*   Less Extreme WP Stack
*   Options Editor [WP Options](https://github.com/mikeselander/wp-options-editor)


## Other Options
*   Wordpress Calypso
*   Scheduled / Social Postings
*   Project Manager
*   Knowledge Base
*   Multisite? [https://github.com/stuttter/wp-multi-network](https://github.com/stuttter/wp-multi-network)

 

## COMPOSER FIXES

```json
"require": {
       "vendor/my-private-repo": "dev-master"
   },
"repositories": [
  {
      "type": "vcs",
      "url":  "git@bitbucket.org:vendor/my-private-repo.git"
  }
]
```