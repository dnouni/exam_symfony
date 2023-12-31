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



#[Route('/listing', name: 'app_listing_')]
class ListingController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(ListingRepository $listingRepository): Response
    {
        return $this->render('listing/index.html.twig', [
            'listing' => $listingRepository->findAll(),
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

        return $this->renderForm('listing/_form.html.twig', [
            'listing' => $listing,
            'form' => $form,
        ]);
    }
}


