<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfiles');
    } 
}
