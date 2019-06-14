<?php

namespace App\Controller\Api\V1;

use App\Repository\DeanRepository;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @Route("/api/v1")
 */
class DeanController extends AbstractFOSRestController
{
    private $deanRepository;
    
    public function __construct(
        DeanRepository $deanRepository
    ) {
        $this->deanRepository = $deanRepository;
    }

    /**
     * @Rest\Get("/deans")
     */
    public function getDeans()
    {
        $deans = $this->deanRepository->findAll();

        return $this->view($deans);
    }

    /**
     * @Rest\Get("/deans/{id}")
     */
    public function getDean(int $id)
    {
        $dean = $this->deanRepository->find($id);

        if (!$dean) {
            throw new EntityNotFoundException("The dean with id {$id} does not exist.");
        }

        return $this->view($dean);
    }
}
