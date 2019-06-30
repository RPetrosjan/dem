<?php

namespace AppBundle\Twig;

use AppBundle\Entity\ReadyDemandeDevis;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
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

    /** @var ContainerInterface  */
    private $container;

    /** @var EntityManagerInterface  */
    private $em;

    /** @var User object|string  */
    private $user;

    public function __construct(ContainerInterface $container, EntityManagerInterface $em) {
        $this->container = $container;
        $this->em = $em;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('company',[$this,'getUserInfo']),
            new \Twig_SimpleFunction('isDevisReaded',[$this,'isDevisReaded']),
        ];
    }

    public function getFilters(){

        return array(
            new \Twig_SimpleFilter('cssloader',array($this,'cssloader')),
            new \Twig_SimpleFilter('jsloader',array($this,'jsloader')),
            new \Twig_SimpleFilter('phone',array($this,'phoneloader')),
            new \Twig_SimpleFilter('strpos',array($this,'strpos')),
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

    public function strpos($string, $needle ) {

        return strpos($string, $needle);
    }

    public function getUserInfo() {
        return $this->container->get('security.token_storage')->getToken()->getUser();
    }

    public function isDevisReaded($uuid) {


      $result =  $this->em->getRepository(ReadyDemandeDevis::class)->getReadedDemandeDevis($this->container->get('security.token_storage')->getToken()->getUser(), $uuid);
      if(empty($result)) {
          return false;
      }
      else {
          return true;
      }
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