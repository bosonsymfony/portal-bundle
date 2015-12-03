<?php

namespace UCI\Boson\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Live
 *
 * @ORM\Table("por_live")
 * @ORM\Entity
 */
class Live
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="data_effect", type="string", length=255)
     */
    private $dataEffect;

    /**
     * @var string
     *
     * @ORM\Column(name="data_easing", type="string", length=255)
     */
    private $dataEasing;

    /**
     * @ORM\OneToMany(targetEntity="UCI\Boson\PortalBundle\Entity\Tile", mappedBy="live")
     */
    private $tiles;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dataEffect
     *
     * @param string $dataEffect
     * @return Live
     */
    public function setDataEffect($dataEffect)
    {
        $this->dataEffect = $dataEffect;

        return $this;
    }

    /**
     * Get dataEffect
     *
     * @return string 
     */
    public function getDataEffect()
    {
        return $this->dataEffect;
    }

    /**
     * Set dataEasing
     *
     * @param string $dataEasing
     * @return Live
     */
    public function setDataEasing($dataEasing)
    {
        $this->dataEasing = $dataEasing;

        return $this;
    }

    /**
     * Get dataEasing
     *
     * @return string 
     */
    public function getDataEasing()
    {
        return $this->dataEasing;
    }

    function __toString()
    {
        return $this->dataEffect . ' ' . $this->dataEasing;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tiles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tiles
     *
     * @param \UCI\Boson\PortalBundle\Entity\Tile $tiles
     * @return Live
     */
    public function addTile(\UCI\Boson\PortalBundle\Entity\Tile $tiles)
    {
        $this->tiles[] = $tiles;

        return $this;
    }

    /**
     * Remove tiles
     *
     * @param \UCI\Boson\PortalBundle\Entity\Tile $tiles
     */
    public function removeTile(\UCI\Boson\PortalBundle\Entity\Tile $tiles)
    {
        $this->tiles->removeElement($tiles);
    }

    /**
     * Get tiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTiles()
    {
        return $this->tiles;
    }
}
