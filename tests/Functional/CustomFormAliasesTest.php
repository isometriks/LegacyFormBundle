<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\Functional;

use PHPUnit_Framework_Assert as Assert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class CustomFormAliasesTest extends KernelTestCase
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
            $definition = new Definition(TextType::class);
            $definition->addTag('form.type', ['alias' => 'custom_text']);

            $container->setDefinition('form.type.custom', $definition);
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
    public function it_creates_custom_forms_by_legacy_alias()
    {
        $form = $this->formFactory->create('custom_text');

        Assert::assertInstanceOf(FormInterface::class, $form);
    }
}
