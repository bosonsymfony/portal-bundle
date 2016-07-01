<?php

namespace UCI\Boson\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Tile
 *
 * @UniqueEntity(fields={"funcionalidad"},message="Existe un acceso directo con esa funcionalidad.")
 * @ORM\Table("por_tile")
 * @ORM\Entity(repositoryClass="UCI\Boson\PortalBundle\Repository\TileRepository")
 */
class Tile
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
     * @ORM\Column(name="selected", type="boolean", options={"default" = true})
     */
    private $selected;

    /**
     * @var string
     *
     * @ORM\Column(name="backgroung", type="string", length=255, nullable=true)
     */
    private $backgroung;


    /**
     * @var string
     *
     * @ORM\Column(name="foreground", type="string", length=255, nullable=true)
     */
    private $foreground;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="data_effect", type="string", length=255, nullable=true)
     */
    private $dataEffect;

    /**
     * @ORM\ManyToMany(targetEntity="UCI\Boson\PortalBundle\Entity\Content")
     * @ORM\JoinTable(name="por_tile_content",
     *      joinColumns={@ORM\JoinColumn(name="tile_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="content_id", referencedColumnName="id")}
     *      )
     */
    private $contents;

    /**
     * @ORM\OneToOne(targetEntity="UCI\Boson\SeguridadBundle\Entity\Funcionalidad", cascade={"persist"})
     */
    private $funcionalidad;

    /**
     * @ORM\ManyToOne(targetEntity="UCI\Boson\PortalBundle\Entity\TileGroup", inversedBy="myTiles")
     */
    private $tileGroup;


    function __toString()
    {
        return $this->id . '';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contents = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set selected
     *
     * @param boolean $selected
     * @return Tile
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * Get selected
     *
     * @return boolean
     */
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * Set backgroung
     *
     * @param string $backgroung
     * @return Tile
     */
    public function setBackgroung($backgroung)
    {
        $this->backgroung = $backgroung;

        return $this;
    }

    /**
     * Get backgroung
     *
     * @return string
     */
    public function getBackgroung()
    {
        return $this->backgroung;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Tile
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set funcionalidad
     *
     * @param \UCI\Boson\SeguridadBundle\Entity\Funcionalidad $funcionalidad
     * @return Tile
     */
    public function setFuncionalidad(\UCI\Boson\SeguridadBundle\Entity\Funcionalidad $funcionalidad = null)
    {
        $this->funcionalidad = $funcionalidad;

        return $this;
    }

    /**
     * Get funcionalidad
     *
     * @return \UCI\Boson\SeguridadBundle\Entity\Funcionalidad
     */
    public function getFuncionalidad()
    {
        return $this->funcionalidad;
    }

    /**
     * Set tileGroup
     *
     * @param \UCI\Boson\PortalBundle\Entity\TileGroup $tileGroup
     * @return Tile
     */
    public function setTileGroup(\UCI\Boson\PortalBundle\Entity\TileGroup $tileGroup = null)
    {
        $this->tileGroup = $tileGroup;

        return $this;
    }

    /**
     * Get tileGroup
     *
     * @return \UCI\Boson\PortalBundle\Entity\TileGroup
     */
    public function getTileGroup()
    {
        return $this->tileGroup;
    }

    /**
     * Set foreground
     *
     * @param string $foreground
     *
     * @return Tile
     */
    public function setForeground($foreground)
    {
        $this->foreground = $foreground;

        return $this;
    }

    /**
     * Get foreground
     *
     * @return string
     */
    public function getForeground()
    {
        return $this->foreground;
    }

    /**
     * Set dataEffect
     *
     * @param string $dataEffect
     *
     * @return Tile
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
     * Add content
     *
     * @param \UCI\Boson\PortalBundle\Entity\Content $content
     *
     * @return Tile
     */
    public function addContent(\UCI\Boson\PortalBundle\Entity\Content $content)
    {
        $this->contents[] = $content;

        return $this;
    }

    /**
     * Remove content
     *
     * @param \UCI\Boson\PortalBundle\Entity\Content $content
     */
    public function removeContent(\UCI\Boson\PortalBundle\Entity\Content $content)
    {
        $this->contents->removeElement($content);
    }

    /**
     * Get contents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContents()
    {
        return $this->contents;
    }
}
