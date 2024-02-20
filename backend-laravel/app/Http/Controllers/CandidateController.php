<?php

namespace App\Http\Controllers;

use App\Models\Candidate;


// Endpoint untuk testing
class CandidateController extends Controller
{
    public function get($id)
    {
        try {
            $candidate = Candidate::findOrFail($id);
            if (empty($candidate))
                return response()->json(['status' => 'error', 'message' => "candidate dengan id $id tidak ditemukan."], 404);

            return response()->json(['status' => 'success', 'candidate' => $candidate], 201);
        } catch (\Exception $e) {
            \Log::error('Exception caught: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan pada server', 'error' => $e->getMessage()], 500);
        }
    }

    // Softdelete
    public function delete($id)
    {
        try {
            $candidate = Candidate::findOrFail($id);
            $candidate->delete();

            return response()->json(['status' => 'success', 'message' => "Kandidat dengan id $id berhasil dihapus."], 201);
        } catch (\Exception $e) {
            \Log::error('Exception caught: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan pada server', 'error' => $e->getMessage()], 500);
        }
    }
}
