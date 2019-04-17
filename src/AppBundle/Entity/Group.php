<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="societe_group")
 */
class Group
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_devis_goup", cascade={"all"})
     */
    private $user_id;

    /**
     * @return User
     */
    public function getUserId()
    {
        if(is_null($this->user_id)) {
            $this->user_id = new User();
        }
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