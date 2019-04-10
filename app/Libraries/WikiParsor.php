<?php

namespace App\Libraries;

use Exception;
use DiDom\Document;

class WikiParsor
{
    // protected $parse;
    protected $title;
    protected $text;
    protected $langlinks;
    protected $document;
    protected $output;

    //
    public function __construct($contents)
    {
        $contents        = json_decode($contents);
        // $this->parse     = $contents->parse;
        $this->title     = $contents->parse->title;
        $this->text      = $contents->parse->text;
        $this->langlinks = $contents->parse->langlinks;

        $this->document = new Document($this->text);
        $this->setOutput();
    }

    public function checkStatus()
    {
        $output  = $this->output;
        //
        $redirectMsg = $output->first('.redirectMsg');
        if ($redirectMsg) {
            throw new Exception('It is redirected', 1);
            // $href  = $output->first('a')->href;
            // return ['is_redirect' => urldecode(parse_url($href, PHP_URL_PATH))];
        }

        return true;
    }

    public function setOutput()
    {
        $output = $this->document->find('.mw-parser-output');
        if (count($output) > 0) {
            $this->output = $output[0];
        } else {
            throw new Exception('Not Find Output');
        }
    }

    public function getInfoBox()
    {
        $output  = $this->output;
        $infobox = $output->first('table.infobox');
        if (! $infobox) {
            throw new Exception('Not Find InfoBox');
        }

        return $infobox;
    }

    public function getSynopsis()
    {
        $synopsis = $this->output->first('p')->text();
        if (! $synopsis) {
            throw new Exception('Not Find Synopsis');
        }

        return $synopsis;
    }
}
