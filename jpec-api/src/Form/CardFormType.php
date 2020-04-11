<?php

namespace App\Form;

use App\Entity\Card;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CardFormType extends AbstractType
{

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('id', IntegerType::class, [])
      ->add('question', TextType::class, [
          'constraints' => [
            new Assert\NotNull(),
            new Assert\NotBlank(),
            new Assert\Length(['min' => 1]),
          ],
        ]
      )
      //TODO entity
      ->add('deck', TextType::class, [])
      ->add('languageCode', IntegerType::class)
      ->add('answerLanguageCode', IntegerType::class)
      ->add('isReversible', BooleanType::class)
      ->add('hint', TextType::class)
      //TODO
      ->add('answers', TextType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Card::class,
      'csrf_protection' => false
    ]);
  }
}