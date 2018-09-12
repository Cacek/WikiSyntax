<?php

class WikiSyntax
{
    protected $patterns = array();

    public function __construct()
    {
        /**
         * predefined patterns
         */
        $this->patterns = array(
            'bold' => array('pattern' => '/\*\*(.+?)\*\*/s', 'replacement' => '<b>$1</b>')
        , 'italic' => array('pattern' => '/\_(.+?)\_/s', 'replacement' => '<i>$1</i>')
        , 'fourSpaces' => array('pattern' => '/[ ]{4}(.*)[ ]{4}/ms', 'replacement' => '<pre>$1</pre>')
        , 'newLine' => array('pattern' => '/\r\n/', 'replacement' => "\n")
        , 'h1' => array('pattern' => '/^= (.+?) =$/m', 'replacement' => '<h1>$1</h1>')
        , 'h2' => array('pattern' => '/^== (.+?) ==$/m', 'replacement' => '<h2>$1</h2>')
        , 'h3' => array('pattern' => '/^=== (.+?) ===$/m', 'replacement' => '<h3>$1</h3>')
        );

    }

    /**
     * Converts input text according to the defined patterns
     * @param string input
     * @return string output
     */
    public function parse($input)
    {
        if (!$input) {
            return false;
        }

        list($patterns, $replacements) = $this->getPatternsInSeparateArrays();

        $input = preg_replace($patterns, $replacements, $input);

        return $input;
    }

    /**
     * @return array array(array patterns, array replacements)
     */
    protected function getPatternsInSeparateArrays()
    {
        $patterns = array();
        $replacements = array();
        foreach ($this->patterns as $label => $pattern) {
            $patterns[] = $pattern['pattern'];
            $replacements[] = $pattern['replacement'];
        }
        return array($patterns, $replacements);
    }
}


