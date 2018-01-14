#!/usr/bin/env bash

echo ""
echo "UPDATING WP-CONFIG.php"
echo ""

cp $sFolder/.env.example $sFolder/.env
sed -i '' -e s/^DB_NAME=.*/DB_NAME=$siteFolderWithoutHomeDir/ $sFolder/.env
sed -i '' -e s/^DB_USER=.*/DB_USER=homestead/ $sFolder/.env
sed -i '' -e s/^DB_PASSWORD=.*/DB_PASSWORD=secret/ $sFolder/.env
sed -i '' -e 's,^WP_HOME=.*,WP_HOME=http://'"$devDomain"',g' $sFolder/.env
sed -i '' -e s/^AUTH_KEY=.*/AUTH_KEY=`random-string`/ $sFolder/.env
sed -i '' -e s/^SECURE_AUTH_KEY=.*/SECURE_AUTH_KEY=`random-string`/ $sFolder/.env
sed -i '' -e s/^LOGGED_IN_KEY=.*/LOGGED_IN_KEY=`random-string`/ $sFolder/.env
sed -i '' -e s/^NONCE_KEY=.*/NONCE_KEY=`random-string`/ $sFolder/.env
sed -i '' -e s/^AUTH_SALT=.*/AUTH_SALT=`random-string`/ $sFolder/.env
sed -i '' -e s/^SECURE_AUTH_SALT=.*/SECURE_AUTH_SALT=`random-string`/ $sFolder/.env
sed -i '' -e s/^LOGGED_IN_SALT=.*/LOGGED_IN_SALT=`random-string`/ $sFolder/.env
sed -i '' -e s/^NONCE_SALT=.*/NONCE_SALT=`random-string`/ $sFolder/.env

echo "Installing default plugins..."
cd 

# Go through the plugins and get them to the correct folder
for P in $wordpress_plugins; do
    curl -sS https://downloads.wordpress.org/plugin/$P > $P
    unzip -o $P
    rm $P
done)