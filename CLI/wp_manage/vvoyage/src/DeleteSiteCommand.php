<?php

namespace VVoyage;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use VVoyage\SiteInterface;
use VVoyage\UserInput;

class DeleteSiteCommand extends Command
{
    protected function configure()
    {
        $this->setName("site:delete")
            ->setDescription("Deletes a WordPress installation and it's database");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper("question");
        $this->userInput = new UserInput($input, $output, $helper);
        do {
            $siteName = $this->siteName();
            $confirmation = $this->userInput->confirmationQuestion("Are you sure you want to delete this site?");
        } while(!$confirmation);
        
        $siteInterface = new SiteInterface;
        $result = $siteInterface->deleteSite($siteName);
        
        $output->writeln("Site files and database deleted");
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
