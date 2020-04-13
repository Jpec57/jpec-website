<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\CardBatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CardBatchFormType extends AbstractType
{

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('cardId', IntegerType::class, [
          'constraints' => [
            new Assert\NotNull(),
            new Assert\NotBlank(),
          ],
        ]
      )
      ->add('isSuccess', CheckboxType::class, [
        'constraints' => [
          new Assert\NotNull(),
        ],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => CardBatch::class,
      'csrf_protection' => false
    ]);
  }
}