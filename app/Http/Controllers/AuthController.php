<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;
use App\Http\Resources\EmployeeResource;

class AuthController extends Controller
{

    //Login
    public function login(Request $request)
    {
        // dd($request->email);
        $employee = Employee::where('email', $request->email)->first();
        // dd($employee);
        $employee ? $employee : abort(422, 'wrong email or password !!');
        return new EmployeeResource($employee);
    }
}
