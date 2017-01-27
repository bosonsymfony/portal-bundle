<?php

namespace UCI\Boson\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Icon
 *
 * @ORM\Table("por_icon")
 * @ORM\Entity
 */
class Icon extends Content
{
    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255)
     */
    private $icon;


    /**
     * Set icon
     *
     * @param string $icon
     * @return Icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    function __toString()
    {
        return $this->icon;
    }

    public function getType()
    {
        return 'icon';
    }


}
