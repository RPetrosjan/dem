<?php


namespace AppBundle\Entity\Traits;


trait DevisCustomConfig
{
    /**
     * @var bool
     *
     * @ORM\Column(name="passge_fenetre", type="boolean")
     */
    private $passagefenetre;

    /**
     * @var bool
     *
     * @ORM\Column(name="portage", type="boolean")
     */
    private $portage;

    /**
     * @var bool
     *
     * @ORM\Column(name="digicode", type="boolean")
     */
    private $digicode;

    /**
     * @var bool
     *
     * @ORM\Column(name="monte_meubles", type="boolean")
     */
    private $montemeubles;

    /**
     * @var bool
     *
     * @ORM\Column(name="transbordement", type="boolean")
     */
    private $transbordement;

    /**
     * @var bool
     *
     * @ORM\Column(name="stationement", type="boolean")
     */
    private $stationement;

    /**
     * @var string
     *
     * @ORM\Column(name="nature", type="string", length=64, nullable=true)
     */
    private $nature;

    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=64, nullable=true)
     */
    private $client;

    /**
     * @return bool
     */
    public function isPassagefenetre()
    {
        return $this->passagefenetre;
    }

    /**
     * @param bool $passagefenetre
     */
    public function setPassagefenetre($passagefenetre)
    {
        $this->passagefenetre = $passagefenetre;
    }

    /**
     * @return bool
     */
    public function isPortage()
    {
        return $this->portage;
    }

    /**
     * @param bool $portage
     */
    public function setPortage($portage)
    {
        $this->portage = $portage;
    }

    /**
     * @return bool
     */
    public function isDigicode()
    {
        return $this->digicode;
    }

    /**
     * @param bool $digicode
     */
    public function setDigicode($digicode)
    {
        $this->digicode = $digicode;
    }

    /**
     * @return bool
     */
    public function isMontemeubles()
    {
        return $this->montemeubles;
    }

    /**
     * @param bool $montemeubles
     */
    public function setMontemeubles($montemeubles)
    {
        $this->montemeubles = $montemeubles;
    }

    /**
     * @return bool
     */
    public function isTransbordement()
    {
        return $this->transbordement;
    }

    /**
     * @param bool $transbordement
     */
    public function setTransbordement($transbordement)
    {
        $this->transbordement = $transbordement;
    }

    /**
     * @return bool
     */
    public function isStationement()
    {
        return $this->stationement;
    }

    /**
     * @param bool $stationement
     */
    public function setStationement($stationement)
    {
        $this->stationement = $stationement;
    }

    /**
     * @return string
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * @param string $nature
     */
    public function setNature($nature)
    {
        $this->nature = $nature;
    }

    /**
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }




}

