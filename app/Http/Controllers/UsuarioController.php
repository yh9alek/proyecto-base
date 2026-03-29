<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\Listable;
use App\Traits\Paginable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    use Paginable, Listable;
    
    protected $model = User::class;

    # -------------------------------------
}
