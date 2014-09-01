<?php

namespace Avkdev\ShopListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AvkdevShopListBundle:Default:index.html.twig', array('name' => $name));
    }
}
