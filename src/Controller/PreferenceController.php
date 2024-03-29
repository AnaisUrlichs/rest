<?php

namespace App\Controller;

use App\Entity\TaskList;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;


class PreferenceController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @Route("/preference", name="preference")
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPreferencesAction(TaskList $list)
    {
        $list->getPreferences();
        return $this->view($list, Response::HTTP_OK);
    }

    /**
     * @Rest\RequestParam(name="sortValue", description="The value will be used to sort the list", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param TaskList $list
     * @return \FOS\RestBundle\View\View
     */
    public function sortPreferenceAction(ParamFetcher $paramFetcher, TaskList $list) {
        $sortValue = $paramFetcher->get('sortValue');
        if ($sortValue) {
            $list->getPreferences()->setSortValue($sortValue);
            $this->entityManager->persist($list);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        $data['code'] = Response::HTTP_CONFLICT;
        $data['message'] = 'The sortValue cannot be null';

        return $this->view($data, Response::HTTP_CONFLICT);
    }

    /**
     * @Rest\RequestParam(name="filterValue", description="The filter value", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param TaskList $list
     * @return \FOS\RestBundle\View\View
     */

    public function filterPreferenceAction(ParamFetcher $paramFetcher, TaskList $list){
        $filterValue = $paramFetcher->get('filterValue');
        if ($filterValue){
            $list->getPreferences()->setFilterValue($filterValue);
            $this->entityManager->persist($list);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        $data['code'] = Response::HTTP_CONFLICT;
        $data['message'] = 'The filterValue cannot be null';

        return $this->view($data, Response::HTTP_CONFLICT);
    }
}
