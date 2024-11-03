<?php

namespace app\services;

class Validator
{
    protected $data;
    protected $errors = [];
    protected $rules = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
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

    /**
     * Check if the data failed validation.
     *
     * @return bool
     */
    public function fails()
    {
        return !$this->passes();
    }

    /**
     * Get validation errors.
     *
     * @return array An array of errors.
     */
    public function errors()
    {
        return $this->errors;
    }

    // Validation rule methods

    protected function validateRequired($field)
    {
        if (empty($this->data[$field])) {
            $this->errors[$field][] = "$field wajib diisi.";
        }
    }

    protected function validateEmail($field)
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "$field harus berupa alamat email yang valid.";
        }
    }

    protected function validateMin($field, $parameter)
    {
        if (strlen($this->data[$field]) < $parameter) {
            $this->errors[$field][] = "$field harus terdiri dari minimal $parameter karakter.";
        }
    }

    protected function validateMax($field, $parameter)
    {
        if (strlen($this->data[$field]) > $parameter) {
            $this->errors[$field][] = "$field tidak boleh lebih dari $parameter karakter.";
        }
    }

    protected function validateNumeric($field)
    {
        if (!is_numeric($this->data[$field])) {
            $this->errors[$field][] = "$field harus berupa angka.";
        }
    }
}
