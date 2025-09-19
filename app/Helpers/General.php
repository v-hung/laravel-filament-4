<?php

if (!function_exists('settings')) {
    function settings($key, $default = null)
    {
        if (!app()->bound('settings')) {
            // Nếu service 'settings' chưa tồn tại, trả về giá trị mặc định
            return $default ?? $key;
        }

        $settings = app('settings');

        return $settings[$key] ?? $key;
    }
}
