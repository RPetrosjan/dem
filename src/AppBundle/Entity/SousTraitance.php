<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MesDevisRepository")
 */
class SousTraitance extends \AppBundle\Entity\MesDevis
{

}