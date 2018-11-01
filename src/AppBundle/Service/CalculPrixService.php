<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 02.07.2018
 * Time: 23:30
 */

namespace AppBundle\Service;


class CalculPrixService
{
    // Usure Camion euro pro kilometer
    const USURE_CAMION = 0.8;

    // Price par Etage
    // Par chaque salarie le price par etage en euros
    const PAR_ETAGE = 2;

    // Price si avec ou sans ascenseur
    const MODE_ASCENSEUR = ['Oui' => -2, 'No' => 0];


    // Marge en %
    const MARGE = 30;

    // Price en euro Meteriel pro m3 volume
    const MATERIEL = 3;


    // Salaire pro Prestation euro/heure
    const SALAIRE_PRESTATION = array(
        'Économique' => array(
            'Salaire' => 50,
        ),
        'Standard' => array(
            'Salaire' => 60,
        ),
        'Luxe' => array(
            'Salaire' => 80,
        ),
    );

    // TVA du demenagement 20%
    const TVA = 20;

    // Price pour diesel Camion 15L/100 km
    const DIESEL_PRO_KM = 0.15;

    // Cout d'un prix diesel
    const DIESEL_PRIX = 1.4;


    public function GetCalculPrix($form_step) {

        // Get Distance entre 2 villes
        ///$distance = new GetDistance();
        //$distance = $distance->getDistance($form_step->getCp1(), $form_step->getCp2());
        $distance = 0;

        // Calculation Salaire Depart et Arrivee
        $salaire = self::SALAIRE_PRESTATION[$form_step->getPrestation()]['Salaire'];
        $salaire1 = $salaire + (self::MODE_ASCENSEUR[$form_step->getAscenseur1()] + self::PAR_ETAGE) * $form_step->getEtage1();
        $salaire2 = $salaire + (self::MODE_ASCENSEUR[$form_step->getAscenseur2()] + self::PAR_ETAGE) * $form_step->getEtage2();

        // Calculation nomre de ouvrier
        $nombre_ouvrier = floor($form_step->getVolume() / 10) +1;
        // Il faut touours min 2 ouvrier
        if($nombre_ouvrier < 2){
            $nombre_ouvrier = 2;
        }

        // Calculation temps de chargement et dechargement
        $horaireschargement = $nombre_ouvrier/2;

        // Prix du chargement et dechargement
        $prixchargement = $nombre_ouvrier * $salaire1 * $horaireschargement;
        $prixdechargement = $nombre_ouvrier * $salaire2 * ($horaireschargement - 0.5);

        // Caculation du prix Materiel et usure du camion
        $prixmateriel = self::MATERIEL * $form_step->getVolume() + self::MATERIEL * $form_step->getVolume() * self::TVA/100;
        $prixcamion = self::DIESEL_PRO_KM * $distance * self::DIESEL_PRIX + self::USURE_CAMION * $distance;

        $totaldevis = $prixchargement + $prixdechargement + $prixmateriel + $prixcamion;
        $totaldevis = $totaldevis + $totaldevis * self::TVA/100 + $totaldevis * self::MARGE/100;

        $totaldevis = intval($totaldevis)." - ".round(intval($totaldevis)+(30*intval($totaldevis))/100);

        return array(
            'distance' => $distance,
            'totalprice' => $totaldevis,
        );
    }
}