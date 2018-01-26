# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'json'
require 'yaml'

# --------------[CONFIG MENU]----------------------------------------
vagrant_dir = File.expand_path(File.dirname(__FILE__))

#@branch = `if [ -f #{vagrant_dir}/.git/HEAD ]; then git rev-parse --abbrev-ref HEAD; else echo 'novcs'; fi`
#@branch = @branch.chomp("\n"); # remove trailing newline so it doesnt break the ascii art
@branch     = `git log --pretty=format:'%h' -n 1`
@show_logo  = false
@skipBackup = false
@conjureVERSION = "0.9.5"

# whitelist when we show the logo, else it'll show on global Vagrant commands
if [ 'up', 'resume', 'suspend', 'status', 'provision' ].include? ARGV[0] then
  @show_logo = true
end

if [ 'halt', 'reload', 'destroy' ].include? ARGV[0] then
  @show_logo = false
end
if ENV['CONJURE_NO_LOGO'] then
  @show_logo = false
end

if ENV['SKIPDB'] then
  @skipBackup = true
end

Vagrant.require_version '>= 1.9.0'

# --------------[CONFIGURING]----------------------------------------

dirChars=File.basename(vagrant_dir).length
dirTotal=(dirChars/0.5).ceil
if dirTotal > 4 || dirTotal < 0 then dirTotal = 0 end

client_vagrantfile = vagrant_dir + "/.conjure.json"
if File.exist? client_vagrantfile then
  conjure_settings = JSON.parse(File.read(File.expand_path "./.conjure.json"))
   @configuredName = conjure_settings['wizard_title']
   @configuredHost = conjure_settings['wizard_host']
     @configuredIP = conjure_settings['wizard_ip']
         @birthDay = conjure_settings['created_on']
else
  puts " "
  puts "  ------------------------[FAILURE]-------------------------  "
  puts " "
  puts "      Conjure config missing.  Try this: conjure.sh setup     "
  puts " "
  puts "  ------------------------[ ABORT ]-------------------------  "
  puts " "
  abort " "
end

# --------------[CONFIG HOMESTEAD]----------------------------------------
VAGRANTFILE_API_VERSION ||= "2"

require File.expand_path(File.dirname(__FILE__) + '/provision/scripts/_conjure_menu.rb')
require File.expand_path(File.dirname(__FILE__) + '/provision/scripts/_conjure.rb')
utilSiteConfigs = File.expand_path(File.dirname(__FILE__) + "/provision/utilities.yaml")
devSiteConfigs = File.expand_path(File.dirname(__FILE__) + "/Homestead.yaml")


# --------------[CONFIG VAGRANT]----------------------------------------
Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    if File.exist? devSiteConfigs then
        settings = YAML::load(File.read(devSiteConfigs))
    else
        abort "ERROR! Config file not found: #{devSiteConfigs}"
    end

    if File.exist? utilSiteConfigs then
      utilities = YAML::load(File.read(utilSiteConfigs))
    end

    #
    # > You sort of start thinking anything’s possible if you’ve got enough nerve.
    # >    - Ginny Weasley
    #
    #config.vm.provision "file", source: "provision/config", destination: "/home/vagrant/config"
    config.vm.provision "file", source: "provision/scripts", destination: "/home/vagrant/scripts"
    config.vm.provision "file", source: "provision/vagrant_bin", destination: "/home/vagrant/bin"
    config.vm.synced_folder "provision/config/wp-cli", "/home/vagrant/.wp-cli", :mount_options => [ "dmode=777", "fmode=777" ]
    config.vm.synced_folder "database/", "/home/vagrant/database", :mount_options => [ "dmode=777", "fmode=777" ]
    config.vm.synced_folder "_spellbook", "/home/vagrant/_spells", :mount_options => [ "dmode=777", "fmode=777" ]


    if File.exist?(File.join(vagrant_dir,'database/data/mysql_upgrade_info')) then
      if vagrant_version >= "1.3.0"
        config.vm.synced_folder "database/backups/", "/var/lib/mysql", :mount_options => [ "dmode=777", "fmode=777" ]
      else
        config.vm.synced_folder "database/backups/", "/var/lib/mysql", :mount_options => [ "dmode=777", "fmode=777" ]
      end
    end


    #
    # LOG JAM  |  /home/vagrant/log/
    # Sync a single log directory from Vagrant to our local dev. No more searching for error files!
    #
    config.vm.synced_folder "log/", "/home/vagrant/log", :owner => "www-data"


    #
    # HOMESTEAD PROVISION
    #
    wizardHash = Hash.new
    wizardHash['name'] = @configuredName
    wizardHash['hostname'] = @configuredHost
    wizardHash['ip'] = @configuredIP


    #
    # RUBY WIZARDY
    # Combine our Utilities YAML with Homestead YAML
    #
    settings['sites'].concat utilities['sites']
    settings['folders'].concat utilities['folders']
    settings['databases'].concat utilities['databases']
    ## NOTE: If you set additional ports, use concat. If no ports. just assign.
    ## settings['ports'].concat utilities['ports']
    settings['ports'] = utilities['ports']


    #
    # HOMESTEAD
    # The main Laravel Provisioning process.
    #
    Homestead.configure(config, settings, wizardHash)


    # UPDATE THE /ETC/HOSTS File
    if Vagrant.has_plugin?('vagrant-hostsupdater')
        config.hostsupdater.aliases = settings['sites'].map { |site| site['map'] }
        config.hostsupdater.remove_on_suspend = true
    elsif Vagrant.has_plugin?('vagrant-hostmanager')
        config.hostmanager.enabled = true
        config.hostmanager.manage_host = true
        config.hostmanager.aliases = settings['sites'].map { |site| site['map'] }
    end


    #
    # CONJURE PROVISIONING
    # Now that homestead has completed its initial setup, we can add in some magic...
    #
    if File.exist?(File.join(vagrant_dir,'provision','provision-devtools.sh')) then
      config.vm.provision "default", type: "shell", path: File.join( "provision", "provision-devtools.sh" ), privileged: true, keep_color: true
    end

    if File.exist?(File.join(vagrant_dir,'provision','provision-ruby.sh')) then
      config.vm.provision "pre", type: "shell", path: File.join( "provision", "provision-ruby.sh" ), privileged: true, keep_color: true
    end

    if File.exist?(File.join(vagrant_dir,'provision','provision-utilities.sh')) then
      config.vm.provision "post", type: "shell", path: File.join( "provision", "provision-utilities.sh" ), privileged: true, keep_color: true
    end


    #
    # RESTORE SAVED DATABASE
    # If you want to start out with same SQL everytime, or restory save created via Vagrant Trigger.
    #
    if File.exist?(File.join(vagrant_dir,'database/data/mysql_upgrade_info')) then
      if vagrant_version >= "1.3.0"
        config.vm.synced_folder "database/data/", "/var/lib/mysql", :mount_options => [ "dmode=777", "fmode=777" ]
      else
        config.vm.synced_folder "database/data/", "/var/lib/mysql", :extra => 'dmode=777,fmode=777'
      end

      # The Parallels Provider does not understand "dmode"/"fmode" in the "mount_options" as
      # those are specific to Virtualbox. The folder is therefore overridden with one that
      # uses corresponding Parallels mount options.
      config.vm.provider :parallels do |v, override|
        override.vm.synced_folder "database/data/", "/var/lib/mysql", :mount_options => []
      end
    end


    #
    # Vagrant Triggers
    #
    # If the vagrant-triggers plugin is installed, we can run various scripts on Vagrant
    # state changes like `vagrant up`, `vagrant halt`, `vagrant suspend`, and `vagrant destroy`
    #
    # These scripts are run on the host machine, so we use `vagrant ssh` to tunnel back
    # into the VM and execute things. By default, each of these scripts calls db_backup
    # to create backups of all current databases. This can be overridden with custom
    # scripting. See the individual files in config/homebin/ for details.
    if @skipBackup != true then
      if defined? VagrantPlugins::Triggers
        config.trigger.after :up, :stdout => true do
          system({'VVV_SKIP_LOGO'=> 'true'}, "vagrant ssh -c 'vagrant_up'")
        end
        config.trigger.before :reload, :stdout => true do
          system({'VVV_SKIP_LOGO'=> 'true'}, "vagrant ssh -c 'vagrant_halt'")
        end
        config.trigger.after :reload, :stdout => true do
          system({'VVV_SKIP_LOGO'=> 'true'}, "vagrant ssh -c 'vagrant_up'")
        end
        config.trigger.before :halt, :stdout => true do
          if ENV['SKIPDB'] != true then
            system({'VVV_SKIP_LOGO'=> 'true'}, "vagrant ssh -c 'vagrant_halt'")
          end
        end
        config.trigger.before :suspend, :stdout => true do
          system({'VVV_SKIP_LOGO'=> 'true'}, "vagrant ssh -c 'vagrant_suspend'")
        end
        config.trigger.before :destroy, :stdout => true do
          system({'VVV_SKIP_LOGO'=> 'true'}, "vagrant ssh -c 'vagrant_destroy'")
        end
      end
    end
end
