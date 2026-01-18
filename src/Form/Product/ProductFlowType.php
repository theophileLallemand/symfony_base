<?php

namespace App\Form\Product;

use App\Form\Product\Step\ProductDetailsStepType;
use App\Form\Product\Step\ProductLicenseStepType;
use App\Form\Product\Step\ProductLogisticsStepType;
use App\Form\Product\Step\ProductTypeStepType;
use Symfony\Component\Form\AbstractType;


class ProductFlowType extends AbstractType
{

    public static function getSteps(): array
    {
        return [
            ProductTypeStepType::class,
            ProductDetailsStepType::class,
            ProductLogisticsStepType::class,
            ProductLicenseStepType::class,
        ];
    }
}
