<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class NoteController extends AbstractFOSRestController
{
    /**
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * @var EntityManagerInterface
     */
    Private $entityManager;

    public function __construct(NoteRepository $noteRepository, EntityManagerInterface $entityManager) {
        $this->noteRepository = $noteRepository;
        $this->entityManager = $entityManager;
    }

    public function getNoteAction(Note $note){
        return $this->view($note, Response::HTTP_OK);
    }

    public function deleteNoteAction(int $id){
        $note = $this->noteRepository->findOneBy(['id' => $id]);

        if ($note) {
            $this->entityManager->remove($note);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }
        return $this->view(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
