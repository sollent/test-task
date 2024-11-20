<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\ProductPriceCalculateRequestDto;
use App\Dto\Response\BadRequestResponseDto;
use App\Dto\Response\ProductPriceCalculateResponseDto;
use App\Exception\ProductPriceCalculationException;
use App\Service\ProductPriceCalculator;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final class ProductPriceController extends AbstractController
{
    public function __construct(
        private readonly ProductPriceCalculator $productPriceCalculator,
    )
    {
    }

    #[Route('/api/calculate-price', methods: ['POST'])]
    #[OA\RequestBody]
    #[OA\Response(
        response: 200,
        description: 'Product price has been successfully calculated',
        content: new Model(type: ProductPriceCalculateResponseDto::class)
    )]
    #[OA\Response(
        response: 400,
        description: 'Provided data has error or unprocessable',
        content: new Model(type: BadRequestResponseDto::class)
    )]
    public function calculate(#[MapRequestPayload] ProductPriceCalculateRequestDto $calculateRequestDto): JsonResponse
    {
        try {
            $calculatedPrice = $this->productPriceCalculator->calculate(
                $calculateRequestDto->product,
                $calculateRequestDto->taxNumber,
                $calculateRequestDto->couponCode,
            );
        } catch (ProductPriceCalculationException $e) {
            return $this->json(
                new BadRequestResponseDto($e->getMessage(), $e->getCode()),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(new ProductPriceCalculateResponseDto($calculatedPrice), Response::HTTP_OK);
    }
}