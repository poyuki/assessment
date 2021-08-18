<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

use App\Infrastructure\Validator\Exception\ValidationError;
use App\Infrastructure\Validator\Exception\ValidationException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class CreateQuestionValidator implements Api\ValidatorInterface
{

    private int $requiredChoicesCount;
    private PropertyAccessor $pa;

    public function __construct(
        ParameterBagInterface $parameterBag,
        private array $validationErrors = []
    ) {
        $this->pa = PropertyAccess::createPropertyAccessor();
        $this->requiredChoicesCount = $parameterBag->get('required_choices_count');
    }

    /**
     * @inheritDoc
     */
    public function validate(array $dataForValidation): array
    {
        $inputData = [
            'text' => $this->pa->getValue($dataForValidation, '[text]'),
            'choices' => $this->pa->getValue($dataForValidation, '[choices]')
        ];

        if ($inputData['text'] === null) {
            $this->validationErrors[] = new ValidationError('text', 'required field missed');
        }

        if (!is_string($inputData['text'])) {
            $this->validationErrors[] = new ValidationError('text', 'unexpected type');
        }

        if (!is_array($inputData['choices'])) {
            $this->validationErrors[] = new ValidationError('choices', 'unexpected type');
        }
        if (is_array($inputData['choices']) && count($inputData['choices']) !== $this->requiredChoicesCount) {
            $this->validationErrors[] = new ValidationError('choices', 'wrong choices count');
        }

        if (count($this->validationErrors) > 0) {
            throw new ValidationException($this->validationErrors);
        }
        return $inputData;
    }
}
