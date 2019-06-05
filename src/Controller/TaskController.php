<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as Rest;


class TaskController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->taskRepository = $taskRepository;
    }

    public function getTaskActions(Task $task){
        return $this->view($task, Response::HTTP_OK);
    }

    public function getTaskNotesAction(int $id){

        $task = $this->taskRepository->findOneBy(['id' => $id]);

        if ($task) {
            return $this->view($task->getNotes(), Response::HTTP_OK);
        }

        return $this->view(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    /**
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function removeListTaskAction(int $id){

        $task = $this->taskRepository->FindOneBy(['id' => $id]);

        if ($task) {

            $this->entityManager->remove($task);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Rest\RequestParam(name="note", description="Note for the task", nullable=false)
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function statusTaskAction(int $id){

        $task = $this->taskRepository->FindOneBy(['id' => $id]);

        if ($task) {

            $task->setIsComplete(!$task->getIsComplete());
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return $this->view($task->getIsComplete(), Response::HTTP_NO_CONTENT);
        }

        return $this->view(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Rest\RequestParam(name="note", description="Note for the task", nullable=false)
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function postTaskNoteAction(ParamFetcher $paramFetcher, Task $task, int $id){

        $noteString = $paramFetcher->get('note');
        $task = $this->taskRepository->findOneBy(['id' => $id]);

        if ($noteString) {
            if ($task) {
                $note = new Note();

                $note->setNote($noteString);
                $note->setTask($task);

                $task->addNote($note);

                $this->entityManager->persist($note);
                $this->entityManager->flush();

                return $this->view($note, Response::HTTP_OK);
            }
        }
            return $this->view(['message' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
