<?phpnamespace AppBundle\Entity\Traits;use AppBundle\service\ImageResize;use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;trait Image{    /**     * @ORM\Column(name="path", type="string")     */    public $path;    /**     * @ORM\Column(name="filename", type="string")     */    public $filename = '';    /** @var  */    protected $file;    /**     * @return mixed     */    public function getPath() {        return $this->path;    }    /**     * @param mixed $path     */    public function setPath($path) {        $this->path = $path;    }    /**     * @return mixed     */    public function getFilename() {        return $this->filename;    }    /**     * @param mixed $filename     */    public function setFilename($filename) {        $this->filename = $filename;    }    /**     * @return mixed     */    public function getFile() {        return $this->file;    }    /**     * Set file for upload     *     * @param $file     * @throws \Exception     */    public function setFile($file) {        $this->file = $file;        // If file name done        if (($fileName = $this->getFilename()) != null) {            $fileName = substr($fileName, 0, strpos($fileName, "?"));        }        // Remove old file        if (strlen($fileName) > 0 && file_exists($this->getUploadRootDir() . '/' . $fileName) === true) {            unlink($this->getUploadRootDir() . '/' . $fileName);        }        //Create new name for file        $type = $file->getClientMimeType();        $guesser = ExtensionGuesser::getInstance();        $guesser->guess($type);        $fileName = uniqid() . '.' . $guesser->guess($type);        // Resizing image        $image = new ImageResize($file->getRealPath() );        $image->quality_jpg = 100;        $image->resizeToWidth(300);        $image->save($this->getUploadRootDir() . '/' . $fileName );       /// $file->move($this->getUploadRootDir(), $fileName );      ///  $this->path = $this->uploadPath;        $this->filename = $fileName . '?' . uniqid();        $this->file = null;    }    public function getUploadRootDir() {        return __DIR__ . "/../../../../web/image/" . $this->uploadPath;    }    /**     * Get id     *     * @return integer     */    public function getId() {        return $this->id;    }    public function getWebPathImage() {        $webPath = $this->getUploadRootDir() . "/" . $this->filename;        return $webPath;    }}