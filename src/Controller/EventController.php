<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use App\Entity\Participant;
use App\Form\EventType;
use App\Service\DistanceCalculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventController extends AbstractController
{
    private $distanceCalculator;

    public function __construct(DistanceCalculator $distanceCalculator)
    {
        $this->distanceCalculator = $distanceCalculator;
    }

    #[Route('/events', name: 'liste_events')]
    public function listEvents(EventRepository $repository): Response
    {
        $events = $repository->findAll();
        return $this->render('event/listEvents.html.twig', [
            'events' => $events
        ]);
    }

    #[Route('/events/create', name: 'create_event')]
    public function createEvent(EntityManagerInterface $em, Request $request): Response
    {
       $eventRepository = $em->getRepository(Event::class);
       $event = new Event();
       $form = $this->createForm(EventType::class, $event);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
        if ($event->getDate() < new \DateTime()) {
            $this->addFlash('error', 'La date de l\'événement ne peut pas être dans le passé.');
            return $this->render('event/createEvent.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    
        $em->persist($event);
        $em->flush();
        $this->addFlash('success', 'L\'événement a été ajouté avec succès.');

        return $this->redirectToRoute('liste_events'); 
    }

        return $this->render('event/createEvent.html.twig', [
            'controller_name' => 'ParticipantController',
            'form' => $form->createView(), 
        ]);
    }

    #[Route('/events/{id}', name: 'detail_event')]
    public function viewEvent(EntityManagerInterface $em, int $id): Response
    {
        $eventRepository = $em->getRepository(Event::class);
        $event = $eventRepository->findOneBy(['id' => $id]);
        $particpantRepository = $em->getRepository(Participant::class);
        $participants = $particpantRepository->findBy(['event' => $event]);

        if (!$event) {
            throw $this->createNotFoundException('Evénement pas trouvé.');
        }

        return $this->render('event/viewEvent.html.twig', [
            'event' => $event,
            'participants' => $participants 
        ]);
    }

    #[Route('/events/{id}/distance', name: 'calculate_distance_to_event', methods: ['GET', 'POST'])]
    public function calculateDistanceToEvent($id, Request $request, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Evenement pas trouvé.');
        }

        if ($request->isMethod('POST')) {
            $lat = $request->request->get('lat');
            $lon = $request->request->get('lon');

            if (!$lat || !$lon) {
                $this->addFlash('error', 'Latitude and Longitude are required.');
                return $this->redirectToRoute('calculate_distance_to_event', ['id' => $id]);
            }

            $eventLat = (float) $event->getLocationX();
            $eventLon = (float) $event->getLocationY();

            $distance = $this->distanceCalculator->calculateDistance((float)$lat, (float)$lon, $eventLat, $eventLon);

            return $this->render('distance/result.html.twig', [
                'event' => $event,
                'userLat' => $lat,
                'userLon' => $lon,
                'distance' => $distance
            ]);
        }

        return $this->render('distance/input.html.twig', [
            'event' => $event
        ]);
    }
}

