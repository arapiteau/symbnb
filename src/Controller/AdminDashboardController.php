<?php

namespace App\Controller;

use App\Service\StatsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(EntityManagerInterface $manager, StatsService $statsService)
    {
        $stats = $statsService->getStats();
        $bestAds = $statsService->getStatsAds('DESC');
        $worstAds = $statsService->getStatsAds('ASC');

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('users', 'ads', 'bookings', 'comments'),
            'bestAds' => $bestAds,
            'worstAds' => $worstAds
        ]);
    }
}
