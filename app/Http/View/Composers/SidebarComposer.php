<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view): void
    {
        $view->with('modules', $this->resolverModulos());
    }

    private function resolverModulos(): \Illuminate\Support\Collection
    {
        $user = Auth::user();

        // Sin usuario autenticado → sin módulos
        if (!$user) {
            return collect();
        }

        // Si el usuario tiene un perfil asignado, usamos su método helper
        if ($user->perfil) {
            return $user->perfil->modulosParaSidebar();
        }

        // Fallback: sin perfil → sin módulos
        return collect();
    }
}