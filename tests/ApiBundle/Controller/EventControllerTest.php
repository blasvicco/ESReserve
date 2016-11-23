<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase {
	private $idEvent;
	private $idLocation;
	private $idFloorMap;
	private $idCalendar;
	private $idStand1;
	private $idStand2;
	private $idCompany;
	private $idDocument1;
	private $idDocument2;
	private $idContact1;
	private $idContact2;

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
		$stmt = $conn->prepare("Insert into Company
			(id, name, logoPath, hash)
 			values (null, 'test_company', 'logo.jpg', MD5('test_company'))");
		$stmt->execute();
		$this->idCompany = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into Document
			 (id, type, filePath, idCompany)
			 values (null, 'marketing', 'Resume.pdf', " . $this->idCompany . ")");
		$stmt->execute();
		$this->idDocument1 = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into Document
			 (id, type, filePath, idCompany)
			 values (null, 'marketing', 'mySelf.odt', " . $this->idCompany . ")");
		$stmt->execute();
		$this->idDocument2 = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into Contact
			(id, type, title, firstName, lastName, value, idCompany)
			values (null, 'email', 'company admin', 'Blas', 'Vicco', 'blasvicco@gmail.com', " . $this->idCompany . ")");
		$stmt->execute();
		$this->idContact1 = $conn->lastInsertId();
		$stmt = $conn->prepare("Insert into Contact
			(id, type, title, firstName, lastName, value, idCompany)
			values (null, 'email', 'marketing', 'Test', '', 'test@marketing.com', " . $this->idCompany . ")");
		$stmt->execute();
		$this->idContact2 = $conn->lastInsertId();
		$fromTime = date('Y') . '-' . date('m') . '-' . (date('d') + 1) . ' 8:00:00';
		$toTime = date('Y') . '-' . date('m') . '-' . (date('d') + 2) . ' 8:00:00';
		$stmt = $conn->prepare("Insert into BookedSlot
			(id, fromTime, toTime, price, idCompany, idStand)
			values (null, '" . $fromTime . "', '" . $toTime . "', 750, " . $this->idCompany . ", " . $this->idStand2 . ")");
		$stmt->execute();
		$this->idBookedslot = $conn->lastInsertId();
	}

	private function cleanDB($client) {
		$doctrine = $client->getContainer()->get('doctrine');
		$em = $doctrine->getManager();
		$conn = $em->getConnection();
		$stmt = $conn->prepare("Delete from BookedSlot where idCompany = " . $this->idCompany);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Contact where idCompany = " . $this->idCompany);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Document where idCompany = " . $this->idCompany);
		$stmt->execute();
		$stmt = $conn->prepare("Delete from Company where id = " . $this->idCompany);
		$stmt->execute();
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

	function testLoadEvents() {
		$client = static::createClient();
		$this->populateDB($client);
		$crawler = $client->request('POST', '/getToken/', [
			'username' => 'test', 
			'password' => 'asd123'
		]);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$response = json_decode($client->getResponse()->getContent());
		$crawler = $client->request('GET', '/api/loadEvents/', [
			'latitude' => -2.90055, 
			'longitude' => -79.004532, 
			'radius' => 0.000001
		], [], [
			'CONTENT_TYPE' => 'application/json', 
			'HTTP_X-Requested-With' => 'XMLHttpRequest', 
			'HTTP_AUTHORIZATION' => 'Bearer ' . $response->access_token
		]);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$response = json_decode($client->getResponse()->getContent());
		$this->assertEquals('test_event', $response->results[0]->idevent->name);
		$this->cleanDB($client);
	}

	function testGetStands() {
		$client = static::createClient();
		$this->populateDB($client);
		$crawler = $client->request('POST', '/getToken/', [
			'username' => 'test', 
			'password' => 'asd123'
		]);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$response = json_decode($client->getResponse()->getContent());
		$crawler = $client->request('GET', '/api/getStands/', [
			'id' => $this->idFloorMap
		], [], [
			'CONTENT_TYPE' => 'application/json', 
			'HTTP_X-Requested-With' => 'XMLHttpRequest', 
			'HTTP_AUTHORIZATION' => 'Bearer ' . $response->access_token
		]);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$response = json_decode($client->getResponse()->getContent());
		$this->assertEquals($this->idFloorMap, $response->results->Stands[0]->idfloormap->id);
		$this->cleanDB($client);
	}

	function testGetStandDetail() {
		$client = static::createClient();
		$this->populateDB($client);
		$crawler = $client->request('POST', '/getToken/', [
			'username' => 'test', 
			'password' => 'asd123'
		]);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$response = json_decode($client->getResponse()->getContent());
		$crawler = $client->request('GET', '/api/getStandDetail/', [
			'id' => $this->idStand2
		], [], [
			'CONTENT_TYPE' => 'application/json', 
			'HTTP_X-Requested-With' => 'XMLHttpRequest', 
			'HTTP_AUTHORIZATION' => 'Bearer ' . $response->access_token
		]);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$response = json_decode($client->getResponse()->getContent());
		$this->assertEquals($this->idCompany, $response->results->Bookedslot->idcompany->id);
		$this->assertEquals($this->idCompany, $response->results->Contacts[1]->idcompany->id);
		$this->assertEquals($this->idCompany, $response->results->Documents[1]->idcompany->id);
		$this->cleanDB($client);
	}
}
