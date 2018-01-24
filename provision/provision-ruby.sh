#!/usr/bin/env bash

start_seconds="$(date +%s)"

echo ""
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 3 | RUBY [RVM] + GEMS + WORDMOVE                                      ||"
echo "---------------------------------------------------------------------------------"
echo ""
echo ""
echo ""

if ! type rvm >/dev/null 2>&1; then
  echo 'rvm not installed - installing'
  mkdir -p /home/vagrant/.gnupg
  curl -sSL https://rvm.io/mpapis.asc | gpg --import -
  curl -L https://get.rvm.io | bash -s stable
  source /etc/profile.d/rvm.sh
  sudo cp -R /root/.gnupg/* /home/vagrant/.gnupg
else
  echo 'rvm already installed'
fi

rvm install 2.5.0

echo 'trying to use ruby-2.5.0'
rvm --default use 2.5.0

if [ $(gem -v | grep '^2.') ]; then

  echo "ruby-gem installed"

else

  echo "ruby-gem not installed - installing"

  gemdir 2.0.0

  gem install rubygems-update --no-rdoc --no-ri

  update_rubygems

  echo 'gem: --no-rdoc --no-ri' >~/.gemrc

fi

# wordmove install
echo "Installing Ruby Gems................."
sudo -u vagrant gem install bundler
#gem install mailcatcher
sudo -u vagrant gem install compass
sudo -u vagrant gem install sass
sudo -u vagrant gem install rake
sudo -u vagrant gem install serverspec
sudo -u vagrant gem install gemcutter
sudo -u vagrant gem install compass-wordpress
sudo -u vagrant gem install wordpress_tools
sudo -u vagrant gem install wordmove



if [ "$wordmove_install" == true ]; then

  echo "Wordmove GTG!"

else

  echo "Configuring WORDMOVE................"

  # once photocopier goes 1.0 we can just install base wordmove
  #gem install wordmove --pre

  wordmove_path="$(gem which wordmove | sed -s 's/.rb/\/deployer\/base.rb/')"

  if [ "$(grep yaml $wordmove_path)" ]; then
    echo "WORDMOVE YAML GTG!"
  else
    sed -i "7i require\ \'YAML\'" $wordmove_path
    echo "SETUP WORDMOVE YAML"
  fi
fi

echo "Finished Ruby Gems install..........."
echo " "
echo " "

end_seconds="$(date +%s)"
echo " "
echo "---------------------------------------------------------------------------------"
echo "   STAGE 3 / 4 "
echo "   Completed in $((end_seconds - start_seconds)) seconds "
echo "---------------------------------------------------------------------------------"
echo " "
