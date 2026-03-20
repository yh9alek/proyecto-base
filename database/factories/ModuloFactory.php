<?php

namespace Database\Factories;

use App\Models\Modulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuloFactory extends Factory
{
    protected $model = Modulo::class;

    // Íconos de Material Symbols usados en el sidebar
    private static array $iconos = [
        'dashboard', 'settings', 'group', 'admin_panel_settings', 'policy',
        'tune', 'inventory_2', 'category', 'warehouse', 'input', 'output',
        'bar_chart', 'people', 'badge', 'corporate_fare', 'payments',
        'beach_access', 'event_available', 'account_balance', 'request_quote',
        'receipt_long', 'savings', 'money_off', 'attach_money', 'analytics',
        'point_of_sale', 'person', 'description', 'shopping_cart', 'receipt',
        'assignment_return', 'shopping_bag', 'local_shipping', 'add_shopping_cart',
        'move_to_inbox', 'undo', 'folder_special', 'work', 'task_alt',
        'calendar_month', 'engineering', 'trending_up', 'support_agent',
        'confirmation_number', 'menu_book', 'chat', 'poll', 'notifications',
        'summarize', 'insert_chart', 'download', 'schedule_send',
        'manage_accounts', 'help_outline',
    ];

    public function definition(): array
    {
        return [
            // ulid se genera automáticamente por HasPublicUlid
            'modulo_raiz_id' => null,
            'icono'          => $this->faker->randomElement(self::$iconos),
            'nombre'         => $this->faker->unique()->words(2, true),
            'descripcion'    => $this->faker->sentence(),
            'url'            => '/' . $this->faker->slug(2),
            'usuario_alta'   => 1,
            'usuario_mod'    => 1,
        ];
    }

    /** Estado: módulo hijo (requiere pasar modulo_raiz_id) */
    public function hijo(int $raizId): static
    {
        return $this->state(['modulo_raiz_id' => $raizId]);
    }
}