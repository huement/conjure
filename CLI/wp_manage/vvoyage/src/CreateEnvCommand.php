<?php

namespace VVoyage;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use VVoyage\EnvInterface;
use VVoyage\UserInput;

class CreateEnvCommand extends Command
{
    protected function configure()
    {
        $this->setName("env:create")
            ->setDescription("Creates a new Wordmove environment in a site's Movefile");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper("question");
        $this->userInput = new UserInput($input, $output, $helper);
        do {
            $local = $this->userInput->confirmationQuestion("Are you configuring the local environment?");
            $siteName = $this->siteName();
            $url = $this->getUrl();
            
            if(!$local) {
                $wpPath = $this->wpPath();
                $envName = $this->envName();
                $sshHost = $this->sshHost();
                $sshPort = $this->sshPort();
                $sshUser = $this->sshUser();
                $dbHost = $this->dbHost();
                $dbName = $this->dbName();
                $dbUser = $this->dbUser();
                $dbPass = $this->dbPass();
            } else {
                $envName = "local";
                $wpPath = "/vagrant/www/{$siteName}/public_html";
                $sshHost = false;
                $sshPort = false;
                $sshUser = false;
                $dbHost = "localhost";
                $dbName = $siteName;
                $dbUser = "root";
                $dbPass = "root";
            }
            
            $confirmation = $this->userInput->confirmationQuestion("Is this information correct?");
        } while(!$confirmation);
        
        $envInterface = new EnvInterface($siteName);
        $envInterface->createEnv($local, $url, $wpPath, $envName, $sshHost, $sshPort, $sshUser, $dbHost, $dbName, $dbUser, $dbPass);
        
        $output->writeln("The new environment was added to the site's Movefile");
    }
    
    protected function siteName()
    {
        $response = $this->userInput->promptUser(
            "Site directory name:",
            "Please specify a site name",
            false,
            "siteExists"
        );
        return $response;
    }
    
    protected function getUrl()
    {
        $response = $this->userInput->promptUser(
            "Environment URL:",
            "Please specify an environment url"
        );
        return $response;
    }
    
    protected function dbUser()
    {
        $response = $this->userInput->promptUser(
            "Database user:",
            "The database user cannot be empty"
        );
        return $response;
    }
    
    protected function dbPass()
    {
        $response = $this->userInput->promptUser(
            "Database password:",
            "The database password cannot be empty"
        );
        return $response;
    }
    
    protected function wpPath()
    {
        $response = $this->userInput->promptUser(
            "WordPress path:",
            "The WordPress path cannot be empty"
        );
        return $response;
    }
    
    protected function dbName()
    {
        $response = $this->userInput->promptUser(
            "Database name:",
            "The database name cannot be empty",
            false
        );
        return $response;
    }
    
    protected function envName()
    {
        $response = $this->userInput->promptUser(
            "Environment name:",
            "Please specify an environment name"
        );
        return $response;
    }
    
    protected function sshHost()
    {
        $response = $this->userInput->promptUser(
            "SSH server:",
            "Please specify a SSH host"
        );
        return $response;
    }
    
    protected function sshServer()
    {
        $response = $this->userInput->promptUser(
            "SSH server:",
            "Please specify a SSH host"
        );
        return $response;
    }
    
    protected function sshUser()
    {
        $response = $this->userInput->promptUser(
            "SSH user: (leave blank for www-data)",
            "Please specify a SSH user",
            "www-data"
        );
        return $response;
    }
    
    protected function sshPort()
    {
        $response = $this->userInput->promptUser(
            "SSH port: (leave blank for 22)",
            "Please specify a SSH port",
            22
        );
        return $response;
    }
    
    protected function dbHost()
    {
        $response = $this->userInput->promptUser(
            "Database host: (leave blank for localhost)",
            "Please specify a database host",
            "localhost"
        );
        return $response;
    }
}
