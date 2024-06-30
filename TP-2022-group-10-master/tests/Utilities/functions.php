<?php
//Reference: https://medium.com/@wanmigs/laravel-common-php-unit-testing-crud-made-easy-8bd8d20f5c92
/* tests\utilities\functions.php */
function create($class, $attributes = [], $times = null)
{
  return factory($class, $times)->create($attributes);
}
function make($class, $attributes = [], $times = null)
{
  return factory($class, $times)->make($attributes);
}
function raw($class, $attributes = [], $times = null)
{
  return factory($class, $times)->raw($attributes);
}