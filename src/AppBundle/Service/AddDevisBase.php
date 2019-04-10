<?php


namespace AppBundle\Service;

use AppBundle\Entity\Devis;

class AddDevisBase
{
    public function AddDevis($class,$em){

        $devis = new Devis();
        foreach (get_class_methods ($class) as $obj){

            if( strpos($obj,'get') !== false){

                if($obj == 'getDate')
                {
                    $devis->setDate1($class->{$obj}());
                }
                else if($obj != 'getId'){
                    $devis->{str_replace('get','set',$obj)}($class->{$obj}());
                }

            }

        }

        $em->persist($devis);
        $em->flush();
    }
}