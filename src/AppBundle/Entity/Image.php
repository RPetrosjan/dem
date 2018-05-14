<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 26.02.2018
 * Time: 02:18
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Traits\Image as ImageTrait;
/**
 * Image
 *
 * @ORM\Table(name="ImageType")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Image")
 */
class Image
{

    use ImageTrait;

    public $uploadPath = "destinations";

    public function getWebPath()
    {
        $webPath = "uploads/".$this->uploadPath."/".$this->filename;
        return $webPath;
    }

    /**
     * @return string
     */
    public function getAltimage()
    {
        return $this->altimage;
    }

    /**
     * @param string $altimage
     */
    public function setAltimage($altimage)
    {
        $this->altimage = $altimage;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="altimage", type="string", length=255)
     */
    public $altimage;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    public $title;


    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __toString() {
        return $this->title;
    }

}