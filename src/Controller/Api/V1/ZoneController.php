<?php

namespace App\Controller\Api\V1;

use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Util\SerializeUtil;

/**
 * @Route("/api/v1")
 */
class ZoneController extends AbstractFOSRestController
{
    private $zoneRepository;

    private $serializeUtil;
    
    public function __construct(
        ZoneRepository $zoneRepository,
        SerializeUtil $serializeUtil
    ) {
        $this->zoneRepository = $zoneRepository;
        $this->serializeUtil = $serializeUtil;
    }

    /**
     * @Rest\Get("/zones")
     */
    public function getZones()
    {
        $zones = $this->zoneRepository->findAll();

        return $this->view($zones);
    }

    /**
     * @Rest\Get("/zones/{id}")
     */
    public function getZone(int $id)
    {
        $zone = $this->zoneRepository->find($id);

        if (!$zone) {
            throw new EntityNotFoundException("The zone with id {$id} does not exist.");
        }

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);

        dd($serializer->serialize($zone, 'json'));

        return $this->view($zone);
    }
}
