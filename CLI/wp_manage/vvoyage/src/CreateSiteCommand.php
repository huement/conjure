<?php

namespace VVoyage;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use VVoyage\SiteInterface;
use VVoyage\UserInput;

class CreateSiteCommand extends Command
{
    protected function configure()
    {
        $this->setName("site:create")
            ->setDescription("Provisions a new WordPress installation");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper("question");
        $this->userInput = new UserInput($input, $output, $helper);
        do {
            $dbName = $this->dbName();
            $wpVersion = $this->wpVersion();
            $devDomain = $this->devDomain($dbName);
            $gitRepo = $this->gitRepo();
            $multiSite = $this->enableMultisite();
            
            $confirmation = $this->userInput->confirmationQuestion("Is this information correct?");
        } while(!$confirmation);
        
        $siteInterface = new SiteInterface;
        $siteInterface->createSite($dbName, $wpVersion, $devDomain, $gitRepo, $multiSite);
        
        $output->writeln("Provision this vagrant box to complete the installation");
    }
    
    protected function dbName()
    {
        $response = $this->userInput->promptUser(
            "Database name:",
            "The database name cannot be empty"
        );
        return $response;
    }
    
    protected function wpVersion()
    {
        $response = $this->userInput->promptUser(
            "WordPress version: (leave blank for latest, nightly for trunk)",
            "The database name cannot be empty",
            "latest",
            "wpversion"
        );
        return $response;
    }
    
    protected function devDomain($dbName)
    {
        $response = $this->userInput->promptUser(
            "Development domain: (leave blank for {$dbName}.test)",
            null,
            "{$dbName}.test"
        );
        return $response;
    }
    
    protected function gitRepo()
    {
        $response = $this->userInput->promptUser(
            "Git repo to clone: (leave blank for a new site)",
            null,
            "https://github.com/Varying-Vagrant-Vagrants/custom-site-template.git"
        );
        return $response;
    }
    
    protected function enableMultisite()
    {
        $response = $this->userInput->confirmationQuestion("Enable multisite?");
        return $response;
    }
}
