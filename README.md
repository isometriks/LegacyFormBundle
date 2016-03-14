Legacy Form Bundle
==================

Allows you to use the old way of aliasing forms. Just continue to use this syntax:

```
<service id="my_form" class="Acme\Form\Type\MyType">
    <tag name="form.type" alias="my_type" />
</service>
```

Currently does not work with parent type aliases, you must still use a FQCN in `getParent()`.
(This should be able to be added though)