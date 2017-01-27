<?php

namespace UCI\Boson\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TileGroup
 *
 * @ORM\Table("por_tilegroup")
 * @ORM\Entity(repositoryClass="UCI\Boson\PortalBundle\Repository\TileGroupRepository")
 */
class TileGroup
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
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="title_foreground", type="string", length=255, nullable=true)
     */
    private $titleForeground;

    /**
     * @ORM\OneToMany(targetEntity="UCI\Boson\PortalBundle\Entity\Tile", mappedBy="tileGroup", cascade={"remove"})
     */
    private $myTiles;


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
     * Set title
     *
     * @param string $title
     * @return TileGroup
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
     * Set active
     *
     * @param boolean $active
     * @return TileGroup
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->myTiles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add myTiles
     *
     * @param \UCI\Boson\PortalBundle\Entity\Tile $myTiles
     * @return TileGroup
     */
    public function addMyTile(\UCI\Boson\PortalBundle\Entity\Tile $myTiles)
    {
        $this->myTiles[] = $myTiles;

        return $this;
    }

    /**
     * Remove myTiles
     *
     * @param \UCI\Boson\PortalBundle\Entity\Tile $myTiles
     */
    public function removeMyTile(\UCI\Boson\PortalBundle\Entity\Tile $myTiles)
    {
        $this->myTiles->removeElement($myTiles);
    }

    /**
     * Get myTiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyTiles()
    {
        return $this->myTiles;
    }

    public function __toString()
    {

        return ($this->title) ? $this->title : $this->getId() . '';
    }


    /**
     * Set size
     *
     * @param integer $size
     * @return TileGroup
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set titleForeground
     *
     * @param string $titleForeground
     *
     * @return TileGroup
     */
    public function setTitleForeground($titleForeground)
    {
        $this->titleForeground = $titleForeground;

        return $this;
    }

    /**
     * Get titleForeground
     *
     * @return string
     */
    public function getTitleForeground()
    {
        return $this->titleForeground;
    }
}
