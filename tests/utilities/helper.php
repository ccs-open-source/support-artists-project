<?php

if(!function_exists('create')) {
    function create($model, $attributes = [], $times = null) {
        return factory($model, $times)->create($attributes);
    }
}


if(!function_exists('make')) {
    function make($model, $attributes = [], $times = null) {
        return factory($model, $times)->make($attributes);
    }
}
