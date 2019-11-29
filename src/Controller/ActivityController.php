<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Activity;
use App\Repository\ActivityRepository;

class ActivityController extends ApiController
{		
	/**
    * @Route("api/activity", methods="POST")
    */
    public function create(Request $request, ActivityRepository $activityRepository, EntityManagerInterface $em)
    {
        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        if (!$request->get('user_id')) {
            return $this->respondValidationError('Please provide a user_id!');
		}

        $activity = new Activity();
		$activity->setUserId($request->get('user_id'));
		$activity->setDate(new \DateTime());
        $em->persist($activity);
        $em->flush();

        return $this->respondCreated($activityRepository->transform($activity));
    }
    
    /**
    * @Route("api/activity/{id}/{date}", methods="GET")
    */
    public function getUserActivity(ActivityRepository $activityRepository, int $id, string $date)
    {
        $activity = $activityRepository->getUserActivityAtDate($id, $date);

        return $this->respond($activity);
	}
}