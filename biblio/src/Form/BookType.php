<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class, [
                'label' => 'Nom du livre',
                'constraints' => [
                    new NotNull(),
                    new NotBlank(),
            ]])
            ->add('Author', TextType::class, [
                'label' => 'Nom de l\'auteur',
                'constraints' => [
                    new NotNull(),
                    new NotBlank(),
            ]])
            ->add('Resume', TextareaType::class, [
                'label' => 'Un petit résumé',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le résumé ne peut pas être aussi court',
                    ])
                ]
            ])
            ->add('isRead', CheckboxType::class, [
                'label' => 'Déjà lu ?',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
