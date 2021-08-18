<?php

declare(strict_types=1);

namespace App\Infrastracture\Http;

use App\Application\Questions\Api\QuestionsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Yaml\Exception\RuntimeException;

class QuestionsController extends AbstractController
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private Request $request;

    public function __construct(
        RequestStack $requestStack,
        private QuestionsServiceInterface $questionsService
    ) {
        $this->request = $requestStack->getMainRequest() ?? throw new RuntimeException();
    }

    public function __invoke(): JsonResponse
    {
        $lang = $this->request->query
                ->get('lang') ?? throw new BadRequestHttpException('required parameter is missed');
        $response = $this->questionsService->execute($lang);

        return new JsonResponse($response);
    }
}