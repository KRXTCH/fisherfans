<?php

namespace App\Controller;

use App\Repository\BoatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BoatController extends AbstractController {

    #[Route('/boats/localize', name: 'boats_localize', methods: ['GET'])]
    public function localizeBoats(BoatRepository $repo, Request $req): JsonResponse {
        $boats = $repo->findByBoundingBox($req->get('latitudeMin'), $req->get('latitudeMax'), $req->get('longitudeMin'), $req->get('longitudeMax'));

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
    }
}