<?php

namespace VVoyage;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

use VVoyage\EnvInterface;
use VVoyage\UserInput;

class DeleteEnvCommand extends Command
{
    protected function configure()
    {
        $this->setName("env:delete")
            ->setDescription("Removes a Wordmove environment from a site's Movefile");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper("question");
        $this->userInput = new UserInput($input, $output, $helper);
        do {
            $siteName = $this->siteName();
            $envName = $this->getEnvName();
            
            $confirmation = $this->userInput->confirmationQuestion("Are you sure you want to delete this enviroment?");
        } while(!$confirmation);
        
        $envInterface = new EnvInterface($siteName);
        $envInterface->deleteEnv($envName);
        
        $output->writeln("The environment was removed from the site's Movefile");
    }
    
    protected function getEnvName()
    {
        $response = $this->userInput->promptUser(
            "Environment name:",
            "The environment name cannot be empty"
        );
        return $response;
    }
    
    protected function siteName()
    {
        $response = $this->userInput->promptUser(
            "Site directory name:",
            "Please specify a directory name",
            false,
            "siteExists"
        );
        return $response;
    }
}
