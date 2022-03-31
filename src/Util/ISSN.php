<?php


namespace App\Util;


final class ISSN
{
    public static function format($issn)
    {
        if ('null' === $issn) return null;

        if (empty($issn)) return null;

        if (strlen($issn) === 9 && false !== strpos($issn, '-')) return $issn;

        if (strlen($issn) < 8) str_pad($issn, 8, '0');

        return substr($issn, 0, 4)."-".substr($issn, -4);
    }

    public static function isISSN(string $issn)
    {
        return (strlen($issn) === 9 && false !== strpos($issn, '-'));
    }
}
