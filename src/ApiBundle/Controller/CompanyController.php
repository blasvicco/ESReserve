<?php
// src/ApiBundle/Controller/CompanyController.php
namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\GET;
use FOS\RestBundle\Controller\Annotations\POST;
use ApiBundle\Entity\Company;
use ApiBundle\Entity\Contact;
use ApiBundle\Entity\Document;
use ApiBundle\Entity\Bookedslot;

class CompanyController extends FOSRestController {

	private function uploadLogo(Request $request) {
		$uploadedFile = $request->files->get('logo');
		$tmpFolderPathAbs = $this->get('kernel')->getRootDir() . '/../web/uploads/tmp/';
		$tmpImageName = rand() . $uploadedFile->getClientOriginalName();
		$uploadedFile->move($tmpFolderPathAbs, $tmpImageName);
		$tmpImagePathRel = 'uploads/tmp/' . $tmpImageName;
		// Create the filtered image:
		try {
			$dataManager = $this->container->get('liip_imagine.data.manager');
			$filterManager = $this->container->get('liip_imagine.filter.manager');
			$processedImage = $dataManager->find('logo_filter', $tmpImagePathRel);
			$filteredImage = $filterManager->applyFilter($processedImage, 'logo_filter')->getContent();
			$permanentImagePath = $this->get('kernel')->getRootDir() . '/../web/img/logos/' . $tmpImageName;
			$f = fopen($permanentImagePath, 'w');
			fwrite($f, $filteredImage);
			fclose($f);
			$processedImage = $dataManager->find('thumbs_filter', $tmpImagePathRel);
			$filteredImage = $filterManager->applyFilter($processedImage, 'thumbs_filter')->getContent();
			$permanentImagePath = $this->get('kernel')->getRootDir() . '/../web/img/logos/thumbs_' . $tmpImageName;
			$f = fopen($permanentImagePath, 'w');
			fwrite($f, $filteredImage);
			fclose($f);
			return $tmpImageName;
		} catch (\Exception $e) {
			return ''; // if we can not process the image we will continue with the company registration
		}
	}

	private function saveCompany(Request $request) {
		$logoFileName = $this->uploadLogo($request);
		if ($Company = Company::fromJsonValue($request->get('company'))) {
			$Company->setLogopath($logoFileName);
			$em = $this->getDoctrine()->getManager();
			$em->persist($Company);
			$em->flush();
			return $Company;
		}
		return false;
	}

	private function saveContact(Request $request, Company $Company) {
		if ($Contacts = Contact::fromJsonValueOfCollection($request->get('contacts'))) {
			foreach ($Contacts as $Contact) {
				$Contact->setIdcompany($Company);
				$em = $this->getDoctrine()->getManager();
				$em->persist($Contact);
				$em->flush();
			}
			return $Contacts;
		}
		return false;
	}

	private function saveDocument(Request $request, Company $Company) {
		$folderPathAbs = $this->get('kernel')->getRootDir() . '/../web/uploads/docs/' . $Company->getHash() . '/';
		$fs = new Filesystem();
		$fs->mkdir($folderPathAbs);
		$uploadedFile = $request->files->get('documents');
		$Documents = [];
		try {
			foreach ($uploadedFile as $file) {
				$Document = new Document();
				$Document->setIdcompany($Company);
				$Document->setType('marketing');
				$Document->setFilepath($file->getClientOriginalName());
				$file->move($folderPathAbs, $file->getClientOriginalName());
				$em = $this->getDoctrine()->getManager();
				$em->persist($Document);
				$em->flush();
				$Documents[] = $Document;
			}
		} catch (\Exception $e) {
			return ''; // if we can not process the image we will continue with the company registration
		}
		return $Documents;
	}

	/**
	 * @Post("/api/registerCompany/")
	 */
	function registerCompany(Request $request) {
		$view = $this->view([]);
		$results = [];
		try {
			if ($results['Company'] = $this->saveCompany($request)) {
				$results['Contacts'] = $this->saveContact($request, $results['Company']);
				$results['Documents'] = $this->saveDocument($request, $results['Company']);
				$view = $this->view([
					'results' => $results
				]);
			}
		} catch (\Exception $e) {
			$view = $this->view([
				'error' => $e->getCode(), 
				'error_description' => $e->getMessage()
			]);
		}
		return $this->handleView($view);
	}

	/**
	 * @Post("/api/bookStand/")
	 */
	function bookStand(Request $request) {
		$repository = $this->getDoctrine()->getRepository('ApiBundle:Bookedslotpro');
		list($Stand, $Calendar, $Bookedslot) = $repository->findByStandAndCalendar($request->get('idStand'), $request->get('idCalendar'));
		if (empty($Bookedslot)) {
			$repository = $this->getDoctrine()->getRepository('ApiBundle:Company');
			$Company = $repository->findOneById($request->get('idCompany'));
			$fromTime = $Calendar->getYear() . '-' . $Calendar->getMonthoftheyear() . '-' . $Calendar->getDayofthemonth() . ' ' . $Calendar->getHour() . ':00:00';
			$toTime = $Calendar->getYear() . '-' . $Calendar->getMonthoftheyear() . '-' . ($Calendar->getDayofthemonth() + 1) . ' ' . $Calendar->getHour() . ':00:00';
			$Bookedslot = new Bookedslot();
			$Bookedslot->setFromtime(\DateTime::createFromFormat('Y-m-d H:i:s', $fromTime));
			$Bookedslot->setTotime(\DateTime::createFromFormat('Y-m-d H:i:s', $toTime));
			$Bookedslot->setPrice($Stand->getPriceslot());
			$Bookedslot->setIdstand($Stand);
			$Bookedslot->setIdcompany($Company);
			$em = $this->getDoctrine()->getManager();
			$em->persist($Bookedslot);
			$em->flush();
			$results['Bookedslot'] = $Bookedslot;
			$view = $this->view([
				'results' => $results
			]);
		} else {
			$view = $this->view([
				'error' => 'stand_already_booked', 
				'error_description' => 'Sorry, this stand was already taken.'
			]);
		}
		return $this->handleView($view);
	}

}