<?php

namespace App\Helper;

class CustomSanitize
{
    public static function sanitize($data) {
        // 1. Remove whitespace from beginning and end
        $data = trim($data);

        // 2. Remove backslashes
        $data = stripslashes($data);

        // 3. Remove HTML and PHP tags
        $data = strip_tags($data);

        // 4. Optionally remove non-UTF8 characters (for extra security)
        $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');

        return $data;
    }

}
