<?php

namespace System\Core\Helpers;

class Validation
{
    public static function validate($value, ?array $params)
    {
        if (!$params) {
            return $value;
        }

        $paramsCheck = self::check($value, $params);

        if (!$paramsCheck) {
            return false;
        } else {
            return $value;
        }
    }

    private static function check($value, array $params)
    {
        foreach ($params as $param) {
            $exploded = explode(':', $param);

            switch ($exploded[0]) {
                case 'maxLength':
                    if (strlen($value) > $exploded[1]) {
                        return false;
                    }
                break;

                case 'minLength':
                    if (strlen($value) < $exploded[1]) {
                        return false;
                    }
                break;

                case 'exists':
                    $value = Database::table($exploded[1])
                        ->select()
                        ->where('id', '=', $value)
                        ->first();

                    if (!$value) {
                        return false;
                    }
                break;
            }
        }

        return true;
    }
}