<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function store(Request $request){

        // dd($request->all());

        $request->validate([
           'first_name' => 'required',
           'last_name' => 'required',
           'phone' => 'required|unique:employees',
           'address' => 'required|string',
           'image' => 'sometimes|mimes:jpg,jpeg,png|max:2048',
           'salary' => 'required|numeric',
           'joining_date' => 'required|date',
        ]);

        $employee = Employee::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'salary' => $request['salary'],
            'joining_date' => $request['joining_date'],
        ]);

        if($request->file('image')) {
            $file = $request->file('image');
            $employee->image = Storage::put('public/uploads/employees',$request->file('image'));
            $employee->save();
        }

        return response()
            ->json([
                'saved' => true,
                'result' => $employee,
                'status' => 200
            ]);
    }

    public function update(Request $request, $id){
        dd($request->all());
        $user = User::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'string|min:8|confirmed',
            // 'image' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048,'.$id
        ]);
 
        $user->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => $request['password'] ? Hash::make($request['password']) : $user->password
        ]);
        
        if($request->file('image')) {
            $file = $request->file('image');
            $user->image = Storage::put('public/uploads/user',$request->file('image'));
            $user->save();
        }

        return response()
            ->json(['saved' => true, 'id' => $user->id, 'status' => 200]);

    }

}
