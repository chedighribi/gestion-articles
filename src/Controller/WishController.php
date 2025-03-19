<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_')]
final class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list( WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findAll();
        return $this->render('wish/list.html.twig', [ "wishes" => $wishes]);
    }
    #[Route('/detail/{id}', name: 'detail')]
public function detail($id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        return $this->render('wish/detail.html.twig', [ "wish" => $wish]);
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $wish->setDateCreated(new \DateTime());
        $wish-> setAuthor('mr miagi');
        $wish->  setDescription('balbalbalbal');
        $wish->setTitle('this bug is good');
        $wish->setDateUpdated(new \DateTime());
        $em->persist($wish);
        $em->flush();
        return $this->render('wish/list.html.twig');
    }

}
