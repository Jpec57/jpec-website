<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerFormType;
use App\Repository\AnswerRepository;
use App\Traits\FormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
   * @Route("/answers", name="add_answer", methods={"POST"})
   * @param Request $request
   * @return JsonResponse
   */
  public function addAnswer(Request $request): JsonResponse
  {
    $answer = new Answer();
    $validationGroups = ['Default'];
    $data = json_decode($request->getContent(), true);
    $id = $data['id'] ?? null;
    if (isset($id)){
      $id = $data['id'];
      $validationGroups[] = 'UpdateAnswer';
      $answer = $this->answerRepository->find($id);
      if (!$answer){
        return $this->json([
          'message' => 'There is no answer with with id'
        ], JsonResponse::HTTP_NOT_FOUND);
      }
    }
    $form = $this->createForm(AnswerFormType::class, $answer, [
      'validation_groups' => $validationGroups,
    ]);
    $form->handleRequest($request);

    $form->submit($data);

    if ($form->isSubmitted() && !$form->isValid()) {
      $errorArray = $this->getErrorsArray($form);
      return $this->json(['errors' => $errorArray], JsonResponse::HTTP_BAD_REQUEST);
    }
    if ($id){
      $this->entityManager->merge($answer);
    } else {
      $this->entityManager->persist($answer);
    }
    $this->entityManager->flush();
    return $this->json($answer, JsonResponse::HTTP_CREATED, [], ['groups' => 'answer']);
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

  /**
   * @Route("/answers/{id}", name="delete_answer", methods={"DELETE"})
   * @param int $id
   * @return JsonResponse
   */
  public function removeAnswer(int $id): JsonResponse
  {
    $answer = $this->answerRepository->find($id);
    if (!$answer){
      return $this->json([
        'message' => 'There is no answer with with id'
      ], JsonResponse::HTTP_NOT_FOUND);
    }
    $this->entityManager->remove($answer);
    $this->entityManager->flush();
    return $this->json(['message' => 'Successfully removed answer.'], JsonResponse::HTTP_OK, [], ['groups' => 'answer']);
  }
}