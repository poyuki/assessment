<?php

namespace App\Infrastructure\EventListener;

use App\Infrastructure\Validator\Exception\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class JsonExceptionConverter
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationException) {
            $response = $exception;
            $code = 400;
        } elseif ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
            $response = ['error' => $exception->getMessage()];
        } else {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            $code = 500;
            $response = ['error' => 'internal server err'];
        }
        $event->setResponse(new JsonResponse($response, $code));
    }
}