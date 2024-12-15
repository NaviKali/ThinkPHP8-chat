<?php

namespace app;

/**
 * Return Message Code
 * * if you need it , you can change update it.
 */

return [
    /**
     * Code:Data
     */
    "Request" => [
        200 => "Request Success!",
        444 => "Request Warning!",
        500 => "Request Error!",
    ],
    /**
     * Code:Void(Name)
     */
    "Socket" => [
        11001=>"getChatData",
        11002=>"SendChat",
        11003=>"getUserList",
    ],
];