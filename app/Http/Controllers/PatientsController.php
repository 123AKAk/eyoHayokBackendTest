<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PatientsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'search', 'getByDateRange'])
        ];
    }

    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'card_no_id' => 'required|string|unique:patients',
                'email' => 'required|email|unique:patients',
                'phone_no' => 'required|string',
                'marital_status' => 'required|string',
                'date_of_birth' => 'required|date',
                'age' => 'required|integer',
                'nationality' => 'required|string',
                'country' => 'required|string',
                'city_town' => 'required|string',
                'address' => 'required|string',
                'next_of_kin_name' => 'required|string',
                'next_of_kin_phone_no' => 'required|string',
                'relationship' => 'required|string',
                'next_of_kin_email_address' => 'nullable|email',
                'next_of_kin_address' => 'required|string',
            ]);

            // $patient = Patients::create($request->all());
            $patient = $request->user()->patients()->create($request->all());

            return response()->json([
                'response' => true,
                'message' => "Patient Added Successfully",
                'data' => $patient,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->errors()
            ], 422);
        }
    }

    // Return all patient info
    public function index()
    {
        try
        {
            $patients = Patients::all();
            $totalPatients = $patients->count();

            return response()->json([
                'response' => true,
                'message' => "All Patient gotten Successfully",
                'total_patients' => $totalPatients,
                'data' => $patients->map(function ($patient) {
                    return [
                        'card_no_id' => $patient->card_no_id,
                        'name' => $patient->first_name . ' ' . $patient->last_name,
                        'email' => $patient->email,
                        'phone_no' => $patient->phone_no,
                        'marital_status' => $patient->marital_status,
                        'date_of_birth' => $patient->date_of_birth,
                        'address' => $patient->address,
                    ];
                })
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->errors()
            ], 422);
        }
    }

    // Search by card no or name
    public function search(Request $request)
    {
        try
        {
            $query = $request->query('q');
            $patients = Patients::where('card_no_id', 'like', "%$query%")
                ->orWhere('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%")
                ->get();

            return response()->json([
                'response' => true,
                'message' => "Patient gotten Successfully",
                'data' => $patients,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->errors()
            ], 422);
        }
    }

    // Get patients by date range
    public function getByDateRange(Request $request)
    {
        try
        {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);

            $patients = Patients::whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ])->get();

            return response()->json([
                'response' => true,
                'message' => "Patient gotten Successfully by Date Range",
                'data' => $patients,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->errors()
            ], 422);
        }
    }
}
