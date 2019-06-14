<?php

namespace App\Controller\Api\V1;

use App\Repository\ProgramRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @Route("/api/v1")
 */
class ProgramController extends AbstractFOSRestController
{
    private $programRepository;

    public function __construct(
        ProgramRepository $programRepository
    ) {
        $this->programRepository = $programRepository;
    }

    /**
     * @Rest\Get("/programs")
     */
    public function getPrograms()
    {
        $programs = $this->programRepository->findAll();

        return $this->view($programs);
    }

    /**
     * @Rest\Get("/programs/{id}")
     */
    public function getProgram(int $id)
    {
        $program = $this->programRepository->find($id);

        if (!$program) {
            throw new EntityNotFoundException("The program with id {$id} does not exist.");
        }

        return $this->view($program);
    }
}
