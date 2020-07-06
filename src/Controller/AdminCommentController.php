<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * Affiche un tableau contenant tous les commentaires postés avec boutons édition et suppression
     * 
     * @Route("/admin/comments", name="admin_comments_index")
     * 
     * @return Response
     */
    public function index(CommentRepository $repo)
    {
        $comments = $repo->findAll();
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     * Affiche un formulaire à un champ permettant de modifier un commentaire
     * 
     * @Route("/admin/comments/{id}/edit", name="admin_comments_edit")
     *
     * @return Response
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminCommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire n°{$comment->getId()} a bien été modifié"
            );
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer le commentaire avec l'id spécifie dans la route
     * 
     * @Route("/admin/comments/{id}/delete", name="admin_comments_delete")
     *
     * @return void
     */
    public function delete($id){
        $manager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Comment::class);
        $comment = $repo->find($id);

        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire n°{$id} a bien été supprimé !"
        );

        return $this->redirectToRoute("admin_comments_index");
    }
}
