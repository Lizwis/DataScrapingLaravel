<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Eddieace\PhpSimple\HtmlDomParser;

class WebScraperController extends Controller
{
    public function index()
    {
        // Create DOM from URL or file
        $html = HtmlDomParser::file_get_html('https://www.facebook.com');

        // Find all images
        foreach ($html->find('img') as $element) {
            echo $element->src . '<br>';
        }

        // Find all links
        foreach ($html->find('a') as $element) {
            echo $element->href . '<br>';
        }
    }
}