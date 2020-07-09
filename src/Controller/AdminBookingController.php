<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Service\PaginationService;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings/{page<\d+>?1}", name="admin_bookings_index")
     */
    public function index(BookingRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Booking::class)
                    ->setCurrentPage($page);

        return $this->render('admin/booking/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition d'une réservation niveau administration
     * 
     * @Route("/admin/bookings/{id}/edit", name="admin_bookings_edit")
     *
     * @return void
     */
    public function edit(Booking $booking, Request $request, EntityManagerInterface $manager) {
        $form = $this->createForm(AdminBookingType::class, $booking);

        $form->handleRequest($request);
        dump($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setAmount(0);

            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                'success',
                "La réservation n°{$booking->getId()} a bien été modifiée !"
            );

            return $this->redirectToRoute("admin_bookings_index");
        }

        return $this->render('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     *
     * @Route("/admin/bookings/{id}/delete", name="admin_bookings_delete")
     * 
     * @return Response
     */
    public function delete(Booking $booking, EntityManagerInterface $manager) {
        $id = $booking->getId();
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            "La réservation n°{$id} a bien été supprimée !"
        );

        return $this->redirectToRoute('admin_bookings_index');
    }
}
