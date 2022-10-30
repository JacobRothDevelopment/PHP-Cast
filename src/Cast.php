<?php

namespace PhpCast;

use TypeError;

class Cast
{
    /** Cast any data to a different type
     * @param mixed $data
     * @param string $castType ex. `int`, `object`, or some custom class
     * @param bool $strict When true, casting native types will throw an error
     *  if the castType is different than the data's type. Exceptions are made
     *  when casting to "object", "stdClass", or a custom class. When casting
     *  to a class, all typed, public properties will adhere to the same strict
     *  casting as native types
     * @return mixed It will be the same type as the inputted castType 
     */
    public static function cast(string $castType, $data, bool $strict = false)
    {
        $dataType = gettype($data);
        $castToObjectTypes = ["object", "array"];
        $e = new TypeError(serialize($data) . " is not of type $castType");

        switch ($castType) {
            case "":
            case "mixed":
                return $data;
                break;
            case 'null':
                return null;
                break;
            case 'int':
                if ($strict && $dataType !== "integer") throw $e;
                return (int)$data;
                break;
            case 'double':
            case 'float':
                if ($strict && !in_array($dataType, ["double", "integer"])) throw $e;
                return (float)$data;
                break;
            case 'string':
                if ($strict && $dataType !== "string") throw $e;
                return (string)$data;
                break;
            case 'bool':
                if ($strict && $dataType !== "boolean") throw $e;
                return (bool)$data;
                break;
            case 'array':
                if ($strict && $dataType !== "array") throw $e;
                return (array)$data;
                break;
            case 'stdClass':
            case 'object':
                if ($strict && !in_array($dataType, $castToObjectTypes))
                    throw $e;

                if ($dataType === "object") {
                    // do this to cast custom classes to stdClass Object
                    return (object)((array)$data);
                } else {
                    return (object)$data;
                }
                break;
            default: // these to be from objects or arrays
                if ($strict && !in_array($dataType, $castToObjectTypes))
                    throw $e;
                /* force input data to be object. 
                 * Handling other stuff is dumb and hard work 
                 * and I don't want to do dumb and hard work */
                if ($dataType !== "object") $data = (object)$data;
                return Cast::castToClass($castType, $data, $strict);
                break;
        }
    }

    private static function castToClass(string $class, $o, bool $strict)
    {
        $refClass = new \ReflectionClass($class);
        $obj = new $class;
        $refProps = $refClass->getProperties();
        foreach ($refProps as $refProp) {
            $propName = $refProp->getName();
            $propType = $refProp->getType();

            // if class property doesn't have a type; treat it as 'mixed'
            $propTypeName = "";
            if ($propType !== null) $propTypeName = $propType->getName();

            if (isset($o->$propName)) {
                $obj->$propName = Cast::cast($propTypeName, $o->$propName, $strict);
            } else {
                $obj->$propName = null;
            }
        }
        return $obj;
    }
}
