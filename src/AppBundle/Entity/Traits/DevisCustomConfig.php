<?php


namespace AppBundle\Entity\Traits;


trait DevisCustomConfig
{
    /**
     * @var bool
     *
     * @ORM\Column(name="passge_fenetre1", type="boolean")
     */
    private $passagefenetre1;

    /**
     * @var bool
     *
     * @ORM\Column(name="portage1", type="boolean")
     */
    private $portage1;

    /**
     * @var bool
     *
     * @ORM\Column(name="digicode1", type="boolean")
     */
    private $digicode1;

    /**
     * @var bool
     *
     * @ORM\Column(name="monte_meubles1", type="boolean")
     */
    private $montemeubles1;

    /**
     * @var bool
     *
     * @ORM\Column(name="transbordement1", type="boolean")
     */
    private $transbordement1;

    /**
     * @var bool
     *
     * @ORM\Column(name="stationement1", type="boolean")
     */
    private $stationement1;

    /**
     * @var string
     *
     * @ORM\Column(name="nature1", type="string", length=64, nullable=true)
     */
    private $nature1;


    /**
     * @var bool
     *
     * @ORM\Column(name="passge_fenetre2", type="boolean")
     */
    private $passagefenetre2;

    /**
     * @var bool
     *
     * @ORM\Column(name="portage2", type="boolean")
     */
    private $portage2;

    /**
     * @var bool
     *
     * @ORM\Column(name="digicode2", type="boolean")
     */
    private $digicode2;

    /**
     * @var bool
     *
     * @ORM\Column(name="monte_meubles2", type="boolean")
     */
    private $montemeubles2;

    /**
     * @var bool
     *
     * @ORM\Column(name="transbordement2", type="boolean")
     */
    private $transbordement2;

    /**
     * @var bool
     *
     * @ORM\Column(name="stationement2", type="boolean")
     */
    private $stationement2;

    /**
     * @var string
     *
     * @ORM\Column(name="nature2", type="string", length=64, nullable=true)
     */
    private $nature2;

    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=64, nullable=true)
     */
    private $client;

    /**
     * DevisCustomConfig constructor.
     */
    public function DevisCustomTraitConstruct()
    {
        $this->passagefenetre1 = false;
        $this->portage1 = false;
        $this->digicode1 = false;
        $this->montemeubles1 = false;
        $this->transbordement1 = false;
        $this->stationement1 = false;

        $this->passagefenetre2 = false;
        $this->portage2 = false;
        $this->digicode2 = false;
        $this->montemeubles2 = false;
        $this->transbordement2 = false;
        $this->stationement2 = false;
    }

    /**
     * @return bool
     */
    public function isPassagefenetre1()
    {
        return $this->passagefenetre1;
    }

    /**
     * @param bool $passagefenetre1
     */
    public function setPassagefenetre1($passagefenetre1)
    {
        $this->passagefenetre1 = $passagefenetre1;
    }

    /**
     * @return bool
     */
    public function isPortage1()
    {
        return $this->portage1;
    }

    /**
     * @param bool $portage1
     */
    public function setPortage1($portage1)
    {
        $this->portage1 = $portage1;
    }

    /**
     * @return bool
     */
    public function isDigicode1()
    {
        return $this->digicode1;
    }

    /**
     * @param bool $digicode1
     */
    public function setDigicode1($digicode1)
    {
        $this->digicode1 = $digicode1;
    }

    /**
     * @return bool
     */
    public function isMontemeubles1()
    {
        return $this->montemeubles1;
    }

    /**
     * @param bool $montemeubles1
     */
    public function setMontemeubles1($montemeubles1)
    {
        $this->montemeubles1 = $montemeubles1;
    }

    /**
     * @return bool
     */
    public function isTransbordement1()
    {
        return $this->transbordement1;
    }

    /**
     * @param bool $transbordement1
     */
    public function setTransbordement1($transbordement1)
    {
        $this->transbordement1 = $transbordement1;
    }

    /**
     * @return bool
     */
    public function isStationement1()
    {
        return $this->stationement1;
    }

    /**
     * @param bool $stationement1
     */
    public function setStationement1($stationement1)
    {
        $this->stationement1 = $stationement1;
    }

    /**
     * @return string
     */
    public function getNature1()
    {
        return $this->nature1;
    }

    /**
     * @param string $nature1
     */
    public function setNature1($nature1)
    {
        $this->nature1 = $nature1;
    }

    /**
     * @return bool
     */
    public function isPassagefenetre2()
    {
        return $this->passagefenetre2;
    }

    /**
     * @param bool $passagefenetre2
     */
    public function setPassagefenetre2($passagefenetre2)
    {
        $this->passagefenetre2 = $passagefenetre2;
    }

    /**
     * @return bool
     */
    public function isPortage2()
    {
        return $this->portage2;
    }

    /**
     * @param bool $portage2
     */
    public function setPortage2($portage2)
    {
        $this->portage2 = $portage2;
    }

    /**
     * @return bool
     */
    public function isDigicode2()
    {
        return $this->digicode2;
    }

    /**
     * @param bool $digicode2
     */
    public function setDigicode2($digicode2)
    {
        $this->digicode2 = $digicode2;
    }

    /**
     * @return bool
     */
    public function isMontemeubles2()
    {
        return $this->montemeubles2;
    }

    /**
     * @param bool $montemeubles2
     */
    public function setMontemeubles2($montemeubles2)
    {
        $this->montemeubles2 = $montemeubles2;
    }

    /**
     * @return bool
     */
    public function isTransbordement2()
    {
        return $this->transbordement2;
    }

    /**
     * @param bool $transbordement2
     */
    public function setTransbordement2($transbordement2)
    {
        $this->transbordement2 = $transbordement2;
    }

    /**
     * @return bool
     */
    public function isStationement2()
    {
        return $this->stationement2;
    }

    /**
     * @param bool $stationement2
     */
    public function setStationement2($stationement2)
    {
        $this->stationement2 = $stationement2;
    }

    /**
     * @return string
     */
    public function getNature2()
    {
        return $this->nature2;
    }

    /**
     * @param string $nature2
     */
    public function setNature2($nature2)
    {
        $this->nature2 = $nature2;
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

