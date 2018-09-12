<?php

class WikiException extends Exception
{
}


class WikiSyntaxController
{

    /**
     * @var WikiSyntax
     */
    protected $wikiSyntax = null;
    protected $wikiSyntaxFilename = 'WikiSyntax.php';
    protected $inputFilename = null;
    protected $outputFilename = null;

    public function __construct($inputFilename, $outputFilename)
    {
        $this->inputFilename = $inputFilename;
        $this->outputFilename = $outputFilename;
        $this->run();
    }

    protected function run()
    {
        try {
            $output = $this->processInput($this->getInput());
            $this->saveOutput($output, $overwrite = true);
        } catch (WikiException $e) {
            die('framework ok, issue: ' . $e->getMessage());
        } catch (Exception $e) {
            die('A weird exception: ' . $e->getMessage());
        }
    }

    protected function processInput($input)
    {
        $output = $this->getWikiSyntax()->parse($input);

        var_dump($output); //debug

        if ($output === false) {
            throw new WikiException('There was an error parsing input file');
        }

        if ($input && !$output) {
            throw new WikiException('Output yelds no data although input wasn\'t empty. Could that be an issue with WikiSyntax parser?');
        }
        return $output;
    }

    /**
     * @return WikiSyntax
     * @throws WikiException
     */
    protected function getWikiSyntax()
    {
        if (is_null($this->wikiSyntax)) {
            if (!file_exists($this->wikiSyntaxFilename)) {
                throw new WikiException('Wiki syntax file was not found');
            }
            require_once($this->wikiSyntaxFilename);

            $this->wikiSyntax = new WikiSyntax();
        }
        return $this->wikiSyntax;
    }

    protected function getInput()
    {
        if (!file_exists($this->inputFilename)) {
            throw new WikiException('Input filename was not found');
        }
        $input = file_get_contents("input.wiki");

        if ($input === false) {
            throw new WikiException('There was an error reading input file');
        }
        if (!$input) {
            throw new WikiException('Input file is empty, should this be an exception?');
        }
        return $input;
    }

    protected function saveOutput($output, $overwrite = false)
    {
        if ($overwrite && file_exists($this->outputFilename)) {
            $removed = unlink($this->outputFilename);
            if (!$removed) {
                throw new WikiException('Failed removing old output file. Wrong permission?');
            }
        }
        $saved = file_put_contents($this->outputFilename, $output);
        if (!$saved) {
            throw new WikiException('Failed saving output file');
        }
    }
}

new WikiSyntaxController('input.wiki', 'output.html');
