<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardFormType;
use App\Repository\CardRepository;
use App\Traits\FormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
   * @Route("/cards", name="add_card", methods={"POST"})
   * @param Request $request
   * @return JsonResponse
   */
  public function addCard(Request $request): JsonResponse
  {
    $card = new Card();
    $validationGroups = ['Default'];
    $data = json_decode($request->getContent(), true);
    $id = $data['id'] ?? null;
    if (isset($id)){
      $id = $data['id'];
      $validationGroups[] = 'UpdateCard';
      $card = $this->cardRepository->find($id);
      if (!$card){
        return $this->json([
          'message' => 'There is no card with with id'
        ], JsonResponse::HTTP_NOT_FOUND);
      }
    }
    $form = $this->createForm(CardFormType::class, $card, [
      'validation_groups' => $validationGroups,
    ]);
    $form->handleRequest($request);

    $form->submit($data);

    if ($form->isSubmitted() && !$form->isValid()) {
      $errorArray = $this->getErrorsArray($form);
      return $this->json(['errors' => $errorArray], JsonResponse::HTTP_BAD_REQUEST);
    }
    if ($id){
      $this->entityManager->merge($card);
    } else {
      $this->entityManager->persist($card);
    }
    $this->entityManager->flush();
    return $this->json($card, JsonResponse::HTTP_CREATED, [], ['groups' => 'card']);
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

  /**
   * @Route("/cards/{id}", name="delete_card", methods={"DELETE"})
   * @param int $id
   * @return JsonResponse
   */
  public function removeCard(int $id): JsonResponse
  {
    $card = $this->cardRepository->find($id);
    if (!$card){
      return $this->json([
        'message' => 'There is no card with with id'
      ], JsonResponse::HTTP_NOT_FOUND);
    }
    $this->entityManager->remove($card);
    $this->entityManager->flush();
    return $this->json(['message' => 'Successfully removed card.'], JsonResponse::HTTP_OK, [], ['groups' => 'card']);
  }
}