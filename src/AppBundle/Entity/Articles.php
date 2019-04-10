<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticlesRepository")
 */
class Articles
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
     * @ORM\Column(name="NamePage", type="string", length=255)
     */
    private $namePage;

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
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="ArticleHtml", type="text")
     */
    private $articleHtml;

    /**
     * @var string
     *
     * @ORM\Column(name="idArticle", type="string", length=255)
     */
    private $idArticle;


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
     * Set namePage
     *
     * @param string $namePage
     *
     * @return Articles
     */
    public function setNamePage($namePage)
    {
        $this->namePage = $namePage;

        return $this;
    }

    /**
     * Get namePage
     *
     * @return string
     */
    public function getNamePage()
    {
        return $this->namePage;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Articles
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set articleHtml
     *
     * @param string $articleHtml
     *
     * @return Articles
     */
    public function setArticleHtml($articleHtml)
    {
        $this->articleHtml = $articleHtml;

        return $this;
    }

    /**
     * Get articleHtml
     *
     * @return string
     */
    public function getArticleHtml()
    {
        return $this->articleHtml;
    }

    /**
     * Set idArticle
     *
     * @param string $idArticle
     *
     * @return Articles
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    /**
     * Get idArticle
     *
     * @return string
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }
}

