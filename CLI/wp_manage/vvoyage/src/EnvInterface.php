<?php

namespace VVoyage;

use Symfony\Component\Yaml\Yaml;

class EnvInterface
{
    function __construct($dirName)
    {
        $this->site = $dirName;
        touch("/vagrant/www/{$dirName}/Movefile");
        $this->input = Yaml::parse(file_get_contents("/vagrant/www/{$dirName}/Movefile"));
    }
    
    public function createEnv($local, $url, $wpPath, $envName, $sshHost, $sshPort, $sshUser, $dbHost, $dbName, $dbUser, $dbPass)
    {
        $siteName = $this->site;
        
        $this->input["global"] = [
            "sql_adapter" => "default"
        ];
        
        $this->input[$envName] = [
            "vhost" => $url,
            "wordpress_path" => $wpPath,
            "database" => [
                "name" => $dbName,
                "user" => $dbUser,
                "password" => $dbPass,
                "host" => $dbHost
            ],
        ];
        
        if(!$local) {
            $this->input[$envName]["ssh"] = [
                "host" => $sshHost,
                "user" => $sshUser,
                "port" => $sshPort
            ];
            $this->input[$envName]["exclude"] = [
                ".git/",
                ".gitignore",
                ".sass-cache/",
                "node_modules/",
                "bin/",
                "tmp/*",
                "Gemfile*",
                "Movefile",
                "wp-config.php",
                "wp-content/*.sql.gz"
            ];
        }
        
        $yml = Yaml::dump($this->input, 10, 2);
        file_put_contents("/vagrant/www/{$siteName}/Movefile", $yml);
    }
    
    public function deleteEnv($envName)
    {
        $siteName = $this->site;
        
        unset($this->input[$envName]);
        
        $yml = Yaml::dump($this->input, 10, 2);
        file_put_contents("/vagrant/www/{$siteName}/Movefile", $yml);
    }
}
