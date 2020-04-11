<?php

namespace App\Form;

use App\Entity\Deck;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DeckFormType extends AbstractType
{

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('id', IntegerType::class, []
      )
      ->add('title', TextType::class, [
          'constraints' => [
            new Assert\NotNull(),
            new Assert\NotBlank(),
            new Assert\Length(['min' => 2]),
          ],
        ]
      )
      ->add('author', TextType::class, [
        'constraints' => [
          new Assert\NotNull(),
          new Assert\NotBlank(),
          new Assert\Length(['min' => 2]),
        ],
      ])
      ->add('description', TextType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Deck::class,
      'csrf_protection' => false
    ]);
  }
}