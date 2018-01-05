## roots.io/trellis
### Modern WP dev env
========================================

> Let Vagrant and Ansible do their thing. 
> After roughly 5-10 minutes you'll have a server running 
> and a WordPress site automatically installed and configured.

1.  Configure your site(s) based on the WordPress Sites docs and read the development specific ones.
2.  Make sure you've edited both group_vars/development/wordpress_sites.yml and group_vars/development/vault.yml.
3.  Optionally configure the IP address at the top of the vagrant.default.yml to allow for multiple boxes to be run concurrently (default is 192.168.50.5).
4.  Run vagrant up (from your trellis directory, usually the trellis/ subdirectory of your project).

