<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\BlockBundle\UI\Http\Web\Form\Block;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zentlix\MainBundle\UI\Http\Web\Form\VisualEditorFormInterface;
use Zentlix\MainBundle\UI\Http\Web\Type;
use Zentlix\BlockBundle\Application\Command\Block\UpdateCommand;
use Zentlix\BlockBundle\Domain\Block\Event\VisualEditForm as VisualEditFormEvent;
use Zentlix\BlockBundle\Domain\Block\Entity\Block;

class VisualEditForm extends Form implements VisualEditorFormInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var UpdateCommand $command */
        $command = $builder->getData();

        $builder
            ->add('title', Type\TextType::class, [
                'label' => 'zentlix_main.title'
            ])
            ->add('description', Type\TextareaType::class, [
                'label'    => 'zentlix_main.description',
                'required' => false,
                'help'     => 'zentlix_block.info'
            ])
            ->add('content', Type\TextareaType::class, [
                'label'    => 'zentlix_main.content',
                'required' => false,
                'attr'     => [
                    'class' => $command->type === Block::HTML_TYPE ? 'cke-editor' : ''
                ]
            ]);

        $this->eventDispatcher->dispatch(new VisualEditFormEvent($builder));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateCommand::class,
            'label'      => 'zentlix_block.text_block'
        ]);
    }
}