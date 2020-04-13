<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Form\DeckFormType;
use App\Repository\DeckRepository;
use App\Traits\FormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
  use FormTrait;

  private $deckRepository;
  private $entityManager;

  public function __construct(DeckRepository $deckRepository,
                              EntityManagerInterface $entityManager)
  {
    $this->deckRepository = $deckRepository;
    $this->entityManager = $entityManager;
  }

  /**
   * @IsGranted("ROLE_USER")
   * @Route("/decks", name="add_deck", methods={"POST"})
   * @param Request $request
   * @return JsonResponse
   */
  public function addDeck(Request $request): JsonResponse
  {
    $deck = new Deck();
    $validationGroups = ['Default'];
    $data = json_decode($request->getContent(), true);
    $id = $data['id'] ?? null;
    if (isset($id)){
      $id = $data['id'];
      $validationGroups[] = 'UpdateDeck';
      $deck = $this->deckRepository->find($id);
      if (!$deck){
        return $this->json([
          'message' => 'There is no deck with with id'
        ], JsonResponse::HTTP_NOT_FOUND);
      }
    }
    $form = $this->createForm(DeckFormType::class, $deck, [
      'validation_groups' => $validationGroups,
    ]);
    $form->handleRequest($request);

    $form->submit($data);

    if ($form->isSubmitted() && !$form->isValid()) {
      $errorArray = $this->getErrorsArray($form);
      return $this->json(['errors' => $errorArray], JsonResponse::HTTP_BAD_REQUEST);
    }
    if ($id){
      $this->entityManager->merge($deck);
    } else {
      $this->entityManager->persist($deck);
    }
    $this->entityManager->flush();
    return $this->json($deck, JsonResponse::HTTP_CREATED, [], ['groups' => 'deck']);
  }

  /**
   * @Route("/decks/{id}", name="show_deck", methods={"GET"})
   * @param int $id
   * @return JsonResponse
   */
  public function getDeck(int $id): JsonResponse
  {
    $deck = $this->deckRepository->find($id);
    if (!$deck) {
      return $this->json([
        'message' => 'There is no deck with with id'
      ], JsonResponse::HTTP_NOT_FOUND);
    }
    return $this->json($deck, JsonResponse::HTTP_OK, [], ['groups' => 'deck']);
  }

  /**
   * @IsGranted("ROLE_USER")
   * @Route("/decks/{id}", name="delete_deck", methods={"DELETE"})
   * @param int $id
   * @return JsonResponse
   */
  public function removeDeck(int $id): JsonResponse
  {
    $deck = $this->deckRepository->find($id);
    if (!$deck){
      return $this->json([
        'message' => 'There is no deck with with id'
      ], JsonResponse::HTTP_NOT_FOUND);
    }
    $this->entityManager->remove($deck);
    $this->entityManager->flush();
    return $this->json(['message' => 'Successfully removed deck.'], JsonResponse::HTTP_OK, [], ['groups' => 'deck']);
  }

}