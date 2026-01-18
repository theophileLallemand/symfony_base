class ProductTypeStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, [
            'choices' => [
                'Produit physique' => 'physical',
                'Produit numérique' => 'digital',
            ],
        ]);
    }
}
