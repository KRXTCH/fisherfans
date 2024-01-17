<?php

namespace App\Controller;

use App\Repository\BoatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BoatController extends AbstractController {

    #[Route('/boats/localize', name: 'boats_localize', methods: ['GET'])]
    #[Route('/boats/localize', name: 'boats_localize', methods: ['GET'])]
    public function localizeBoats(BoatRepository $repo, Request $req): JsonResponse {
        $latitudeMin = $req->get('latitudeMin');
        $latitudeMax = $req->get('latitudeMax');
        $longitudeMin = $req->get('longitudeMin');
        $longitudeMax = $req->get('longitudeMax');
    
        if (!is_numeric($latitudeMin) || !is_numeric($latitudeMax) || !is_numeric($longitudeMin) || !is_numeric($longitudeMax)) {
            return new JsonResponse(['error' => 'Paramètres de latitude ou de longitude non valides.'], 400);
        }
        try {
            $boats = $repo->findByBoundingBox($latitudeMin, $latitudeMax, $longitudeMin, $longitudeMax);
    
            $data = [];
            foreach ($boats as $boat) {
                $data[] = [
                    'id' => $boat->getId(),
                    'nom' => $boat->getName(),
                    'latitude' => $boat->getLatitude(),
                    'longitude' => $boat->getLongitude(),
                ];
            }
    
            return new JsonResponse($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Erreur lors de la récupération des bateaux.'], 500);
        }
    }
    
}