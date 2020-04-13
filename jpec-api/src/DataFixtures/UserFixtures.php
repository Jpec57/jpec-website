<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{
  private $passwordEncoder;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder)
  {
    $this->passwordEncoder = $passwordEncoder;
  }

  protected function loadData(ObjectManager $manager)
  {
    $user = new User();
    $user->setEmail('jpec@cap-collectif.com');
    $user->setRoles(['ROLE_ADMIN']);
    $user->setPassword($this->passwordEncoder->encodePassword(
      $user,
      'admin'
    ));
    $manager->persist($user);
    $this->addReference('USER_JPEC', $user);

    $user = new User();
    $user->setEmail('user@hotmail.fr');
    $user->setPassword($this->passwordEncoder->encodePassword(
      $user,
      'user'
    ));
    $manager->persist($user);
    $this->addReference('USER_USER', $user);


    $this->createMany(10, 'main_users', function($i) use ($manager) {
      $user = new User();
      $user->setEmail(sprintf('user%d@benkyou.com', $i));
      $user->setPassword($this->passwordEncoder->encodePassword(
        $user,
        'engage'
      ));
      $apiToken1 = new ApiToken($user);
      $apiToken2 = new ApiToken($user);
      $manager->persist($apiToken1);
      $manager->persist($apiToken2);
      return $user;
    });
    $this->createMany(3, 'admin_users', function($i) {
      $user = new User();
      $user->setEmail(sprintf('admin%d@benkyou.com', $i));
      $user->setRoles(['ROLE_ADMIN']);
      $user->setPassword($this->passwordEncoder->encodePassword(
        $user,
        'engage'
      ));
      return $user;
    });

    $manager->flush();
  }
}