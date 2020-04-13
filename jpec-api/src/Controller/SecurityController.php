<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Repository\UserRepository;
use App\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

  private $passwordEncoder;
  private $userRepository;
  private $entityManager;
  private $tokenService;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository,
                              EntityManagerInterface $entityManager, TokenService $tokenService)
  {
    $this->passwordEncoder = $passwordEncoder;
    $this->userRepository = $userRepository;
    $this->entityManager = $entityManager;
    $this->tokenService = $tokenService;
  }

  /**
   * @Route("/logout", name="app_logout")
   */
  public function logout(): JsonResponse
  {
    $user = $this->getUser();
    if (!$user){
      return $this->json([
        'message' => 'No user currently logged in.',
      ], JsonResponse::HTTP_OK);
    }
    $this->tokenService->removeUserTokens($user->getId());
    return $this->json([
      'message' => 'Successfully logged out.',
    ], JsonResponse::HTTP_OK);

  }

  /**
   * @Route("/login", name="app_login", methods={"POST"})
   * @param Request $request
   * @return JsonResponse
   */
  public function login(Request $request): JsonResponse
  {
    $data = json_decode($request->getContent(), true);
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;
    if (!$email || !$password) {
      return $this->json([
        'message' => 'Email or password cannot be null.',
      ], JsonResponse::HTTP_BAD_REQUEST);
    }
    $user = $this->userRepository->findOneBy(['email' => $email]);
    if (!$user) {
      throw $this->createNotFoundException();
    }

    $isValid = $this->passwordEncoder->isPasswordValid($user, $password);
    if (!$isValid) {
      return $this->json([
        'message' => 'Email or password not correct.',
      ], JsonResponse::HTTP_BAD_REQUEST);
    }
    $token = new ApiToken($user);
    $this->entityManager->persist($token);
    $this->entityManager->flush();

    return $this->json([
      'token' => $token->getToken(),
    ], JsonResponse::HTTP_OK);
  }
}
