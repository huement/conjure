<?php

namespace VVoyage;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use VVoyage\MigrationInterface;
use VVoyage\UserInput;

class MigrateSiteCommand extends Command
{
    protected function configure()
    {
        $this->setName("site:migrate")
            ->setDescription("Pushes or pulls a site from a specified environment");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper("question");
        $this->userInput = new UserInput($input, $output, $helper);
        
        $siteName = $this->siteName();
        $envName = $this->siteEnv($siteName);
        $action = $this->migrationAction();
        
        $migrationInterface = new MigrationInterface($siteName, $envName, $action);
        $migrationInterface->migrateSite();
        
        $output->writeln("Migration complete");
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
    
    protected function siteEnv($site)
    {
        $response = $this->userInput->promptUser(
            "Site environment name:",
            "Please specify an environment name",
            false,
            "siteEnv",
            $site
        );
        return $response;
    }
    
    protected function migrationAction()
    {
        $response = $this->userInput->promptUser(
            "Push or pull site:",
            "Please enter either 'push' or 'pull'",
            false,
            "pushPull"
        );
        return $response;
    }
}
