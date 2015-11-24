<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/10/15
 * Time: 20:12
 */

namespace UCI\Boson\PortalBundle\Util;


use Symfony\Component\Yaml\Parser;

class Styles
{
    /**
     * @var array
     */
    private $styles;

    /**
     * Styles constructor.
     * @param $styles
     */
    public function __construct(array $styles)
    {
        $this->styles = $styles;
    }

    public function sizes()
    {
        return $this->styles['tile_sizes'];
    }

    public function colors()
    {
        return $this->styles['colors'];
    }

    public function icons()
    {
        return $this->styles['icons'];
    }

    public function effects()
    {
        return $this->styles['effects'];
    }
}