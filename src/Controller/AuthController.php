<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;

class AuthController extends AbstractController
{
    public function register(Request $request)
    {
    	$data = $request->request->all();

    	$email = '';
    	$errors = [];

    	if ($data) {
    		$email = $data['email'];
    		$password = $data['password'];

    		if ($email == '') {
    			$errors[] = "The email field must be filled";
    		}

    		if (strlen($password) < 6) {
    			$errors[] = "The password field must be bigger than 5 symbols";
    		}

    		if(!$errors) {
    			$entityManager = $this->getDoctrine()->getManager();

    			$user = new User();
		        $user->setEmail($email);
		        $user->setPassword($password);

		        $entityManager->persist($user);

		        $entityManager->flush();
    		}
    	}

        return $this->render('register.html.twig', [
        	'email' => $email,
        	'errors' => $errors
        ]);
    }

    public function login(Request $request) 
    {
    	$data = $request->request->all();

    	$email = '';
    	$errors = [];

    	if ($data) {
    		$email = $data['email'];
    		$password = $data['password'];

    		if ($email == '') {
    			$errors[] = "The email field must be filled";
    		}

    		if (strlen($password) < 6) {
    			$errors[] = "The password field must be bigger than 5 symbols";
    		}

    		if(!$errors) {
    			$repository = $this->getDoctrine()
    			                   ->getManager()
    			                   ->getRepository(User::class);

    			$user = $repository->findOneBy(
    				[
    					'email' => $email, 
    					'password' => $password
    				], array('email' => 'ASC'), 1 , 0);

    			if ($user) {
    				return $this->redirectToRoute('index');
    			} else {
    				$errors[] = "Invalid user data";
    			}
    		}
    	}

    	return $this->render('login.html.twig', [
        	'email' => $email,
        	'errors' => $errors
        ]);
    }
}