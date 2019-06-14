<?php

namespace App\Controller\Api\V1;

use App\Repository\CountryRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api/v1")
 */
class CountryController extends AbstractFOSRestController
{
    private $countryRepository;

    public function __construct(
        CountryRepository $countryRepository
    ) {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @Rest\Get("/countries")
     */
    public function getCountries()
    {
        $countries = $this->countryRepository->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);

        return JsonResponse::fromJsonString($serializer->serialize($countries, 'json'));
    }

    /**
     * @Rest\Get("/countries/{id}")
     */
    public function getCountry(int $id)
    {
        $country = $this->countryRepository->find($id);

        if (!$country) {
            throw new EntityNotFoundException("The country with id {$id} does not exist.");
        }

        return $this->view($country);
    }
}
