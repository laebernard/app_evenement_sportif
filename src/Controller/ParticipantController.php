<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use App\Entity\Participant;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParticipantController extends AbstractController
{
    #[Route('/participants', name: 'liste_participants')]
    public function index(EntityManagerInterface $em): Response
    {
        $participantRepository = $em->getRepository(Participant::class);
        $participants = $participantRepository->findDistinctParticipants();
        return $this->render('participant/index.html.twig', [
            'participants' => $participants
        ]);
    }

    #[Route('/events/{eventId}/participants/new', name: 'add_participant')]
    public function addParticipant(EntityManagerInterface $em, Request $request, int $eventId): Response
    {
        $eventRepository = $em->getRepository(Event::class);
        $event = $eventRepository->find($eventId);
    
        if (!$event) {
            throw $this->createNotFoundException('L\'événement spécifié est introuvable.');
        }
    
        $participantRepository = $em->getRepository(Participant::class);
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $existingParticipant = $participantRepository->findOneBy([
                'email' => $participant->getEmail(),
                'event' => $event,
            ]);
    
            if ($existingParticipant) {
                $this->addFlash('error', 'Ce participant est déjà inscrit à cet événement.');
            } else {
                $participant->setEvent($event);
                $em->persist($participant);
                $em->flush();
    
                $this->addFlash('success', 'Le participant a été ajouté avec succès.');
                return $this->redirectToRoute('liste_events');
            }
        }
    
        return $this->render('participant/addParticipantEvent.html.twig', [
            'controller_name' => 'ParticipantController',
            'form' => $form->createView(),
        ]);
    }
    
}
