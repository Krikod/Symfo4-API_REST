<?php

namespace App\Controller;

use App\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
//        $mesRegionsTab = $serializer->decode($mesRegions, 'json');
//        $mesRegionsObjet = $serializer->denormalize($mesRegionsTab, 'App\Entity\Region[]');
        $mesRegions = $serializer->deserialize($mesRegions, 'App\Entity\Region[]', 'json');
//dump($mesRegionsObjet);die();

        return $this->render('api/index.html.twig', array(
            'mesRegions' => $mesRegions
        ));

    }/**
     * @Route("/listeDepsParRegions", name="listeDepsParRegions")
     */
    public function listeDepsParRegions(Request $request, SerializerInterface $serializer)
    {
//        Je récupère la région sélectionnée dans le code
        $codeRegion = $request->query->get('region');

//        Récupérer les régions
        $mesRegions = file_get_contents('https://geo.api.gouv.fr/regions');
        $mesRegions = $serializer->deserialize($mesRegions, 'App\Entity\Region[]', 'json');

        //      Je récup la liste des Deps
        if ($codeRegion == null || $codeRegion == 'Toutes') {
            $mesDeps = file_get_contents('https://geo.api.gouv.fr/departements');
        } else {
            $mesDeps = file_get_contents('https://geo.api.gouv.fr/regions/'.$codeRegion.'/departements');
        }
//        Décodage du json en array
        $mesDeps = $serializer->decode($mesDeps, 'json');
//dump($mesDeps);die();
        return $this->render('api/listDepsParRegion.html.twig', array(
            'mesRegions' => $mesRegions,
            'mesDeps' => $mesDeps
        ));
    }
}
