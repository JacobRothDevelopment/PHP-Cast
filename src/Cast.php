<?php

namespace PhpCast;

use TypeError;

class Cast
{
    /** Cast any data to a different type
     * @param mixed $data
     * @param string $castType ex. `int`, `object`, or some custom class
     * @param bool $strict ex. `int`, `object`, or some custom class
     * @return mixed It will be the same type as the inputted castType 
     */
    public static function cast(string $castType, $data, bool $strict = false)
    {
        $dataType = gettype($data);
        $castToObjectTypes = ["object", "array"];
        switch ($castType) {
            case "":
            case "mixed":
                return $data;
                break;
            case 'null':
                return null;
                break;
            case 'int':
                if ($strict && $dataType !== "integer") throw new TypeError("$data is not of type $castType");
                return (int)$data;
                break;
            case 'double':
            case 'float':
                if ($strict && $dataType !== "double") throw new TypeError("$data is not of type $castType");
                return (float)$data;
                break;
            case 'string':
                if ($strict && $dataType !== "string") throw new TypeError("$data is not of type $castType");
                return (string)$data;
                break;
            case 'bool':
                if ($strict && $dataType !== "boolean") throw new TypeError("$data is not of type $castType");
                return (bool)$data;
                break;
            case 'array':
                if ($strict && $dataType !== "array") throw new TypeError("$data is not of type $castType");
                return (array)$data;
                break;
            case 'stdClass':
            case 'object':
                if ($strict && !in_array($dataType, $castToObjectTypes)) throw new TypeError("$data is not of type $castType");
                if ($dataType === "object") {
                    // do this to cast custom classes to stdClass Object
                    return (object)((array)$data);
                } else {
                    return (object)$data;
                }
                break;
            default: // these to be from objects or arrays
                if ($strict && !in_array($dataType, $castToObjectTypes)) throw new TypeError("$data is not of type $castType");
                /* force input data to be object. 
                 * Handling other stuff is dumb and hard work 
                 * and I don't want to do dumb and hard work */
                if ($dataType !== "object") $data = (object)$data;
                return Cast::castToClass($castType, $data);
                break;
        }
    }

    private static function castToClass(string $class, $o)
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
                $obj->$propName = Cast::cast($propTypeName, $o->$propName);
            } else {
                $obj->$propName = null;
            }
        }
        return $obj;
    }
}
