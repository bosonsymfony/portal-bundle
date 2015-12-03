<?php

namespace UCI\Boson\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use UCI\Boson\PortalBundle\Util\Globals;

/**
 * ImageSet
 *
 * @ORM\Table("por_imageset")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ImageSet extends Content
{

    /**
     * @var array
     *
     * @ORM\Column(name="paths", type="simple_array")
     */
    private $paths;

    /**
     * @var array
     */
    private $files;

    /**
     * ImageSet constructor.
     */
    public function __construct()
    {
        $this->files = array();
    }


    function __toString()
    {
        return 'image-set ' . $this->getId();
    }

    public function getType()
    {
        return 'image_set';
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files)
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
    }

    public function addFile(UploadedFile $file)
    {
        $this->files[] = $file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        foreach ($this->files as $file) {
            if (null !== $file) {
                $filename = sha1(uniqid(mt_rand(), true));
                $this->paths[] = $filename . '.' . $file->guessExtension();
            }
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        foreach ($this->files as $index => $file) {
            if (null !== $file) {
                $file->move($this->getUploadRootDir(), $this->paths[$index]);
            }
        }

        $this->files = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        foreach ($this->paths as $index => $path) {
            $absolutePath = $this->getUploadRootDir() . '/' . $path;
            if (file_exists($absolutePath)) {
                unlink($absolutePath);
            }
        }
    }

    protected function getUploadRootDir()
    {
        return Globals::getUploadDir();
    }


    /**
     * Set paths
     *
     * @param array $paths
     * @return ImageSet
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * Get paths
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }


}
