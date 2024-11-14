<?php

if (! function_exists('responseStatusCode')) {
    function responseStatusCode($code): int
    {
        if (is_numeric($code) && $code !== 0) {
            return (int) $code;
        }
        return 500;
    }
}
