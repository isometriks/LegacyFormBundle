<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\Functional;

use Isometriks\Bundle\LegacyFormBundle\Tests\Form\Type\CustomTextType;
use Isometriks\Bundle\LegacyFormBundle\Tests\Functional\Extension\TextTypeExtension;
use PHPUnit_Framework_Assert as Assert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * @author Craig Blanchette <craig.blanchette@gmail.com>
 * @runTestsInSeparateProcesses
 */
final class FormTypeExtensionTest extends KernelTestCase
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * {@inheritdoc}
     */
    protected static function createKernel(array $options = [])
    {
        return new TestKernel(function (ContainerBuilder $container, LoaderInterface $loader) {
            // Custom Type
            $definition = new Definition(CustomTextType::class);
            $definition->addTag('form.type', ['alias' => 'custom_text']);

            $container->setDefinition('form.type.custom', $definition);

            // Custom Type Extension
            $extensionDefinition = new Definition(TextTypeExtension::class);
            $extensionDefinition->addTag('form.type_extension', ['extended_type' => 'custom_text']);

            $container->setDefinition('form.type_extension.custom', $extensionDefinition);
        });
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->formFactory = static::$kernel->getContainer()->get('form.factory');
    }

    /**
     * @test
     */
    public function it_adds_custom_type_extension_by_legacy_alias()
    {
        $form = $this->formFactory->create('custom_text');
        $configValue = $form->getConfig()->getOption('custom_option');

        Assert::assertEquals('custom_value', $configValue);
    }
}
