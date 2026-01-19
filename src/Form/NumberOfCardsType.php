<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;

class NumberOfCardsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numberOfCards', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 52,
                    'class' => 'text-center text-[2em] font-bold text-text-dark bg-transparent border-none outline-none w-24 focus:ring-2 focus:ring-primary-from rounded-lg',
                    'placeholder' => '7',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nombre de cartes.',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 52,
                        'notInRangeMessage' => 'Le nombre de cartes doit être entre {{ min }} et {{ max }}.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Confirmer',
                'attr' => [
                    'class' => 'bg-gradient-primary text-white px-12 py-4 text-[1.2em] font-bold rounded-[50px] cursor-pointer transition-all duration-300 ease-in-out shadow-[0_4px_15px_rgba(102,126,234,0.4)] inline-block hover:-translate-y-0.5 hover:shadow-[0_6px_20px_rgba(102,126,234,0.6)]',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'number_of_cards',
        ]);
    }
}
