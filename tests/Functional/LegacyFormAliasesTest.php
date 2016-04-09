<?php

namespace Isometriks\Bundle\LegacyFormBundle\Tests\Functional;

use PHPUnit_Framework_Assert as Assert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class LegacyFormAliasesTest extends KernelTestCase
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
        return new TestKernel(false);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        \Locale::setDefault('en');

        self::bootKernel();

        $this->formFactory = static::$kernel->getContainer()->get('form.factory');
    }

    /**
     * @test
     *
     * @dataProvider getLegacyFormAliases
     */
    public function it_creates_symfony_forms_by_legacy_alias($alias)
    {
        $form = $this->formFactory->create($alias);

        Assert::assertInstanceOf(FormInterface::class, $form);
    }

    /**
     * @return array
     */
    public function getLegacyFormAliases()
    {
        return [
            ['birthday'],
            ['button'],
            ['checkbox'],
            ['choice'],
            ['collection'],
            ['country'],
            ['currency'],
            ['datetime'],
            ['date'],
            ['email'],
            ['file'],
            ['form'],
            ['hidden'],
            ['integer'],
            ['language'],
            ['locale'],
            ['money'],
            ['number'],
            ['password'],
            ['percent'],
            ['radio'],
            ['range'],
            ['repeated'],
            ['reset'],
            ['search'],
            ['submit'],
            ['text'],
            ['textarea'],
            ['time'],
            ['timezone'],
            ['url'],
        ];
    }
}
