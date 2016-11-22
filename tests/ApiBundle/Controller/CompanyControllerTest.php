<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class CompanyControllerTest extends WebTestCase {
	private $token;
	private $idEvent;
	private $idLocation;
	private $idFloorMap;
	private $idCalendar;
	private $idStand1;
	private $idStand2;
	private $Company;

	private function populateDB($client) {
		$doctrine = $client->getContainer()->get('doctrine');
		$em = $doctrine->getManager();
		$conn = $em->getConnection();
		$stmt = $conn->prepare("Insert into Event
			 (id, name, startDate, endDate)
			 values (null, 'test_event', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')");
		$stmt->execute();
		$this->idEvent = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into Location
			(id, name, country, state, city, zipCode, latitude, longitude, address)
			values (null, 'test_event', 'Ecuador', 'Azuay', 'Cuenca', '010150', -2.90055, -79.00453, 'Eduardo Crespo Malo')");
		$stmt->execute();
		$this->idLocation = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into FloorMap
			 (id, name, height, width, idLocation)
			 values (null, 'test_event', 200, 300, " . $this->idLocation . ")");
		$stmt->execute();
		$this->idFloorMap = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into Calendar
 			(id, year, monthOfTheYear, dayOfTheMonth, hour, duration, durationUnit, idFloorMap, idEvent)
 			values (null, '" . date('Y') . "', " . date('m') . ", " . (date('d') + 1) . ", 10, 8, 'hour', " . $this->idFloorMap . ", " . $this->idEvent . ")");
		$stmt->execute();
		$this->idCalendar = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into Stand
			(id, name, posX, posY, height, width, timeSlot, priceSlot, timeSlotUnit, picPath, idFloorMap)
			values (null, 'test_stand_1', 10, 10, 30, 40, 1, 1500, 'day', MD5('test_stand_1'), " . $this->idFloorMap . ")");
		$stmt->execute();
		$this->idStand1 = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into Stand
			(id, name, posX, posY, height, width, timeSlot, priceSlot, timeSlotUnit, picPath, idFloorMap)
			values (null, 'test_stand_2', 10, 10, 30, 40, 1, 750, 'day', MD5('test_stand_2'), " . $this->idFloorMap . ")");
		$stmt->execute();
		$this->idStand2 = $conn->lastInsertId();
	}

	private function getCompanyInput() {
		// set company input
		$company = new \stdClass();
		$company->name = 'test_name';
		return $company;
	}

	private function getContactsInput() {
		// set contacts input
		$contact = new \stdClass();
		$contact->type = 'mobile';
		$contact->title = 'company admin';
		$contact->firstName = 'test_first_name';
		$contact->lastName = 'test_last_name';
		$contact->value = '+5491121902449';
		$contacts[] = $contact;
		$contact = new \stdClass();
		$contact->type = 'email';
		$contact->title = 'company admin';
		$contact->firstName = 'test_first_name';
		$contact->lastName = 'test_last_name';
		$contact->value = 'blasvicco@gmail.com';
		$contacts[] = $contact;
		$contact = new \stdClass();
		$contact->type = 'email';
		$contact->title = 'company marketing';
		$contact->firstName = 'test_marketing_first_name';
		$contact->lastName = 'test_marketing_last_name';
		$contact->value = 'test@marketing.net';
		$contacts[] = $contact;
		return $contacts;
	}

	private function getLogoInput($client) {
		// set logo file upload
		$fileLocator = $client->getContainer()->get('file_locator');
		$originPath = $fileLocator->locate('@ApiBundle/Resources/Uploads/logo.jpg');
		$tmpPath = $client->getContainer()->get('Kernel')->getRootDir() . '/../web/Uploads/';
		$path = $tmpPath . '/logo.jpg';
		$fs = new Filesystem();
		$fs->copy($originPath, $path, true);
		return new UploadedFile($path, 'logo.jpg', 'image/jpeg');
	}

	private function getDocumentInput($client) {
		$files = [];
		$fileLocator = $client->getContainer()->get('file_locator');
		$originPath = $fileLocator->locate('@ApiBundle/Resources/Uploads/mySelf.odt');
		$tmpPath = $client->getContainer()->get('Kernel')->getRootDir() . '/../web/Uploads/';
		$path = $tmpPath . '/mySelf.odt';
		$fs = new Filesystem();
		$fs->copy($originPath, $path, true);
		$files[] = new UploadedFile($path, 'mySelf.odt', 'application/vnd.oasis.opendocument.text');
		$originPath = $fileLocator->locate('@ApiBundle/Resources/Uploads/Resume.pdf');
		$tmpPath = $client->getContainer()->get('Kernel')->getRootDir() . '/../web/Uploads/';
		$path = $tmpPath . '/Resume.pdf';
		$fs = new Filesystem();
		$fs->copy($originPath, $path, true);
		$files[] = new UploadedFile($path, 'Resume.pdf', 'application/pdf');
		return $files;
	}

	private function cleanCompanyStuff($client) {
		$doctrine = $client->getContainer()->get('doctrine');
		$em = $doctrine->getManager();
		$conn = $em->getConnection();
		$stmt = $conn->prepare("Delete from BookedSlot where idCompany = " . $this->Company->id);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Document where idCompany = " . $this->Company->id);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Document where idCompany = " . $this->Company->id);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Contact where idCompany = " . $this->Company->id);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Company where id = " . $this->Company->id);
		$stmt->execute();
		$fs = new Filesystem();
		// remove logo files
		$logoPath = $client->getContainer()->get('Kernel')->getRootDir() . '/../web/img/logos/';
		$fs->remove($logoPath . $this->Company->logopath);
		$fs->remove($logoPath . 'thumbs_' . $this->Company->logopath);
		$logoPath = $client->getContainer()->get('Kernel')->getRootDir() . '/../web/uploads/tmp/';
		$fs->remove($logoPath . $this->Company->logopath);
		// remove docs
		$docsPath = $client->getContainer()->get('Kernel')->getRootDir() . '/../web/uploads/docs/' . $this->Company->hash;
		$fs->remove($docsPath);
	}

	private function cleanEverything($client) {
		$this->cleanCompanyStuff($client);
		$doctrine = $client->getContainer()->get('doctrine');
		$em = $doctrine->getManager();
		$conn = $em->getConnection();
		$stmt = $conn->prepare("Delete from Stand where idFloorMap = " . $this->idFloorMap);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Calendar where id = " . $this->idCalendar);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from FloorMap where id = " . $this->idFloorMap);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Location where id = " . $this->idLocation);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Event where id = " . $this->idEvent);
		$stmt->execute();
	}

	private function hitRegisterCompany($client) {
		$company = $this->getCompanyInput();
		$contacts = $this->getContactsInput();
		$crawler = $client->request('POST', '/getToken/', [
			'username' => 'blasvicco', 
			'password' => 'asd123'
		], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$response = json_decode($client->getResponse()->getContent());
		$this->token = $response->access_token;
		$crawler = $client->request('POST', '/api/registerCompany/', [
			'company' => json_encode($company), 
			'contacts' => json_encode($contacts)
		], [
			'logo' => $this->getLogoInput($client), 
			'documents' => $this->getDocumentInput($client)
		], [
			'CONTENT_TYPE' => 'multipart/form-data', 
			'HTTP_X-Requested-With' => 'XMLHttpRequest', 
			'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
		]);
	}

	function testRegisterCompany() {
		$client = static::createClient();
		$this->hitRegisterCompany($client);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$response = json_decode($client->getResponse()->getContent());
		$this->Company = $response->results->Company;
		$this->assertEquals('test_name', $this->Company->name);
		$this->assertEquals('test_marketing_first_name', $response->results->Contacts[2]->firstname);
		$this->assertEquals('Resume.pdf', $response->results->Documents[1]->filepath);
		$this->cleanCompanyStuff($client);
	}

	function testBookStand() {
		$client = static::createClient();
		$this->populateDB($client);
		$this->hitRegisterCompany($client);
		$response = json_decode($client->getResponse()->getContent());
		$this->Company = $response->results->Company;
		$crawler = $client->request('POST', '/api/bookStand/', [
			'idStand' => $this->idStand2, 
			'idCalendar' => $this->idCalendar, 
			'idCompany' => $this->Company->id
		], [], [
			'CONTENT_TYPE' => 'application/x-www-form-urlencoded', 
			'HTTP_X-Requested-With' => 'XMLHttpRequest', 
			'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
		]);
		$response = json_decode($client->getResponse()->getContent());
		$this->assertEquals($this->Company->id, $response->results->Bookedslot->idcompany->id);
		$this->cleanEverything($client);
	}
}