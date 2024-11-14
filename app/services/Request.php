<?php

namespace app\services;


class Request
{
    public function get($key)
    {
        $result = $this->sanitize($this->format()[$key] ?? null);
        return $result === "" ? null : $result;
    }

    public function getAll()
    {
        return array_map([$this, 'sanitize'], $this->format());
    }

    public function file($key)
    {
        return $_FILES[$key] ?? null;
    }

    private function format()
    {
        return array_merge($_GET, $_POST, $_FILES);
    }


    private function sanitize($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data); // Recursively sanitize arrays
        }
        return $data !== null ? htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8') : null;
    }

    public function validate($rule, $message = [])
    {
        $validate = new Validator(request()->getAll(), $rule, $message);
        $validate->validate();

        if ($errors = $validate->errors()) {
            foreach ($errors as $key => $error) {
                session()->error($key, $error[0]);
            }
            return redirect()->withInput(request()->getAll())->back();
        }

        return $errors;
    }
}
