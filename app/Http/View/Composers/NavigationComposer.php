<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NavigationComposer {

    public function compose(View $view) {

        $user = Auth::user();

        $view->with([
            'nombre' => $user->name,
            'email'  => $user->email,
            'iniciales' => preg_filter('/[^A-Z]/', '', $user->name)
        ]);

    }

}