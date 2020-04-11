<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Traits\FormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
  use FormTrait;

  private $entityManager;
  private $answerRepository;

  public function __construct(EntityManagerInterface $entityManager, AnswerRepository $answerRepository)
  {
    $this->entityManager = $entityManager;
    $this->answerRepository = $answerRepository;
  }

  /**
   * @Route("/answers/{id}", name="show_answer", methods={"GET"})
   * @param int $id
   * @return JsonResponse
   */
  public function getAnswer(int $id): JsonResponse
  {
    $answer = $this->answerRepository->find($id);
    if (!$answer) {
      return $this->json([
        'message' => 'There is no answer with with id'
      ], JsonResponse::HTTP_NOT_FOUND);
    }
    return $this->json($answer, JsonResponse::HTTP_OK, [], ['groups' => 'answer']);
  }
}