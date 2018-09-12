<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Social
 *
 * @ORM\Table(name="social")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SocialRepository")
 */
class Social
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
     * @var string
     *
     * @ORM\Column(name="SocialName", type="string", length=255)
     */
    private $socialName;

    /**
     * @var string
     *
     * @ORM\Column(name="SocialIcon", type="string", length=255)
     */
    private $socialIcon;

    /**
     * @var string
     *
     * @ORM\Column(name="SocialUrl", type="string", length=255)
     */
    private $socialUrl;


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
     * Set socialName
     *
     * @param string $socialName
     *
     * @return Social
     */
    public function setSocialName($socialName)
    {
        $this->socialName = $socialName;

        return $this;
    }

    /**
     * Get socialName
     *
     * @return string
     */
    public function getSocialName()
    {
        return $this->socialName;
    }

    /**
     * Set socialIcon
     *
     * @param string $socialIcon
     *
     * @return Social
     */
    public function setSocialIcon($socialIcon)
    {
        $this->socialIcon = $socialIcon;

        return $this;
    }

    /**
     * Get socialIcon
     *
     * @return string
     */
    public function getSocialIcon()
    {
        return $this->socialIcon;
    }

    /**
     * Set socialUrl
     *
     * @param string $socialUrl
     *
     * @return Social
     */
    public function setSocialUrl($socialUrl)
    {
        $this->socialUrl = $socialUrl;

        return $this;
    }

    /**
     * Get socialUrl
     *
     * @return string
     */
    public function getSocialUrl()
    {
        return $this->socialUrl;
    }
}

