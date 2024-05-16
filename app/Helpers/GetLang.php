<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class GetLang
{
    public static function locale($name)
    {
        return trans($name, [], session()->get('locale'));
    }

    public static function getLang(): string
    {
        $lang = strtoupper(substr(session()->get('locale'), '0', '1'));
        $defaultLange = strtoupper(substr(App::getLocale(),0,1));
        return $lang !== "" ? $lang : strtoupper($defaultLange);
    }

    public static function getLangCode(): string
    {
        $lang = strtolower(substr(session()->get('locale'), 0, 2));
        $defaultLange = strtolower(substr(App::getLocale(),0,2));
        return $lang !== "" ? $lang : strtolower($defaultLange);
    }
}
