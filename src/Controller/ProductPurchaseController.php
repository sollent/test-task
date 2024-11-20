<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\ProductPurchaseRequestDto;
use App\Dto\Response\BadRequestResponseDto;
use App\Dto\Response\ProductPurchaseResponseDto;
use App\Enum\PaymentsProcessorType;
use App\Exception\ProductPriceCalculationException;
use App\Exception\ProductPurchaseException;
use App\Service\ProductPurchaseService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ProductPurchaseController extends AbstractController
{
    public function __construct(
        private readonly ProductPurchaseService $productPurchaseService,
    ) {
    }

    #[Route('/api/purchase', methods: ['POST'])]
    #[OA\RequestBody]
    #[OA\Response(
        response: 200,
        description: 'Product has been successfully purchased',
        content: new Model(type: ProductPurchaseResponseDto::class)
    )]
    #[OA\Response(
        response: 400,
        description: 'Provided data has error or unprocessable',
        content: new Model(type: BadRequestResponseDto::class)
    )]
    public function calculate(#[MapRequestPayload] ProductPurchaseRequestDto $purchaseRequestDto): JsonResponse
    {
        try {
            $this->productPurchaseService->purchase(
                $purchaseRequestDto->product,
                $purchaseRequestDto->taxNumber,
                $purchaseRequestDto->couponCode,
                PaymentsProcessorType::from($purchaseRequestDto->paymentProcessorType)
            );
        } catch (ProductPriceCalculationException|ProductPurchaseException $e) {
            return $this->json(
                new BadRequestResponseDto($e->getMessage(), $e->getCode()),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            new ProductPurchaseResponseDto('Product has been successfully purchased'),
            Response::HTTP_OK
        );
    }
}