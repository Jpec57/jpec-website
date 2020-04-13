<?php

namespace App\Controller;

use App\Entity\CardBatchMeta;
use App\Form\CardBatchMetaFormType;
use App\Service\ReviewService;
use App\Traits\FormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
  use FormTrait;

  private $entityManager;
  private $reviewService;

  public function __construct(EntityManagerInterface $entityManager, ReviewService $reviewService)
  {
    $this->entityManager = $entityManager;
    $this->reviewService = $reviewService;
  }

  /**
   * @IsGranted("ROLE_USER")
   * @Route("/review", name="review_batch", methods={"POST"})
   * @param Request $request
   * @return JsonResponse
   * @throws \Exception
   */
  public function reviewBatch(Request $request): JsonResponse
  {
    $cardBatchMeta = new CardBatchMeta();
    $form = $this->createForm(CardBatchMetaFormType::class, $cardBatchMeta);
    $data = json_decode($request->getContent(), true);
    $form->handleRequest($request);

    $form->submit($data);
    if ($form->isSubmitted() && !$form->isValid()) {
      $errorArray = $this->getErrorsArray($form);
      return $this->json(['errors' => $errorArray], JsonResponse::HTTP_BAD_REQUEST);
    }

    $cards = $cardBatchMeta->getCards();
    if (!$cards || count($cards) === 0){
      return $this->json(['message' => 'You must review at least one card.'], JsonResponse::HTTP_BAD_REQUEST);
    }
    $user = $this->getUser();
    if (!$user){
      return $this->json(['message' => 'You must be connected to review cards.'], JsonResponse::HTTP_FORBIDDEN);
    }
    $cardErrors = $this->reviewService->reviewCards($cards, $user);
    if (count($cardErrors) > 0){
      return $this->json([
        'message' => 'The review has been saved, but some cards were not correctly updated.',
        'errors' => $cardErrors
      ], JsonResponse::HTTP_ACCEPTED);
    }
    return $this->json(['message' => 'The review has been correctly saved.'], JsonResponse::HTTP_OK);
  }

}