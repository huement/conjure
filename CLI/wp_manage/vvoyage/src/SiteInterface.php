<?php

namespace VVoyage;

use Symfony\Component\Yaml\Yaml;

class SiteInterface
{
    function __construct()
    {
        touch("/vagrant/vvv-custom.yml");
        $this->input = Yaml::parse(file_get_contents("/vagrant/vvv-custom.yml"));
    }
    
    public function createSite($dbName, $wpVersion, $devDomain, $gitRepo, $multiSite)
    {
        $this->input["sites"][$dbName] = [
            "hosts" => [
                $devDomain,
                "www.{$devDomain}"
            ],
            "repo" => $gitRepo,
            "custom" => [
                "wp_version" => $wpVersion
            ]
        ];
        
        if($multiSite)
            $this->input[$dbName]["custom"]["wp_type"] = "subdomain";
        
        
        $yml = Yaml::dump($this->input, 10, 2);
        file_put_contents("/vagrant/vvv-custom.yml", $yml);
    }
    
    public function deleteSite($dbName)
    {
        unset($this->input["sites"][$dbName]);
        $yml = Yaml::dump($this->input, 10, 2);
        file_put_contents("/vagrant/vvv-custom.yml", $yml);
        
        $this->rmdir_recursive("/vagrant/www/{$dbName}");
        
        $conn = mysqli_connect("localhost:3306", "root", "root");
        $sql = "DROP DATABASE `{$dbName}`";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
    
    private function rmdir_recursive($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) $this->rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }
}