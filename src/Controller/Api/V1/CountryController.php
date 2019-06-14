<?php

namespace App\Controller\Api\V1;

use App\Repository\CountryRepository;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

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

        return $this->view($countries);
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
