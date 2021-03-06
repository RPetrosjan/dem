<?php

namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends \Twig_Extension
{
    public $cssArray = [];
    public $jsArray = [];
    public function getFilters(){

        return array(
            new \Twig_SimpleFilter('cssloader',array($this,'cssloader')),
            new \Twig_SimpleFilter('jsloader',array($this,'jsloader')),
            new \Twig_SimpleFilter('kint', array($this, "kint")),
        );

    }

    public function cssloader($cssname){
        $this->cssArray[] = $cssname;
    }
    public function jsloader($jsname){
        $this->jsArray[] = $jsname;
    }

    public function kint($var,$arrayname){
        $array =  (array) $var;
        $array = json_decode(json_encode($var), true);
        return $array[$arrayname];
    }
}