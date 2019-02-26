<?php

namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class AppExtension
 * @package AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    public $cssArray = [];
    public $jsArray = [];
    public function getFilters(){

        return array(
            new \Twig_SimpleFilter('cssloader',array($this,'cssloader')),
            new \Twig_SimpleFilter('jsloader',array($this,'jsloader')),
            new \Twig_SimpleFilter('phone',array($this,'phoneloader')),

        );

    }

    /**
     * @param $cssname
     */
    public function cssloader($cssname){
        $this->cssArray[] = $cssname;
    }
    public function jsloader($jsname){
        $this->jsArray[] = $jsname;
    }

    /**
     * @param mixed $phone
     */
    public function phoneloader($numTel) {
        $i=0;
        $j=0;
        $formate = "";
        while ($i<strlen($numTel)) { //tant qu il y a des caracteres
            if ($j < 2) {
                if (preg_match('/^[0-9]$/', $numTel[$i])) { //si on a bien un chiffre on le garde
                    $formate .= $numTel[$i];
                    $j++;
                }
                $i++;
            }
            else { //si on a mis 2 chiffres a la suite on met un espace
                $formate .= " ";
                $j=0;
            }
        }
        return $formate;
    }


}