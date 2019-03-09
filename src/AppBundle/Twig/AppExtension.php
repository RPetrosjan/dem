<?php

namespace AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
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

    private $container;


    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('company',[$this,'getUserInfo']),
        ];

    }

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

    public function getUserInfo() {
        return $this->container->get('security.token_storage')->getToken()->getUser();
    }

    /**
     * @param $numTel
     * @return string
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