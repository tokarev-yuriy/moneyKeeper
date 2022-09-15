<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * Undocumented function
     *
     * @param array $errors
     * @param integer $code
     * @param Throwable|null $previous
     */
    public function __construct(array $errors, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(implode("\n", $errors), $code, $previous);
        $this->errors = $errors;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
