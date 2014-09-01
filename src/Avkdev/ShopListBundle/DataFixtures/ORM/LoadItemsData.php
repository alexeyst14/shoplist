<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 01.09.14
 * Time: 19:03
 */

namespace Avkdev\ShopListBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Avkdev\ShopListBundle\Entity\Item;

class LoadItemsData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $datetime = new \DateTime();
        $datetime->modify('-1 day');

        $items = array(
            'Зонтик',
            'Каремат',
            'Теплая одежда',
            'Палатка',
            'Газовая горелка',
        );

        foreach ($items as $v) {
            $item = new Item();
            $item->setTitle($v)->setChangedAt($datetime)->setStatus(Item::STATUS_NORMAL);
            $manager->persist($item);
            $manager->flush();
            $datetime->modify('+1 hour');
        }
    }
}
