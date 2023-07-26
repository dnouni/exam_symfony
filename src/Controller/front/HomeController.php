<?php


namespace App\Controller\Front;


use App\Entity\UserTest;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Repository\ListingRepository;
use App\Repository\ReviewRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.php
 *
 * @author Kevin Tourret
 */
class HomeController extends AbstractController
{

    public function __construct(
      private ListingRepository $listingRepository,
    ) { }

    #[Route('/', name: 'app_home')]
    public function home(): Response {

        $lastMonthDate = new DateTime();
        $lastMonthDate->modify('-1 month');

//        dd($this->categoryRepository->getMostSoldCategories());

        return $this->render('home.html.twig', [
            'tendances' => $this->listingRepository->findTendances(9, true, $lastMonthDate),
            'lastGames' => $this->listingRepository->findBy([], ['publishedAt' => 'DESC'], 9),
            'bestSellers' => $this->listingRepository->findTendances(9),
        ]);
    }

}
