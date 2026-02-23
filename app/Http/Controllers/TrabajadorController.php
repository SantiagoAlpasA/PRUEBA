<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trabajadors;

class TrabajadorController extends Controller
{
    
    public function index()
    {
        $workers = Trabajadors::all(); 
        return view('home', compact('workers')); 
    }

    
    public function store(Request $request)
    {
        
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'dni' => 'required|numeric|digits:8|unique:trabajadors,dni',
            'fecha_nacimiento' => 'required|date|before:today',
            'sexo' => 'required|string',
            'cantidad_hijos' => 'required|numeric|min:0',
            'sueldo_base' => 'required|numeric|min:0',
            'area' => 'required|string',
            'cargo' => 'required|string',
            'fecha_ingreso' => 'required|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        
        $sueldo_base = $request->sueldo_base;
        $asignacion_familiar = ($request->cantidad_hijos > 0) ? 102.50 : 0;
        $sueldo_bruto = $sueldo_base + $asignacion_familiar;

        
        $afp_obligatoria = $sueldo_bruto * 0.10;  
        $afp_comision = $sueldo_bruto * 0.025;    
        $renta_5ta = $sueldo_bruto * 0.10;        
        $eps = 100.00;                            

        $sueldo_neto = $sueldo_bruto - ($afp_obligatoria + $afp_comision + $renta_5ta + $eps);

        
        $rutaFoto = $request->hasFile('foto') ? $request->file('foto')->store('fotos', 'public') : null;

        
        Trabajadors::create([
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'dni' => $request->dni,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
            'cantidad_hijos' => $request->cantidad_hijos,
            'area' => $request->area,
            'cargo' => $request->cargo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'sueldo_base' => $sueldo_base,
            'asignacion_familiar' => $asignacion_familiar,
            'sueldo_bruto' => $sueldo_bruto,
            'descuento_afp_obligatoria' => $afp_obligatoria,
            'descuento_afp_comision' => $afp_comision,
            'descuento_renta_5ta' => $renta_5ta,
            'descuento_eps' => $eps,
            'sueldo_neto' => $sueldo_neto,
            'foto' => $rutaFoto,
        ]);

        return redirect()->route('home')->with('success', 'Colaborador agregado y sueldo calculado.');
    }
}