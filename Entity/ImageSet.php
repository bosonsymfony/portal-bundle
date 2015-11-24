<?php

namespace UCI\Boson\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageSet
 *
 * @ORM\Table("por_imageset")
 * @ORM\Entity
 */
class ImageSet extends Content
{

    /**
     * @var array
     *
     * @ORM\Column(name="paths", type="simple_array")
     */
    private $paths;


    function __toString()
    {
        return 'image-set ' . $this->getId();
    }

    public function getType()
    {
        return 'image_set';
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
