<?php

namespace App\Providers;

use App\Http\View\Composers\NavigationComposer;
use App\Http\View\Composers\SidebarComposer;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        # Composers
        View::composer('layouts.navigation', NavigationComposer::class);
        View::composer('layouts.sidebar',    SidebarComposer::class);

        # Macros (Para consultas reutilizables)
        Builder::macro('where_full_text', function (array $columns, string $search) {
            $boolean = collect(explode(' ', trim($search)))
                ->filter()
                ->map(fn($word) => $word . '*')
                ->implode(' ');

            $cols = implode(', ', $columns);

            return $this->whereRaw(
                "MATCH({$cols}) AGAINST(? IN BOOLEAN MODE)",
                [$boolean]
            );
        });
    }
}
