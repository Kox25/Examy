<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\SubjectResource;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Get All Employees
    public function index()
    {
        return EmployeeResource::collection(Employee::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    //Create new Employee
    public function store(StoreEmployeeRequest $request)
    {
        //dd($request->name);
        $create_employee = Employee::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
            'type' => $request->type
        ]);

        return new EmployeeResource($create_employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    //Get Employee By Id
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    //Update Employee Data
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    //Delete Employee
    public function destroy($id)
    {
        $found = Employee::where('id', $id)->first();
        $found ? null : abort(404, "Cant't found any User matches your search !!");
        $found->delete();
        return new EmployeeResource($found);
    }

    //Get All Employees By Type
    public function getEmployeesByType($type)
    {
        //dd($type);
        return EmployeeResource::collection(Employee::where('type', $type)->get());
    }

    //Get Employee Subjects
    public function getEmployeeSubjects($empId)
    {
        // dd($empId);
        $employee = Employee::find($empId);
        // dd($employee->name);
        $employee ? null : abort(404, "Cant't found any User matches your search !!");

        $employee_subjects = $employee->subjects;
        // $employee_subjects ? null : abort(404, "Cant't found any User matches your search !!");

        return SubjectResource::collection($employee_subjects);
    }

    //Add Subject to Employee
    public function addEmployeeSubject(Request $request)
    {
        // dd((int)$request->empId);
        // dd((int)$request->subId);
        $employee = Employee::find((int)$request->empId); //any user we want to find
        // dd($employee->email);
        $employee ? null : abort(404, "Cant't found any User matches your search !!");

        $employee->subjects()->attach((int)$request->subId); //pass id or array of a Subject ids

        return [
            'data' => [
                'empId' => (int)$request->empId,
                'subId' => (int)$request->subId
            ]
        ];
    }
}
