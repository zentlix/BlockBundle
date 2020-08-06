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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\UI\Http\Web\FormType\AbstractForm;
use Zentlix\MainBundle\UI\Http\Web\Type;
use Zentlix\BlockBundle\Application\Command\Block\Command;
use Zentlix\BlockBundle\Domain\Block\Entity\Block;

class Form extends AbstractForm
{
    protected EventDispatcherInterface $eventDispatcher;
    protected TranslatorInterface $translator;

    public function __construct(EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Command $textBlock */
        $textBlock = $builder->getData();

        $builder
            ->add('info', Type\NoticeType::class, [
                'data' => 'zentlix_block.info'
            ])
            ->add('title', Type\TextType::class, [
                'label' => 'zentlix_main.title'
            ])
            ->add('code', Type\TextType::class, [
                'label'    => 'zentlix_main.symbol_code',
                'required' => false
            ])
            ->add('type', Type\ChoiceType::class, [
                'choices' => [
                    'zentlix_block.html_editor' => 'html',
                    'zentlix_block.source_code' => 'raw',
                ],
                'label'  => 'zentlix_main.type',
                'update' => true
            ])
            ->add('description', Type\TextareaType::class, [
                'label'    => 'zentlix_main.description',
                'required' => false,
                'help'     => 'zentlix_block.description_info'
            ])
            ->add('cache_group', Type\TextType::class, [
                'label'    => 'zentlix_block.cache_group',
                'required' => false
            ])
            ->add('content', $textBlock->type === Block::HTML_TYPE ? Type\EditorType::class : Type\TextareaType::class, [
                'label'    => 'zentlix_main.content',
                'required' => false
            ]);
    }
}