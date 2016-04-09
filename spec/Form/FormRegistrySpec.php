<?php

namespace spec\Isometriks\Bundle\LegacyFormBundle\Form;

use Isometriks\Bundle\LegacyFormBundle\Form\FormRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Form\ResolvedFormTypeInterface;

/**
 * @mixin FormRegistry
 *
 * @author Kamil Kokot <kamil@kokot.me>
 */
final class FormRegistrySpec extends ObjectBehavior
{
    function let(FormRegistryInterface $decoratedFormRegistry)
    {
        $this->beConstructedWith($decoratedFormRegistry, []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FormRegistry::class);
    }

    function it_is_a_symfony_form_registry()
    {
        $this->shouldImplement(FormRegistryInterface::class);
    }

    function it_delegates_getting_type_if_there_is_no_custom_aliases_defined(
        FormRegistryInterface $decoratedFormRegistry,
        ResolvedFormTypeInterface $formType
    ) {
        $decoratedFormRegistry->getType(EmailType::class)->willReturn($formType);

        $this->getType(EmailType::class)->shouldReturn($formType);
    }

    function it_delegates_getting_type_with_changed_name_if_there_is_suitable_alias_defined(
        FormRegistryInterface $decoratedFormRegistry,
        ResolvedFormTypeInterface $formType
    ) {
        $this->beConstructedWith($decoratedFormRegistry, ['email' => EmailType::class]);

        $decoratedFormRegistry->getType(EmailType::class)->willReturn($formType);

        $this->getType('email')->shouldReturn($formType);
    }

    function it_delegates_getting_type_with_unchanged_name_if_there_is_inversed_suitable_alias_defined(
        FormRegistryInterface $decoratedFormRegistry,
        ResolvedFormTypeInterface $formType
    ) {
        $this->beConstructedWith($decoratedFormRegistry, ['weirdname' => EmailType::class]);

        $decoratedFormRegistry->getType(EmailType::class)->willReturn($formType);
        $decoratedFormRegistry->getType('weirdname')->shouldNotBeCalled();

        $this->getType(EmailType::class)->shouldReturn($formType);
    }

    function it_delegates_checking_type_existence_if_there_is_no_custom_aliases_defined(
        FormRegistryInterface $decoratedFormRegistry
    ) {
        $decoratedFormRegistry->hasType(EmailType::class)->willReturn(true);

        $this->hasType(EmailType::class)->shouldReturn(true);
    }

    function it_delegates_checking_type_existence_with_changed_name_if_there_is_suitable_alias_defined(
        FormRegistryInterface $decoratedFormRegistry
    ) {
        $this->beConstructedWith($decoratedFormRegistry, ['email' => EmailType::class]);

        $decoratedFormRegistry->hasType(EmailType::class)->willReturn(true);

        $this->hasType('email')->shouldReturn(true);
    }

    function it_delegates_checking_type_existence_with_unchanged_name_if_there_is_inversed_suitable_alias_defined(
        FormRegistryInterface $decoratedFormRegistry
    ) {
        $this->beConstructedWith($decoratedFormRegistry, ['weirdname' => EmailType::class]);

        $decoratedFormRegistry->hasType(EmailType::class)->willReturn(true);
        $decoratedFormRegistry->hasType('weirdname')->shouldNotBeCalled();

        $this->hasType(EmailType::class)->shouldReturn(true);
    }

    function it_delegates_getting_type_guesser(FormRegistryInterface $decoratedFormRegistry)
    {
        $decoratedFormRegistry->getTypeGuesser()->willReturn(null);

        $this->getTypeGuesser()->shouldReturn(null);
    }

    function it_delegates_getting_extensions(
        FormRegistryInterface $decoratedFormRegistry,
        FormExtensionInterface $formExtension
    ) {
        $decoratedFormRegistry->getExtensions()->willReturn([$formExtension]);

        $this->getExtensions()->shouldReturn([$formExtension]);
    }
}
