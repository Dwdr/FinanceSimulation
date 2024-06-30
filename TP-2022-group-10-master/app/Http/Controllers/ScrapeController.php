<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;

class ScrapeController extends Controller
{

    public function scraper(){
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', 'https://www.stproperty.sg/singapore-property-listings/property-for-sale');
        $crawler2 = $client->request('GET', 'https://www.srx.com.sg/singapore-property-listings/property-for-sale');
        $crawler3 = $client->request('GET', 'https://www.knightfrank.com/property-for-sale/singapore');
        $crawler4 = $client->request('GET', 'https://www.propertyforsale.com.sg/Search?type=1&property_type=any&location=&min_floor_size=any&max_floor_size=any&tenure%5B%5D=any&bedrooms%5B%5D=any&bathrooms%5B%5D=any&min_price=any&max_price=any&min_psf=any&max_psf=any&submit=');
        $crawler5 = $client->request('GET', 'https://www.99.co/singapore/sale');


        // $crawler->filter('.listingDetail')->each(function ($node) {
        //     echo '<pre></pre>';
        //     print $node->text()."\n";
        //     //var_dump($node->text());
        // });


        $crawler->filter('.listingContainer')->each(function ($node) {
            $detail = $node->filter('.listingDetail')->text();
            $link = $node->filter('.listingPhoto')->link()->getUri();
            //$img = file_get_contents($link);
            echo '<pre></pre>';
            echo $detail."\n";
            echo '<pre></pre>';
            echo $link;
            
        });

        $crawler2->filter('.listingContainer')->each(function ($node2) {
            $detail2 = $node2->filter('.listingDetail')->text();
            $link2 = $node2->filter('.listingPhoto')->link()->getUri();
            echo '<pre></pre>';
            echo $detail2."\n";
            echo '<pre></pre>';
            echo $link2;
        });
        
        $crawler3->filter('.property-list')->each(function ($node3) {
            $detail3 = $node3->filter('h2')->text();
            $link3 = $node3->filter('span')->text();
            $price3 = $node3->filter('.number')->text();
            echo '<pre></pre>';
            echo $detail3."\n";
            echo $link3."\n";
            echo $price3;
        });

        $crawler4->filter('.property-body')->each(function ($node4) {
            $detail4 = $node4->filter('.property-body')->text();
            echo '<pre></pre>';
            echo $detail4;
        });

        $crawler5->filter('._2J3pS')->each(function ($node5) {
            $detail5 = $node5->filter('._1zvu5')->text();
            echo '<pre></pre>';
            echo $detail5;
        });


        // return $url ->html();
        }
}
