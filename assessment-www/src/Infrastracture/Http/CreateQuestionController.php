<?php

namespace App\Infrastracture\Http;

use App\Application\Command\CreateQuestion\Api\CreateQuestionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        RequestStack $requestStack,
        private CreateQuestionServiceInterface $createQuestionService
    ) {
        $this->request = $requestStack->getMainRequest() ?? throw new RuntimeException();
    }

    public function __invoke()
    {
        $this->createQuestionService->execute();
    }

}