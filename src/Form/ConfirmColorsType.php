<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfirmColorsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('confirm', SubmitType::class, [
                'label' => 'Confirmer cet ordre',
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
            'csrf_token_id' => 'confirm_colors',
        ]);
    }
}
