<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Form\AddListingType;
use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;



#[Route('/listing')]
class ListingController extends AbstractController
{

    private $translator;

    #[Route('/', name: 'app_listing')]
    public function index(ListingRepository $listingRepository): array
    {

        return $listingRepository->findAll('listing/index.html.twig', [
            'controller_name' => 'ListingController',
        ]);

    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request, ListingRepository $listingRepository): Response
    {
        $listing = new Listing();
        $form = $this->createForm(AddListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listingRepository->save($listing, true);

            return $this->redirectToRoute('app_listing', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listing/index.html.twig', [
            'listing' => $listing,
            'form' => $form,
        ]);
    }
}


