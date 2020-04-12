<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Card;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AnswerFormType extends AbstractType
{

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('id', IntegerType::class)
      ->add('text', TextType::class, [
          'constraints' => [
            new Assert\NotNull(),
            new Assert\NotBlank(),
            new Assert\Length(['min' => 1]),
          ],
        ]
      )
      ->add('card', EntityType::class, [
        'class' => Card::class,
//        'constraints' => [
//          new Assert\NotNull(),
//        ],
      ])
      ->add('type', IntegerType::class, [
        'required' => false,
        'empty_data' => '' . Answer::TYPE_TEXT
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Answer::class,
      'csrf_protection' => false
    ]);
  }
}