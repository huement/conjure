#!/bin/bash

# Source: http://webwiki.co/mass-reset-wordpress-user-passwords/

# Update passwords of all wordpress users with random 12 chars passwords & Email them the new passwords

users=$(mysql <dbname> -Bse "select user_login from wp_users")
array=( $users )
for user in "${array[@]}"
do
 password=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 12 | head -n 1)
 mysql <dbname> -e "update wp_users set user_pass = md5('$password') where user_login='$user'"
 email=$(mysql <dbname> -Bse "select user_email from wp_users where user_login='$user'")
 message="Your password for http://example.com/wp-admin has been reset, please login with the following\n\n $user \n $password"
 echo -e $message | mail -s "Example.com Password Reset" $email
 echo $user $password
done
