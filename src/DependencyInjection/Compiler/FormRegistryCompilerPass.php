<?php

namespace Isometriks\Bundle\LegacyFormBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

/**
 * @author Craig Blanchette <craig.blanchette@gmail.com>
 */
class FormRegistryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $defaultAliases = array(
            'birthday' => BirthdayType::class,
            'button' => ButtonType::class,
            'checkbox' => CheckboxType::class,
            'choice' => ChoiceType::class,
            'collection' => CollectionType::class,
            'country' => CountryType::class,
            'currency' => CurrencyType::class,
            'datetime' => DateTimeType::class,
            'date' => DateType::class,
            'email' => EmailType::class,
            'file' => FileType::class,
            'form' => FormType::class,
            'hidden' => HiddenType::class,
            'integer' => IntegerType::class,
            'language' => LanguageType::class,
            'locale' => LocaleType::class,
            'money' => MoneyType::class,
            'number' => NumberType::class,
            'password' => PasswordType::class,
            'percent' => PercentType::class,
            'radio' => RadioType::class,
            'range' => RangeType::class,
            'repeated' => RepeatedType::class,
            'reset' => ResetType::class,
            'search' => SearchType::class,
            'submit' => SubmitType::class,
            'text' => TextType::class,
            'textarea' => TextareaType::class,
            'time' => TimeType::class,
            'timezone' => TimezoneType::class,
            'url' => UrlType::class,
        );

        foreach ($container->findTaggedServiceIds('form.type') as $id => $tags) {
            foreach ($tags as $tag) {
                if (isset($tag['alias'])) {
                    $typeDefinition = $container->getDefinition($id);
                    $defaultAliases[$tag['alias']] = $typeDefinition->getClass();
                }
            }
        }

        $definition = $container->getDefinition('form.registry');
        $definition->setClass('Isometriks\Bundle\LegacyFormBundle\Form\FormRegistry');
        $definition->addArgument($defaultAliases);
    }
}
