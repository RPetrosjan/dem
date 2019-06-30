<?php

namespace AppBundle\Entity;

use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * ViewDevisCount
 *
 * @ORM\Table(name="view_devis_count")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ViewDevisCountRepository")
 */
class ViewDevisCount
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $CreatedDate;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_user_view_devis", cascade={"persist"})
     */
    private $user_id;

    /**
     * UserConnect constructor.
     */
    public function __construct()
    {
        $date = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->CreatedDate;
    }

    /**
     * @param \DateTime $CreatedDate
     */
    public function setCreatedDate($CreatedDate)
    {
        $this->CreatedDate = $CreatedDate;
    }

    /**
     * @return User
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param User $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
}

