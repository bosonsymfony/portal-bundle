<?php
/**
 * Created by PhpStorm.
 * User: killer
 * Date: 3/12/15
 * Time: 12:11
 */

namespace UCI\Boson\PortalBundle\Util;


class Globals
{
    protected static $uploadDir;

    public static function setUploadDir($dir)
    {
        self::$uploadDir = $dir;
    }

    public static function getUploadDir()
    {
        return self::$uploadDir;
    }
}