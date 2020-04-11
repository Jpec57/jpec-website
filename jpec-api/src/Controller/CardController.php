<?php

namespace App\Controller;

use App\Repository\CardRepository;
use App\Traits\FormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
  use FormTrait;

  private $entityManager;
  private $cardRepository;

  public function __construct(EntityManagerInterface $entityManager, CardRepository $cardRepository)
  {
    $this->entityManager = $entityManager;
    $this->cardRepository = $cardRepository;
  }

  /**
   * @Route("/cards/{id}", name="show_card", methods={"GET"})
   * @param int $id
   * @return JsonResponse
   */
  public function getCard(int $id): JsonResponse
  {
    $card = $this->cardRepository->find($id);
    if (!$card) {
      return $this->json([
        'message' => 'There is no card with with id'
      ], JsonResponse::HTTP_NOT_FOUND);
    }
    return $this->json($card, JsonResponse::HTTP_OK, [], ['groups' => 'card']);
  }
}