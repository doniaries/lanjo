<?php

if (!function_exists('format_rupiah')) {
    /**
     * Format angka menjadi format uang Rupiah
     * Contoh: 10000 -> Rp. 10.000,-
     *
     * @param float|int $nominal
     * @param bool $withPrefix
     * @param bool $withSuffix
     * @return string
     */
    function format_rupiah($nominal, $withPrefix = true, $withSuffix = true)
    {
        $result = number_format((float) $nominal, 0, ',', '.');
        
        if ($withPrefix) {
            $result = 'Rp. ' . $result;
        }
        
        if ($withSuffix) {
            $result .= ',-';
        }

        return $result;
    }
}
