<?php

declare(strict_types=1);

namespace App\Infrastracture\Http;

use App\Application\CreateQuestion\Api\CreateQuestionServiceInterface;
use App\Infrastracture\DtoFactory\CreateQuestionDtoFactory;
use App\Infrastracture\Validator\Api\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Yaml\Exception\RuntimeException;

class CreateQuestionController extends AbstractController
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private Request $request;

    public function __construct(
        RequestStack                           $requestStack,
        private CreateQuestionServiceInterface $createQuestionService,
        private ValidatorInterface             $createQuestionValidator,
        private CreateQuestionDtoFactory       $createQuestionDtoFactory
    ) {
        $this->request = $requestStack->getMainRequest() ?? throw new RuntimeException();
    }

    public function __invoke(): JsonResponse
    {
        $jsonContent = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $validatedData = $this->createQuestionValidator->validate($jsonContent);
        $result = $this->createQuestionService->execute($this->createQuestionDtoFactory->create($validatedData));

        return new JsonResponse($result);
    }

}