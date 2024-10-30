<?php

class Validator
{
    private array $errors = [];

    public function isRequired(string $field, mixed $value): bool
    {
        if (empty(trim($value))) {
            $this->errors[$field][] = "$field is required.";
            return false;
        }
        return true;
    }

    public function isEmail(string $field, mixed $value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "Invalid email format for $field.";
            return false;
        }
        return true;
    }

    public function isMinLength(string $field, mixed $value, int $min): bool
    {
        if (strlen(trim($value)) < $min) {
            $this->errors[$field][] = "$field must be at least $min characters long.";
            return false;
        }
        return true;
    }

    public function isMaxLength(string $field, mixed $value, int $max): bool
    {
        if (strlen(trim($value)) > $max) {
            $this->errors[$field][] = "$field must not exceed $max characters.";
            return false;
        }
        return true;
    }

    public function isNumeric(string $field, mixed $value): bool
    {
        if (!is_numeric($value)) {
            $this->errors[$field][] = "$field must be a number.";
            return false;
        }
        return true;
    }

    public function isBetween(string $field, mixed $value, int $min, int $max): bool
    {
        if ($value < $min || $value > $max) {
            $this->errors[$field][] = "$field must be between $min and $max.";
            return false;
        }
        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
