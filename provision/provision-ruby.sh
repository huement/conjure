#!/usr/bin/env bash

start_seconds="$(date +%s)"

echo ""
echo "---------------------------------------------------------------------------------"
echo "|| STAGE 3 | RUBY [RVM] + GEMS + WORDMOVE                                      ||"
echo "---------------------------------------------------------------------------------"
echo ""
echo ""
echo ""

echo "  -------------* [ RUBY ] *-------------"
echo " "
if ! type rvm >/dev/null 2>&1; then
  echo 'rvm not installed - installing'
  mkdir -p /home/vagrant/.gnupg
  curl -sSL https://rvm.io/mpapis.asc | gpg --import -
  curl -L https://get.rvm.io | bash -s stable
  source /etc/profile.d/rvm.sh
  sudo cp -R /root/.gnupg/* /home/vagrant/.gnupg

  echo 'RVM Requesting use of ruby-2.5.0'
  rvm install 2.5.0
  rvm --default use 2.5.0
  source /etc/profile.d/rvm.sh

else
  echo 'rvm already installed'
fi

GEMDIR=$(which gem);

if [ "$GEMDIR" != "" ]; then

  echo "ruby-gem installed"

else

  echo "ruby-gem not installed - installing"

  gemdir 2.0.0

  sudo gem install rubygems-update --no-rdoc --no-ri

  update_rubygems

  echo 'gem: --no-rdoc --no-ri' >~/.gemrc

fi

# wordmove install
echo " "
echo "  RUBY | INSTALLING DEFAULT GEMS"
echo "  -------------------------------"
echo "  ${GEMDIR}"
echo " "

$GEMDIR install bundler
#gem install mailcatcher
$GEMDIR install compass
$GEMDIR install sass
$GEMDIR install rake
$GEMDIR install serverspec
$GEMDIR install gemcutter
$GEMDIR install compass-wordpress
$GEMDIR install wordpress_tools
#sudo gem install wordmove


WMDIR=$(which wordmove);

if [ "$WMDIR" != "" ]; then

  echo "WORDMOVE GTG!"

else

  echo "Configuring WORDMOVE................"

  # once photocopier goes 1.0 we can just install base wordmove
  $GEMDIR install wordmove --pre

  wordmove_path="$(gem which wordmove | sed -s 's/.rb/\/deployer\/base.rb/')"

  if [ "$(grep yaml $wordmove_path)" ]; then
    echo "WORDMOVE YAML GTG!"
  else
    sed -i "7i require\ \'YAML\'" $wordmove_path
    echo "SETUP WORDMOVE YAML"
  fi
fi

echo " "
echo "  RUBY | Initialzed, Installed, and ready to get down................"
echo " "

end_seconds="$(date +%s)"
echo " "
echo "---------------------------------------------------------------------------------"
echo "   STAGE 3 / 4 "
echo "   Completed in $((end_seconds - start_seconds)) seconds "
echo "---------------------------------------------------------------------------------"
echo " "
