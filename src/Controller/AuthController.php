<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Repository\UserRepository;

class AuthController extends ApiController
{	
	/**
    * @Route("api/users", methods="GET")
    */
    public function index(UserRepository $userRepository)
    {
		$users = $userRepository->transformAll();

        return $this->respond($users);
    }
    
    /**
    * @Route("api/user/{id}", methods="GET")
    */
    public function getCreatedAt(UserRepository $userRepository, int $id)
    {
        $user = $userRepository->findOneById($id);

        if (!$user) {
            return $this->respondValidationError("User with this id doesn't exist!");
        }

        return $this->respondCreated($userRepository->getCreatedAt($user));
    }

	/**
    * @Route("api/user", methods="POST")
    */
    public function login(UserRepository $userRepository, Request $request)
    {
		$user = $userRepository->findOneByEmailAndPassword($request->get('email'), $request->get('password'));

        return $this->respond($user);
	}
	
	/**
    * @Route("api/users", methods="POST")
    */
    public function create(Request $request, UserRepository $userRepository, EntityManagerInterface $em)
    {
        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        if (!$request->get('email')) {
            return $this->respondValidationError('Please provide a email!');
		}
		
		if (!$request->get('password')) {
            return $this->respondValidationError('Please provide a password!');
		}
		
		$existUser = $userRepository->findOneByEmail($request->get('email'));

		if($existUser[1] == '1') {
			return $this->respondValidationError('User with this email already exist');
		}

        $user = new User();
		$user->setEmail($request->get('email'));
		$user->setPassword($request->get('password'));
		$user->setCreatedAt(new \DateTime());
        $em->persist($user);
        $em->flush();

        return $this->respondCreated($userRepository->transform($user));
	}
}