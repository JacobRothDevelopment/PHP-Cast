<?php

namespace PhpCast;

class Cast
{
    /** Cast any data to a different type
     * @param mixed $data
     * @param string $castType ex. `int`, `object`, or some custom class
     * @return mixed I suggest you use phpdoc `@var` to type hint the returned value 
     */
    public static function cast($data, string $castType)
    {
        print(gettype($data) . " : ");
        // TODO need to account for 'array' type. not sure how to handle that yet
        switch ($castType) {
            case 'null':
                return null;
                break;
            case 'int':
                return (int)$data;
                break;
            case 'float':
                return (float)$data;
                break;
            case 'double':
                return (float)$data;
                break;
            case 'string':
                return (string)$data;
                break;
            case 'bool':
                return (bool)$data;
                break;
            case 'object':
                return Cast::castToObject($data, 'object');
                break;
            default:
                /* from here it could be 2 things:
                    1) custom class
                    2) array of 
                */
                // TODO
                return Cast::castToObject($data, $castType);
                break;
        }
    }

    private static function castToObject($values, string $class)
    {
        // if casting to generic object, return it casted as generic object
        if (strtolower($class) === "object") {
            return (object)$values;
        }

        $obj = new $class;
        foreach ($values as $key => $value) {
            // Currently, we loop over data values, do it the other way. loop over class props
            // TODO
            if (property_exists($class, $key)) {
                try {
                    $obj->$key = $value;
                } catch (\TypeError $e) {
                    throw new \Exception("TODO"); // TODO
                }
            }
        }

        return $obj;
    }
}
