<?php

namespace PhpCast;

class Cast
{
    /** Cast any data to a different type
     * @param mixed $data
     * @param string $castType ex. `int`, `object`, or some custom class
     * @return mixed It will be the same type as the inputted castType 
     */
    public static function cast(string $castType, $data)
    {
        switch ($castType) {
            case "":
            case "mixed":
                return $data;
                break;
            case 'null':
                return null;
                break;
            case 'int':
                return (int)$data;
                break;
            case 'double':
            case 'float':
                return (float)$data;
                break;
            case 'string':
                return (string)$data;
                break;
            case 'bool':
                return (bool)$data;
                break;
            case 'array':
                return (array)$data;
                break;
            case 'object':
                if (gettype($data) === "object") {
                    // do this to cast custom classes to stdClass Object
                    return (object)((array)$data);
                } else {
                    return (object)$data;
                }
                break;
            case 'stdClass':
                return (object)(array)$data;
                break;
            default: // assume these are custom types
                /* force input data to be object. 
                 * Handling other stuff is dumb and hard work 
                 * and I don't want to be dumb or do hard work */
                if (gettype($data) !== "object") $data = (object)$data;
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
