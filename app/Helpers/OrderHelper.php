<?php

namespace App\Helpers;


function kmpSearch($text, $pattern) {
    $n = strlen($text);
    $m = strlen($pattern);

    if ($m == 0) {
        return 0; // Pattern is empty, return 0
    }

    // Compute the LPS (Longest Prefix Suffix) array for the pattern
    $lps = computeLPSArray($pattern);

    $i = 0; // Index for text
    $j = 0; // Index for pattern

    while ($i < $n) {
        if ($pattern[$j] == $text[$i]) {
            $i++;
            $j++;
        }
        if ($j == $m) {
            return $i - $j; // Pattern found at index ($i - $j)
        } elseif ($i < $n && $pattern[$j] != $text[$i]) {
            if ($j != 0) {
                $j = $lps[$j - 1]; // Move j to the next best position using LPS array
            } else {
                $i++; // Move i to the next character
            }
        }
    }
    return -1; // Pattern not found in text
}

function computeLPSArray($pattern) {
    $m = strlen($pattern);
    $lps = array_fill(0, $m, 0);
    $len = 0; // Length of the previous longest prefix suffix

    $i = 1;
    while ($i < $m) {
        if ($pattern[$i] == $pattern[$len]) {
            $len++;
            $lps[$i] = $len;
            $i++;
        } else {
            if ($len != 0) {
                $len = $lps[$len - 1];
            } else {
                $lps[$i] = 0;
                $i++;
            }
        }
    }
    return $lps;
}
