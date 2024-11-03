<?php

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
            $this->errors[$field][] = "$field is required.";
        }
    }

    protected function validateEmail($field)
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "$field must be a valid email address.";
        }
    }

    protected function validateMin($field, $parameter)
    {
        if (strlen($this->data[$field]) < $parameter) {
            $this->errors[$field][] = "$field must be at least $parameter characters long.";
        }
    }

    protected function validateMax($field, $parameter)
    {
        if (strlen($this->data[$field]) > $parameter) {
            $this->errors[$field][] = "$field must be no more than $parameter characters long.";
        }
    }

    protected function validateNumeric($field)
    {
        if (!is_numeric($this->data[$field])) {
            $this->errors[$field][] = "$field must be a numeric value.";
        }
    }
}
