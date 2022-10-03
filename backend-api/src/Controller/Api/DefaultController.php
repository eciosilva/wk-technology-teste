<?php

namespace App\Controller\Api;

use App\Entity\City;
use App\Entity\State;
use App\Repository\CityRepository;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/ufs", name="cget_ufs", methods={"GET"})
     */
    public function cgetUfs(EntityManagerInterface $em): JsonResponse
    {
        /** @var StateRepository */
        $ufRepository = $em->getRepository(State::class);
        $ufs = $ufRepository->fetchAllOrderedByName();

        return $this->json($ufs);
    }

    /**
     * @Route("/cities/{uf}", name="cget_cities_by_uf", methods={"GET"})
     */
    public function cgetCitiesByUf(State $uf, EntityManagerInterface $em): JsonResponse
    {
        /** @var CityRepository */
        $cityRepository = $em->getRepository(City::class);
        $cities = $cityRepository->fetchCitiesByUf($uf);

        return $this->json($cities);
    }
}