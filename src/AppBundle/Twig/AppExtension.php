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
            new \Twig_SimpleFilter('truncates', array($this, "truncateWhole")),
            new \Twig_SimpleFilter('toArray', array($this, "toArray")),
        );

    }

    public function toArray($array){
        $newArray = (array) $array;
        return $newArray;
    }
    public function cssloader($cssname){
        $this->cssArray[] = $cssname;
    }
    public function jsloader($jsname){
        if(!in_array($jsname,$this->jsArray)) {
            $this->jsArray[] = $jsname;
        }
    }

    public function kint($var,$arrayname){
        $array =  (array) $var;
        $array = json_decode(json_encode($var), true);
        return $array[$arrayname];
    }
    public function truncateWhole($string, $limit, $separator = '...')
    {
        $nwords = explode(' ',$string);
        $returnString = array_slice($nwords,0,$limit);
        return implode(' ',$returnString).$separator;
    }
}