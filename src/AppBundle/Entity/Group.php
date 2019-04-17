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
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $uuid;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_devis_goup", cascade={"all"})
     */
    private $user_id;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->uuid = \Ramsey\Uuid\Uuid::uuid4();
    }

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


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }



}