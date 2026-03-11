<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FipeController extends Controller
{
    
    
    private $fipeBaseUrl = 'https://parallelum.com.br/fipe/api/v1';

    
    public function index()
    {
        
        $userRole = session('user_role');
        if (!in_array($userRole, ['mechanic', 'attendant', 'manager'])) {
            return redirect()->route('dashboard')->with('error', 'Acesso negado a esta área.');
        }

        return view('fipe.index');
    }

    
    
    public function getMarcas()
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['mechanic', 'attendant', 'manager'])) {
            
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        try {
            
            
            $response = Http::timeout(10)->get($this->fipeBaseUrl . '/carros/marcas');

            
            if ($response->successful()) {
                
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Erro ao consultar a API FIPE'], 500);
            }
        } catch (\Exception $e) {
            
            return response()->json(['error' => 'Não foi possível conectar à API FIPE: ' . $e->getMessage()], 500);
        }
    }

    
    public function getModelos($marcaId)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['mechanic', 'attendant', 'manager'])) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        
        if (!is_numeric($marcaId)) {
            return response()->json(['error' => 'ID de marca inválido'], 400);
        }

        try {
            $response = Http::timeout(10)->get($this->fipeBaseUrl . '/carros/marcas/' . $marcaId . '/modelos');

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Erro ao buscar modelos'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro de conexão: ' . $e->getMessage()], 500);
        }
    }

    
    public function getAnos($marcaId, $modeloId)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['mechanic', 'attendant', 'manager'])) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        
        if (!is_numeric($marcaId) || !is_numeric($modeloId)) {
            return response()->json(['error' => 'Parâmetros inválidos'], 400);
        }

        try {
            $url = $this->fipeBaseUrl . '/carros/marcas/' . $marcaId . '/modelos/' . $modeloId . '/anos';
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Erro ao buscar anos'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro de conexão: ' . $e->getMessage()], 500);
        }
    }

    
    public function getValor($marcaId, $modeloId, $ano)
    {
        $userRole = session('user_role');
        if (!in_array($userRole, ['mechanic', 'attendant', 'manager'])) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        if (!is_numeric($marcaId) || !is_numeric($modeloId)) {
            return response()->json(['error' => 'Parâmetros inválidos'], 400);
        }

        try {
            $url = $this->fipeBaseUrl . '/carros/marcas/' . $marcaId . '/modelos/' . $modeloId . '/anos/' . $ano;
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Erro ao buscar valor FIPE'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro de conexão: ' . $e->getMessage()], 500);
        }
    }
}
