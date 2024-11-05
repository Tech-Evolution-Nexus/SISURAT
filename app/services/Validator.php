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
            $fieldText = ucfirst($field);
            $this->errors[$field][] = "$fieldText wajib diisi.";
        }
    }

    protected function validateEmail($field)
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                    $fieldText = ucfirst($field);
            $this->errors[$field][] = "$fieldText harus berupa alamat email yang valid.";
        }
    }

    protected function validateMin($field, $parameter)
    {
        if (strlen($this->data[$field]) < $parameter) {
                    $fieldText = ucfirst($field);
            $this->errors[$field][] = "$fieldText minimal $parameter karakter.";
        }
    }

    protected function validateMax($field, $parameter)
    {
        if (strlen($this->data[$field]) > $parameter) {
                    $fieldText = ucfirst($field);
            $this->errors[$field][] = "$fieldText maksimal $parameter karakter.";
        }
    }

    protected function validateNumeric($field)
    {
        if (!is_numeric($this->data[$field])) {
                    $fieldText = ucfirst($field);
            $this->errors[$field][] = "$fieldText harus berupa angka.";
        }
    }
    protected function validateSame($field,$parameter)
    {
        if ($this->data[$field] == $this->data[$parameter]) {
                    $fieldText = ucfirst($field);
            $this->errors[$field][] = "$fieldText harus sama dengan $parameter.";
        }
    }
}
