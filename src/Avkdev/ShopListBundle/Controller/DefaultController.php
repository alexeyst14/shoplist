<?php

namespace Avkdev\ShopListBundle\Controller;

use Avkdev\ShopListBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository('AvkdevShopListBundle:Item');
        $items = $repo->getList();

        return $this->render(
            'AvkdevShopListBundle:Default:index.html.twig',
            array(
                'items' => $items,
                'last_refresh' => $repo->getLastChangeTimestamp(),
            )
        );
    }

    public function ajaxRefreshAction(Request $request)
    {
        /* @var $data \Doctrine\Common\Collections\ArrayCollection */
        $repo = $this->getDoctrine()->getRepository('AvkdevShopListBundle:Item');
        $data = $repo->findChangedAfterLastRefresh($request->get('last_refresh'));

        return new JsonResponse(
            array(
                'last_refresh' => $repo->getLastChangeTimestamp(),
                'data' => $data,
            )
        );
    }

    public function ajaxSaveItemAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        $entity = null;
        if (!empty($id)) {
            $entity = $em->getRepository('AvkdevShopListBundle:Item')->find($id);
        }
        if (!$entity) {
            $entity = new Item();
        }

        $entity->setTitle($request->get('title'));
        $entity->setStatus($request->get('status'));
        $em->persist($entity);
        $em->flush();

        $ret = array(
            'id' => $entity->getId(),
            'title' => $entity->getTitle(),
            'status' => $entity->getStatus(),
        );
        return new JsonResponse($ret);
    }
}
