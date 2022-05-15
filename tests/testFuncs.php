<?php

$printOut = false;

define("TEST_FAILURE", "TEST_FAILURE");

function test(string $class, $value, $expectedOutput)
{
    global $printOut;
    if ($printOut) print(serialize($value) . "\n");

    try {
        $out = \PhpCast\Cast::cast($class, $value);

        if ($printOut) {
            print(print_r($out, true) . "\r\n");
            print(print_r($expectedOutput, true) . "\r\n");
        }
    } catch (\Error $e) {
        // if there is an error in casting value and it is expected, then, consider it a pass
        if ($printOut) print_r("error here :::::::: " . "\r\n");
        // if ($printOut) print_r($e->getMessage() . "\r\n");
        if (TEST_FAILURE === $expectedOutput) {
            return;
        } else {
            throw $e;
        }
    }

    // compare objects using "==", not "==="
    // print(gettype($out) . "\n");
    if ((gettype($out) === "object") && (gettype($expectedOutput) === "object")) {
        if (!assert($expectedOutput == $out)) {
            $expectedOutputJson = json_encode($expectedOutput);
            $outJson = json_encode($out);
            throw new Error("Expected object output not achieved :: expected :: $expectedOutputJson :: out :: $outJson");
        }
    } else if (!assert($expectedOutput === $out)) {
        $expectedOutputJson = json_encode($expectedOutput);
        $outJson = json_encode($out);
        throw new Error("Expected output not achieved :: expected :: $expectedOutputJson :: out :: $outJson");
    }
}
