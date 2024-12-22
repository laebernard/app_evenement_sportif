<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(EntityManagerInterface $em): Response
    {
        $eventRepository = $em->getRepository(Event::class);
        $events = $eventRepository->findUpcomingEvents();
        return $this->render('accueil/index.html.twig', [
            'events' => $events
        ]);
    }
}
