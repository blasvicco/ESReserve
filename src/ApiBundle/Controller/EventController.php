<?php
// src/ApiBundle/Controller/EventController.php
namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use \Doctrine\Common\Collections\Criteria;

class EventController extends FOSRestController {

	private function getEventsInRadius($latitude, $longitude, $radius) {
		if (empty($latitude) || empty($longitude) || empty($radius)) {return [];}
		$sign = $latitude < 0 ? 1 : -1;
		$minlat = $latitude - ($sign * $radius);
		$maxlat = $latitude + ($sign * $radius);
		$minlong = $longitude - ($sign * $radius);
		$maxlong = $longitude + ($sign * $radius);
		$repository = $this->getDoctrine()->getRepository('ApiBundle:Calendar');
		$qb = $repository->createQueryBuilder('c');
		$query = $qb->select('c')->join('c.idevent', 'e')->join('c.idfloormap', 'f')->join('f.idlocation', 'l')->where("STR_TO_DATE(CONCAT(c.year, '-', c.monthoftheyear, '-', c.dayofthemonth), '%Y-%m-%d') > :today")->andWhere('l.latitude > :minlat')->andWhere('l.latitude < :maxlat')->andWhere('l.longitude > :minlong')->andWhere('l.longitude < :maxlong')->setParameter('today', date('Y-m-d'))->setParameter('minlat', $minlat)->setParameter('maxlat', $maxlat)->setParameter('minlong', $minlong)->setParameter('maxlong', $maxlong)->getQuery();
		return $query->getResult();
	}

	/**
	 * @Get("/api/loadEvents/")
	 */
	function loadEvents(Request $request) {
		$results = $this->getEventsInRadius($request->get('latitude'), $request->get('longitude'), $request->get('radius'));
		if (empty($results)) {
			$view = $this->view([
				'warning' => 'no_events_found',
				'warning_description' => 'There is no event around to show.'
			]);
		} else {
			$view = $this->view([
				'results' => $results
			]);
		}
		return $this->handleView($view);
	}

	/**
	 * @Get("/api/getStands/")
	 */
	function getStands(Request $request) {
		$repository = $this->getDoctrine()->getRepository('ApiBundle:Stand');
		$Stands = $repository->findBy([
			'idfloormap' => $request->get('id')
		]);
		if (empty($Stands)) {
			$view = $this->view([
				'warning' => 'no_stands_found',
				'warning_description' => 'There is no stand defined for this floor.'
			]);
		} else {
			$results['Stands'] = $Stands;
			$view = $this->view([
				'results' => $results
			]);
		}
		return $this->handleView($view);
	}

	/**
	 * @Get("/api/getStandDetail/")
	 */
	function getStandDetail(Request $request) {
		$repository = $this->getDoctrine()->getRepository('ApiBundle:Bookedslotpro');
		list($Stand, $Calendar, $Bookedslot) = $repository->findByStandAndCalendar($request->get('id'), $request->get('idCalendar'));
		if (empty($Stand)) {
			$view = $this->view([
				'error' => 'no_stand_found',
				'error_description' => 'There is no stand with this id: '.$request->get('id')
			]);
		} else {
			if (!empty($Bookedslot)) {
				$results['Bookedslot'] = $Bookedslot;
				$repository = $this->getDoctrine()->getRepository('ApiBundle:Contact');
				$results['Contacts'] = $repository->findBy([
					'idcompany' => $Bookedslot->getIdCompany()->getId()
				]);
				$repository = $this->getDoctrine()->getRepository('ApiBundle:Document');
				$results['Documents'] = $repository->findBy([
					'idcompany' => $Bookedslot->getIdCompany()->getId()
				]);
			} else {
				$results['Bookedslot'] = 'available';
			}
			$view = $this->view([
				'results' => $results
			]);
		}
		return $this->handleView($view);
	}
}