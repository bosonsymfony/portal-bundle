<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/03/15
 * Time: 14:43
 */
namespace UCI\Boson\PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UCI\Boson\PortalBundle\Entity\Image;
use UCI\Boson\PortalBundle\Entity\ImageSet;
use UCI\Boson\PortalBundle\Util\Styles;
use UCI\Boson\PortalBundle\Entity\Icon;
use UCI\Boson\PortalBundle\Entity\Live;
use UCI\Boson\PortalBundle\Entity\Tile;
use UCI\Boson\PortalBundle\Entity\TileGroup;

class LoadExampleTiles implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    function load(ObjectManager $manager)
    {
        $styles = new Styles($this->container->getParameter('portal'));
        //Load Tile Groups
        $backgrounds = $styles->colors();
        $effects = $styles->effects();
        $icons = $styles->icons();


        for ($i = 0; $i <= 3; $i++) {
            $tilegroup = new TileGroup();
            $tilegroup->setTitle('Title ' . ($i + 1));
            $tilegroup->setSize(rand(3, 5) * 130);
            $tilegroup->setActive(true);
            $manager->persist($tilegroup);
            $manager->flush();

            $length = $tilegroup->getSize() / 130 * 3;

            for ($j = 0; $j < $length; $j++) {
                $tile = new Tile();

                $tile->setSize('tile-square');
                $tile->setSelected(false);
                $tile->setBackgroung(array_rand($backgrounds));
                $tile->setDataEffect(array_rand($effects));
                $tile->setTileGroup($tilegroup);
                $manager->persist($tile);
                $manager->flush();

                for ($k = 0; $k < 3; $k++) {
                    if ($k == 1) {
                        $image = new Image();
                        $image->setPath('outlook.png');
                        $image->setTipo('icon');
                        $tile->addContent($image);
                        $manager->persist($image);
                    } else if ($k == 0) {
                        $icon = new Icon();
                        $icon->setIcon(array_rand($icons));
                        $tile->addContent($icon);
                        $manager->persist($icon);
                    } else {
                        $imageSet = new ImageSet();
                        $imageSet->setPaths(array(
                            'jeki_chan.jpg',
                            'shvarcenegger.jpg',
                            'vin_d.jpg',
                            'jolie.jpg',
                            'jek_vorobey.jpg'
                        ));
                        $tile->addContent($imageSet);
                        $manager->persist($imageSet);
                    }
                    $manager->flush();
                }

            }
        }
    }
}