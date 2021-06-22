<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = $request->perPage;
        $query = Employee::withCount('payrolls');

        if ($request->has('filter')) {
            $filters = $request->filter;
            // Get fields
            if (array_key_exists('document', $filters)) {
                $query->whereLike('document', $filters['document']);
            }
            if (array_key_exists('name', $filters)) {
                $query->whereLike('name', $filters['name']);
            }
            if (array_key_exists('surname', $filters)) {
                $query->whereLike('surname', $filters['surname']);
            }
            if (array_key_exists('chargue', $filters)) {
                $query->whereLike('chargue', $filters['chargue']);
            }
            if (array_key_exists('division', $filters)) {
                $query->whereLike('division', $filters['division']);
            }
        }

        return $query->paginate($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    public function importEmployees(Request $request)
    {
        $file = $request->file;

        Excel::import(new EmployeesImport, $file);

        return response()->json([
            'data' => 'Employees uploaded successfully.'
        ]);
    }

    public function downloadProof(Employee $employee)
    {
        $vars = ['employee'];
        $pdf = PDF::loadView('pdf.proof-of-work', compact(['employee']));

        return $pdf->stream('constancia.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
