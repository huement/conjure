<?php

namespace VVoyage;

class MigrationInterface
{
    function __construct($site, $env, $action)
    {
        $this->site = $site;
        $this->env = $env;
        $this->action = $action;
    }
    
    public function migrateSite()
    {
        system("cd /vagrant/www/{$this->site}; wordmove {$this->action} -e {$this->env} --all");
    }
}