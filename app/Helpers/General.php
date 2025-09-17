<?php

if (!function_exists('settings')) {
    function settings($key)
    {
        $settings = app('settings');

        return $settings[$key] ?? $key;
    }
}
