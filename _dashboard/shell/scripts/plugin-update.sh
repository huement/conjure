#!/bin/bash

# Bash script written by Saad Ismail - me@saadismail.net
# https://github.com/saadismail/ - https://www.linkedin.com/in/saaadyi

# Update wordpress plugin one by one (Downloads from wordpress.org}
# Doesn't work with premium plugins, for those put .zip files under $tmpdir

# Directory where wordpress is installed
dir="" # Must not have back-slash at end

if [ -n "$1" ]; then
  dir=$1
fi

tmpdir="${dir}/tmp/plugins"

mkdir -p ${tmpdir}
cd ${dir}/wp-content/plugins

for plugin in *; do
        # Check if we already have that plugin
        if [[ -e ${tmpdir}/${plugin}.zip ]]; then
		echo "Plugin already exists"
        # Otherwise try to download it from wordpress repo
        else
                cd ${tmpdir}
                wget -q https://downloads.wordpress.org/plugin/${plugin}.zip
        fi

        # Making sure that we've that plugin now
        if [[ -e ${tmpdir}/${plugin}.zip ]]; then
                cp ${tmpdir}/${plugin}.zip ${dir}/wp-content/plugins/
                cd ${dir}/wp-content/plugins/
                rm -rf ${dir}/wp-content/plugins/${plugin}
                unzip -q ${dir}/wp-content/plugins/${plugin}.zip
                rm -f ${dir}/wp-content/plugins/${plugin}.zip
        else
                # If can't find that plugin on wordpress.org (Plugin is no long$
                echo "${plugin} failed"
        fi
done
