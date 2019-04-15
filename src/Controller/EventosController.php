<?php

namespace App\Controller;

use App\Entity\Eventos;
use App\Form\EventosType;
use App\Repository\EventosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventosController extends AbstractController
{
    /**
     * @var EventosRepository
     */
    private $eventosRepository;

    public function __construct(EventosRepository $eventosRepository)
    {
        $this->eventosRepository = $eventosRepository;
    }

    /**
     * @Route("/eventos", name="eventos", methods={"GET", "POST"})
     * @param Request $request
     */
    public function index(Request $request)
    {
        $eventos = new Eventos();
        $form = $this->createForm(EventosType::class, $eventos);
        $form->handleRequest($request);
        dump($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump("entrou aqui");
            $this->eventosRepository->persist($eventos);
            dump("persistiu");
            return new Response("Evento criado");
        }else {
            return $this->render('eventos/index.html.twig', [
                "form" => $form->createView()
            ]);
        }
    }
}
