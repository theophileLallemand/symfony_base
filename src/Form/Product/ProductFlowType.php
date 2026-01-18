use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\MultiStepForm;

class ProductFlowType extends MultiStepForm
{
    public function getSteps(): iterable
    {
        return [
            'type' => ProductTypeStepType::class,
            'details' => ProductDetailsStepType::class,
            'logistics' => ProductLogisticsStepType::class,
            'license' => ProductLicenseStepType::class,
        ];
    }

    public function isStepSkipped(string $step, FormInterface $form): bool
    {
        $data = $form->getData();

        if ($step === 'logistics' && $data->getType() !== 'physical') {
            return true;
        }

        if ($step === 'license' && $data->getType() !== 'digital') {
            return true;
        }

        return false;
    }
}
