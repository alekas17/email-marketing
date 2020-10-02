<?php

if (!function_exists('apiValidate')) {
    /**
     * The attributes that are mass assignable.
     *
     * @var array $request
     * @var array $rule
     * @var array $message
     */
    function apiValidate($request, $rule = [], $message = [])
    {
        $validate = \Illuminate\Support\Facades\Validator::make(
            $request,
            $rule,
            $message
        )->validate();
    }

    /**
     * Array to url query.
     *
     * @var array $query
     */
    function buildHttpQuery($query)
    {
        $query_array = array();
        foreach ($query as $key => $key_value) {
            if ($key_value != "") {
                $query_array[] = urlencode($key) . '=' . urlencode($key_value);
            }
        }

        return implode('&', $query_array);
    }
}
