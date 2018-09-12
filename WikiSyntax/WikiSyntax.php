<?php

class WikiSyntax
{
    private $fromWiki, $toHtml;

    public function __construct()
    {

        $this->fromWiki = array(
            "/\*\*(.+?)\*\*/s",                    //**bold**
            "/\_(.+?)\_/s",                        // _italic_
            "/^ {4}(.+?) {4}$/ms",                       //4 spaces
            //TODO: bold-italic????
            "/\r\n/",
        );

        $this->toHtml = array(
            "<b>$1</b>",
            "<i>$1</i>",
            "<pre>$1</pre>",
            "\n",
        );
    }

    public function parser($input)
    {
        if (!empty($input))
            $output = preg_replace($this->fromWiki, $this->toHtml, $input);
        else
            $output = false;
        return $output;
    }

}