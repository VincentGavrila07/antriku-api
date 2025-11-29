<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Translations\LangEn;
use App\Translations\LangId;
use Illuminate\Http\Request;


class LocalizationController extends Controller
{
    public function getTranslations(Request $request)
    {
        $lang = $request->query('lang', 'en');

        $translations = match ($lang) {
            'id' => LangId::get(),
            'en' => LangEn::get(),
            default => LangEn::get(),
        };

        return response()->json($translations);
    }
}
