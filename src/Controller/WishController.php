<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_')]
final class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list( WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);
        if (!$wishes) {
            throw $this->createNotFoundException("sorry dude" );
        }
        return $this->render('wish/list.html.twig', [ "wishes" => $wishes]);
    }
    #[Route('/detail/{id}', name: 'detail')]
public function detail($id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        if (!$wish) {
            throw $this->createNotFoundException('sorry dude wish number '. $id . ' does not exist');
        }
        return $this->render('wish/detail.html.twig', [ "wish" => $wish]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $em->persist($wish);
            $em->flush();
            $this->addFlash('success', 'Wish has been created');
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }
        return $this->render('wish/create.html.twig', ['wishForm' => $wishForm]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
public function edit($id, EntityManagerInterface $em, Request $request): Response{
        $wish = $em->getRepository(Wish::class)->find($id);
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wish) {
            $wishForm = $this->createForm(WishType::class, $wish);

            $wishForm->handleRequest($request);

            if ($wishForm->isSubmitted() && $wishForm->isValid()) {
                $em->persist($wish);
                $em->flush();
                $this->addFlash('success', 'Wish has been edited');
                return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
            }
        }
        return $this->render('wish/edit.html.twig', ['wishForm' => $wishForm]);
    }
}
