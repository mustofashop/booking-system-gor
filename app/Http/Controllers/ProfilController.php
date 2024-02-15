<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function __invoke(Request $request)
    {
    }

    public function profil()
    {
        $page_title = 'Profil';
        $page_description = 'Ini adalah halaman profil';
        $action = __FUNCTION__;

        return view('layout.profil.welcome ', compact(
            'page_title',
            'page_description',
            'action'
        ));
    }
}
