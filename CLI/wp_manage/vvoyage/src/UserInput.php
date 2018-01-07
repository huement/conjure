<?php

namespace VVoyage;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Yaml\Yaml;

class UserInput
{
    public function __construct($input, $output, $helper)
    {
        $this->input = $input;
        $this->output = $output;
        $this->helper = $helper;
    }
    
    public function promptUser($question, $undefinedMsg = null, $default = false, $additionalValidator = null, $site = null)
    {
        $this->additionalValidator = $additionalValidator;
        $this->site = $site;
        $question = new Question("<info>{$question}</info> ", $default);
        $question->setValidator(function($value) {
            if(!isset($default) && trim($value) == "") {
                throw new \Exception($undefinedMsg);
            }
            switch ($this->additionalValidator) {
                case "siteExists":
                    if (!file_exists("/vagrant/www/{$value}")) {
                        throw new \Exception("The specified site does not exist");
                    }
                    break;
                case "wpversion":
                    if (!is_numeric($value) && !in_array($value, ["latest", "nightly"])) {
                        throw new \Exception("Please enter a version number, 'latest', or 'nightly'");
                    }
                    break;
                case "siteEnv":
                    $movefile = Yaml::parse(file_get_contents("/vagrant/www/{$this->site}/Movefile"));
                    if (!isset($movefile[$value])) {
                        throw new \Exception("The specified environment was not found in the site's Movefile");
                    } elseif ($value == "local") {
                        throw new \Exception("You cannot push to or pull from a local environment");
                    }
                    break;
                case "pushPull":
                    if ($value != "push" && $value != "pull") {
                        throw new \Exception("Please enter either 'push' or 'pull'");
                    }
                    break;
            }
            return $value;
        });

        $response = $this->helper->ask($this->input, $this->output, $question);
        return $response;
    }
    
    public function confirmationQuestion($question)
    {
        $question = new ConfirmationQuestion("<info>{$question} (y/N)</info> ", false);
        $response = $this->helper->ask($this->input, $this->output, $question);
        return $response;
    }
}