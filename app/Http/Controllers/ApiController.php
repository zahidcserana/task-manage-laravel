<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected function resourceAbilityMap()
    {
        $resourceAbilityMap = parent::resourceAbilityMap();

        return $resourceAbilityMap;
    }

    protected function resourceMethodsWithoutModels()
    {
        $methods = parent::resourceMethodsWithoutModels();

        $methods = array_merge($methods, ['update', 'destroy']);

        return $methods;
    }
}
