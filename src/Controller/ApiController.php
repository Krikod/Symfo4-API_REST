<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/listeRegions", name="listeRegions")
     */
    public function listeRegions(SerializerInterface $serializer)
    {
        $mesRegions = file_get_contents('https://geo.api.gouv.fr/regions');
        $mesRegionsTab = $serializer->decode($mesRegions, 'json');
//dump($mesRegionsTab);die();
        return $this->render('api/index.html.twig', array(
            'mesRegions' => $mesRegionsTab
        ));
    }
}
