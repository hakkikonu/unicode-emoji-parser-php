<?php

namespace UnicodeEmoji\Core;

/**
 * Utils
 *
 * @author Hakkı Konu <hakkikonu@gmail.com>
 */
class Utils
{
    /**
     * Slugify string
     *
     * @param mixed $text 
     * @param string $divider 
     * @return void
     * @source https://stackoverflow.com/a/2955878/1848929

     */
    public static function slugify(string $text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, $divider);
        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    /**
     * to camelCase
     *
     * @param string $string 
     * @return string
     * @author Hakkı Konu <hakkikonu@gmail.com>
     */
    public static function camelCase(string $string): string
    {
        $clean = str_replace(array(",", ":", ".", "&"), "", $string);
        $whiteSpaceForDash = str_replace("-", " ", $clean);
        return lcfirst(str_replace(" ", "", ucwords($whiteSpaceForDash)));
    }
}
