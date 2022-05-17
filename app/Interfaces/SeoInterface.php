<?php

namespace App\Interfaces;

interface SeoInterface{

    public static function getMetaTitle($parameter);
    public static function getMetaDescription($parameter);
    public static function getMetaKeywords($parameter);
    public static function getCanonical($parameter);

}
