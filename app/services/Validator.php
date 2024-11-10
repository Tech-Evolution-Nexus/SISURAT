<?php

namespace app\services;

class Validator
{
    protected $data;
    protected $errors = [];
    protected $rules = [];
    protected $messages = [];

    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            foreach (explode('|', $rules) as $rule) {
                $ruleName = $rule;
                $parameter = null;

                if (strpos($rule, ':') !== false) {
                    [$ruleName, $parameter] = explode(':', $rule, 2);
                }

                $methodName = "validate" . ucfirst($ruleName);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($field, $parameter);
                }
            }
        }

        return empty($this->errors);
    }

    public function passes()
    {
        return empty($this->errors);
    }

    public function fails()
    {
        return !$this->passes();
    }

    public function errors()
    {
        return $this->errors;
    }

    // Helper method to get a custom message or default message
    protected function getMessage($field, $rule, $default)
    {
        return $this->messages["$field.$rule"] ?? $default;
    }

    // Validation rule methods

    protected function validateRequired($field)
    {
        if (empty($this->data[$field])) {
            $defaultMessage = ucfirst($field) . " wajib diisi.";
            $this->errors[$field][] = $this->getMessage($field, 'required', $defaultMessage);
        }
    }

    protected function validateEmail($field)
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $defaultMessage = ucfirst($field) . " harus berupa alamat email yang valid.";
            $this->errors[$field][] = $this->getMessage($field, 'email', $defaultMessage);
        }
    }

    protected function validateMin($field, $parameter)
    {
        if (strlen($this->data[$field]) < $parameter) {
            $defaultMessage = ucfirst($field) . " minimal $parameter karakter.";
            $this->errors[$field][] = $this->getMessage($field, 'min', $defaultMessage);
        }
    }

    protected function validateMax($field, $parameter)
    {
        if (strlen($this->data[$field]) > $parameter) {
            $defaultMessage = ucfirst($field) . " maksimal $parameter karakter.";
            $this->errors[$field][] = $this->getMessage($field, 'max', $defaultMessage);
        }
    }

    protected function validateNumeric($field)
    {
        if (!is_numeric($this->data[$field])) {
            $defaultMessage = ucfirst($field) . " harus berupa angka.";
            $this->errors[$field][] = $this->getMessage($field, 'numeric', $defaultMessage);
        }
    }

    protected function validateSame($field, $parameter)
    {
        if ($this->data[$field] != $this->data[$parameter]) {
            $defaultMessage = ucfirst($field) . " harus sama dengan " . ucfirst($parameter) . ".";
            $this->errors[$field][] = $this->getMessage($field, 'same', $defaultMessage);
        }
    }
    protected function validateDate($field)
    {
        if (strtotime($this->data[$field]) === false) {
            $defaultMessage = "Format tanggal tidak valid";
            $this->errors[$field][] = $this->getMessage($field, 'date', $defaultMessage);
        }
    }
}
