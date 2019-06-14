<?php

namespace App\Controller\Api\V1;

use App\Repository\SchoolRepository;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @Route("/api/v1")
 */
class SchoolController extends AbstractFOSRestController
{
    private $schoolRepository;
    
    public function __construct(
        SchoolRepository $schoolRepository
    ) {
        $this->schoolRepository = $schoolRepository;
    }

    /**
     * @Rest\Get("/schools")
     */
    public function getSchools()
    {
        $schools = $this->schoolRepository->findAll();

        return $this->view($schools);
    }

    /**
     * @Rest\Get("/schools/{id}")
     */
    public function getSchool(int $id)
    {
        $school = $this->schoolRepository->find($id);

        if (!$school) {
            throw new EntityNotFoundException("The school with id {$id} does not exist.");
        }

        return $this->view($school);
    }
}
