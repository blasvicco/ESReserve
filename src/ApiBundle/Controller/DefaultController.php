<?php
// src/ApiBundle/Controller/DefaultController.php
namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;

class DefaultController extends FOSRestController {

	private function getUserByUsername($username) {
		$userManager = $this->get('fos_user.user_manager');
		return $userManager->findUserByUsername($username);
	}

	private function identify(Request $request) {
		$username = $request->get('username');
		$password = $request->get('password');
		$user = $this->getUserByUsername($username);
		if (!empty($user)) {
			$factory = $this->get('security.encoder_factory');
			$encoder = $factory->getEncoder($user);
			$salt = $user->getSalt();
			return ($encoder->isPasswordValid($user->getPassword(), $password, $salt)) ? $user : false;
		}
		return false;
	}

	private function getAuthToken(Request $request) {
		$username = $request->get('username');
		$password = $request->get('password');
		$repository = $this->getDoctrine()->getRepository('ApiBundle:Client');
		$client = $repository->findOneById(1);
		$client_id = '1_' . $client->getRandomId();
		$request->request->add([
			'grant_type' => 'password', 
			'client_id' => $client_id, 
			'client_secret' => $client->getSecret(), 
			'username' => $username, 
			'password' => $password
		]);
		$response = $this->get('fos_oauth_server.controller.token')->tokenAction($request);
		$content = json_decode($response->getContent());
		return (array) $content;
	}

	/**
	 * @Post("/getToken/")
	 */
	public function getToken(Request $request) {
		$view = $this->view([
			'error' => 'invalid_request', 
			'error_description' => 'Not valid request.'
		]);
		if ($request->isXmlHttpRequest()) {
			$user = $this->identify($request);
			if ($user) {
				$content = $this->getAuthToken($request);
				$view = $this->view($content);
			} else {
				$view = $this->view([
					'error' => 'user_not_found', 
					'error_description' => 'No user found.'
				]);
			}
		}
		return $this->handleView($view);
	}

	/**
	 * @Get("/api/hello/")
	 */
	public function getHelloAction() {
		$user = $this->get('security.context')->getToken()->getUser();
		if ($user) {
			$view = $this->view([
				'username' => $user->getUserName()
			]);
		} else {
			$view = $this->view([
				'error' => 'no_user_identified', 
				'error_description' => 'No user is identified'
			]);
		}
		return $this->handleView($view);
	}
}
