<?php
namespace AppBundle\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait Image
{
    /**
     * @ORM\Column(name="path", type="string")
     */
    public $path;

    /**
     * @ORM\Column(name="filename", type="string")
     */
    public $filename='';


    protected $file;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set file for upload
     *
     * @param $file
     */
    public function setFile($file)
    {
        $OriginFileName =preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
        $this->file = $file;
        if(($fileName = $this->getFilename()) == null)
        {
            $fileName = uniqid().'.'.$file->guessExtension();
        }
        else{
            $fileName = substr($fileName, 0, strpos($fileName, "?"));
        }

        if(file_exists ($this->getUploadRootDir().'/'.$fileName) === true){
            unlink($this->getUploadRootDir().'/'.$fileName);
        }

        $file->move($this->getUploadRootDir(), $fileName);
        $this->path = $this->uploadPath;
        $this->filename = $fileName.'?'.uniqid();
        $this->file = null;
    }

    public function getUploadRootDir()
    {
        return __DIR__ . "/../../../../web/img/" . $this->uploadPath;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getWebPathImage()
    {
        $webPath = $this->getUploadRootDir() . "/" . $this->filename;
        return $webPath;
    }
}