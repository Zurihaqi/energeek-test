<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Candidate;
use App\Models\Job;
use App\Models\Skill;

use DB;

class FormController extends Controller
{

    // Endpoint ketika submit form
    public function post(Request $request)
    {
        DB::beginTransaction();

        try {
            $candidate = new Candidate();

            // Rule untuk validasi
            $rules = [
                'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email|unique:candidates,email',
                'phone' => 'required|unique:candidates,phone',
                'job_id' => 'required|integer|exists:jobs,id',
                'year' => 'required|integer',
                'skills' => 'required|array',
                'skills.*' => 'exists:skills,id|distinct',
            ];

            // Pesan saat gagal validasi
            $messages = [
                'name.required' => 'name required.',
                'email.required' => 'email required.',
                'phone.required' => 'phone required.',
                'job_id.required' => 'job_id required.',
                'year.required' => 'year required.',
                'skills.required' => 'skills required.',

                'name.regex' => 'nama tidak dapat mengandung angka atau simbol',
                'name.string' => 'name adalah string.',
                'email.email' => 'email tidak valid.',
                'job_id.integer' => 'job_id adalah integer.',
                'year.integer' => 'year adalah integer.',

                'email.unique' => 'email sudah terdaftar.',
                'phone.unique' => 'phone sudah terdaftar.',
                'skills.*.exists' => 'id skill tidak ada dalam database.',
                'job_id.exists' => 'job_id tidak ada dalam database.',

                'skills.*.distinct' => 'id skill tidak dapat duplikat.',

                'skills.array' => 'skills harus dikirim dalam bentuk array.',
            ];

            // Terima request dan data dari body lalu validasi
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                // Error handler untuk validator, kembalikan dalam bentuk json
                return response()->json(['status' => 'error', 'error' => $validator->errors()], 422);
            }

            $candidate->name = $request->input('name');
            $candidate->email = strtolower($request->input('email'));
            $candidate->phone = $request->input('phone');
            $candidate->year = $request->input('year');
            $candidate->job_id = $request->input('job_id');

            $candidate->save();

            $skillIds = $request->input('skills');
            // Kaitkan skill dengan candidate
            $candidate->skills()->sync($skillIds);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil menyimpan data kandidat.'], 201);

        } catch (\Exception $e) {
            // Rollback perubahan dalam db jika terjadi error
            DB::rollBack();

            // Buat error log
            \Log::error('Exception caught: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return error server dalam bentuk json
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan pada server', 'error' => $e->getMessage()], 500);
        }

    }

    // Endpoint untuk mengambil data untuk form seperti jobs dan skills
    public function get()
    {
        try {
            $jobs = Job::select('id', 'name')->get();
            $skills = Skill::select('id', 'name')->get();

            return response()->json(['jobs' => $jobs, 'skills' => $skills], 200);
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