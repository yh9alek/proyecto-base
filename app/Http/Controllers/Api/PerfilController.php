<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerfilRequest;
use App\Http\Resources\PerfilCollection;
use App\Http\Resources\PerfilResource;
use App\Models\Modulo;
use App\Models\Perfil;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function index()
    {
        return new PerfilCollection(
            Perfil::all()
        );
    }
 
    public function store(PerfilRequest $request)
    {
        $data = $request->validated();
 
        $perfil   = Perfil::create([
            'nombre'       => $data['nombre'],
            'descripcion'  => $data['descripcion'] ?? null,
            'usuario_alta' => Auth::id(),
            'usuario_mod'  => null,
        ]);
 
        $perfilId = (int) DB::table('perfiles')->where('ulid', $perfil->ulid)->value('id');
 
        if (!empty($data['modulos']) && $perfilId) {
            $this->sincronizarModulos($perfilId, $data['modulos']);
        }
 
        return new PerfilResource($perfil);
    }
 
    public function show(string $perfil)
    {
        $row = DB::table('perfiles')->where('ulid', $perfil)->first();
        abort_if(!$row, 404);
 
        $modulosUlids = DB::table('perfiles_modulos')
            ->join('modulos', 'modulos.id', '=', 'perfiles_modulos.modulo_id')
            ->where('perfiles_modulos.perfil_id', $row->id)
            ->pluck('modulos.ulid');
 
        return (new PerfilResource(Perfil::find($row->id)))->additional([
            'modulos_asignados' => $modulosUlids,
        ]);
    }
 
    public function update(PerfilRequest $request, string $perfil)
    {
        $data = $request->validated();
 
        $row = DB::table('perfiles')->where('ulid', $perfil)->first();
        abort_if(!$row, 404);
 
        DB::table('perfiles')
            ->where('id', $row->id)
            ->update([
                ...Arr::only((array) $data, ['nombre', 'descripcion', 'estatus']),
                'usuario_mod' => Auth::id(),
                'updated_at'  => now(),
            ]);
 
        if (array_key_exists('modulos', $data)) {
            $this->sincronizarModulos($row->id, $data['modulos'] ?? []);
        }
 
        return new PerfilResource(Perfil::find($row->id));
    }
 
    public function destroy(string $perfil)
    {
        abort_if(
            Auth::user()->perfil->nombre !== 'Administrador',
            403,
            'No autorizado'
        );

        $row = DB::table('perfiles')->where('ulid', $perfil)->first();
        abort_if(!$row, 404);
 
        DB::table('perfiles_modulos')->where('perfil_id', $row->id)->delete();
        DB::table('perfiles')->where('id', $row->id)->delete();
 
        return response()->noContent();
    }
 
    /** Árbol completo sin selección — para el modal de creación */
    public function modulosArbolVacio()
    {
        return response()->json($this->construirArbol([]));
    }
 
    /** Árbol con selección — para el modal de edición */
    public function modulosArbol(string $perfil)
    {
        $row = DB::table('perfiles')->where('ulid', $perfil)->first();
        abort_if(!$row, 404);
 
        $asignados = DB::table('perfiles_modulos')
            ->join('modulos', 'modulos.id', '=', 'perfiles_modulos.modulo_id')
            ->where('perfiles_modulos.perfil_id', $row->id)
            ->pluck('modulos.ulid')
            ->toArray();
 
        return response()->json($this->construirArbol($asignados));
    }
 
    // ── Helpers ───────────────────────────────────────────────────────────────
 
    private function construirArbol(array $asignados): array
    {
        return Modulo::whereNull('modulo_raiz_id')
            ->with(['children' => fn($q) => $q->orderBy('orden')])
            ->orderBy('orden')
            ->get()
            ->map(fn($raiz) => [
                'id'       => $raiz->ulid,
                'text'     => $raiz->nombre,
                'state'    => ['selected' => in_array($raiz->ulid, $asignados)],
                'children' => $raiz->children->map(fn($hijo) => [
                    'id'    => $hijo->ulid,
                    'text'  => $hijo->nombre,
                    'state' => ['selected' => in_array($hijo->ulid, $asignados)],
                ])->values(),
            ])->values()->toArray();
    }
 
    private function sincronizarModulos(int $perfilId, array $ulidModulos): void
    {
        $moduloIds  = Modulo::whereIn('ulid', $ulidModulos)->pluck('id')->toArray();
        $now        = now();
        $existentes = DB::table('perfiles_modulos')
            ->where('perfil_id', $perfilId)
            ->pluck('modulo_id')
            ->toArray();
 
        foreach (array_diff($moduloIds, $existentes) as $moduloId) {
            DB::table('perfiles_modulos')->insert([
                'perfil_id'  => $perfilId,
                'modulo_id'  => $moduloId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
 
        $eliminar = array_diff($existentes, $moduloIds);
        if (!empty($eliminar)) {
            DB::table('perfiles_modulos')
                ->where('perfil_id', $perfilId)
                ->whereIn('modulo_id', $eliminar)
                ->delete();
        }
    }
}
