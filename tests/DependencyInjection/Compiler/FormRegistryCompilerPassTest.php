<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\DependencyInjection\Compiler;

use Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler\FormRegistryCompilerPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class FormRegistryCompilerPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function it_adds_new_aliases_based_on_tagged_form_services()
    {
        $formRegistry = new Definition();
        $formRegistry->setArguments([new Definition(), ['email' => EmailType::class]]);
        $this->setDefinition('isometriks.legacy_form.form_registry', $formRegistry);

        $aliasedForm = new Definition(TextType::class);
        $aliasedForm->addTag('form.type', ['alias' => 'aliased_form']);
        $this->setDefinition('form.aliased', $aliasedForm);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'isometriks.legacy_form.form_registry',
            1,
            ['email' => EmailType::class, 'aliased_form' => TextType::class]
        );
    }

    /**
     * @test
     */
    public function it_replaces_existing_aliases_based_on_tagged_form_services()
    {
        $formRegistry = new Definition();
        $formRegistry->setArguments([new Definition(), [
            'email' => EmailType::class
        ]]);
        $this->setDefinition('isometriks.legacy_form.form_registry', $formRegistry);

        $aliasedForm = new Definition(TextType::class);
        $aliasedForm->addTag('form.type', ['alias' => 'email']);
        $this->setDefinition('form.aliased', $aliasedForm);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'isometriks.legacy_form.form_registry',
            1,
            ['email' => TextType::class]
        );
    }

    /**
     * @test
     */
    public function it_ignores_tagged_form_services_if_they_do_not_have_alias()
    {
        $formRegistry = new Definition();
        $formRegistry->setArguments([new Definition(), []]);
        $this->setDefinition('isometriks.legacy_form.form_registry', $formRegistry);

        $aliasedForm = new Definition(TextType::class);
        $aliasedForm->addTag('form.type');
        $this->setDefinition('form.aliased', $aliasedForm);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'isometriks.legacy_form.form_registry',
            1,
            []
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FormRegistryCompilerPass());
    }
}
