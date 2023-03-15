<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
{	
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('title', TextType::class)
			->add('description', TextareaType::class)
			->add('location', TextType::class)
			->add('startDate', DateTimeType::class)
			->add('endDate', DateTimeType::class)
			/*
			->add('organizer', EntityType::class, [
				'class' => User::class,
				'choice_label' => 'fullName', // use the getFullName method of the User entity
			]) */
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Event::class,
		]);

		// make sure the organizer option is a User object
		//$resolver->setAllowedTypes('organizer', [User::class]); // option
	}
}
