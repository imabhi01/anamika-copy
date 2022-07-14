<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function search(){

        $results = Employee::orderBy('firstname')
            ->when(request('q'), function($query) {
                $query->where('first_name', 'like', '%'.request('q').'%')
                    ->orWhere('last_name', 'like', '%'.request('q').'%')
                    ->orWhere('email', 'like', '%'.request('q').'%');
            })
            ->limit(6)->get();
            
        return response()
            ->json(['results' => $results]);
    }

    public function totalRows(){
        $results = Employee::latest()->paginate(request('total_rows'));
        return response()
            ->json(['results' => $results]);
    }

    public function liveSearch(){
        $results = Employee::latest()
            ->when(request('q'), function($query) {
                $query->where('first_name', 'like', '%'.request('q').'%')
                    ->orWhere('last_name', 'like', '%'.request('q').'%')
                    ->orWhere('email', 'like', '%'.request('q').'%');
            })->paginate(10);
        return response()
            ->json(['results' => $results]);
    }

    public function index(){
        $results = Employee::latest()->paginate(10);
        return response()
            ->json(['results' => $results]);
    }

    public function store(Request $request){

        $request->validate([
           'first_name' => 'required',
           'last_name' => 'required',
           'phone' => 'required|unique:employees|numeric',
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
        $employee = Employee::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:employees|numeric,'.$id,
            'address' => 'required|string',
            'image' => 'sometimes|mimes:jpg,jpeg,png|max:2048,'.$id,
            'salary' => 'required|numeric',
            'joining_date' => 'required|date',
        ]);
 
        $employee->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'salary' => $request['salary'],
            'joining_date' => $request['joining_date']
        ]);
        
        if($request->file('image')) {
            $file = $request->file('image');
            $employee->image = Storage::put('public/uploads/employee',$request->file('image'));
            $employee->save();
        }

        return response()
            ->json(['saved' => true, 'id' => $employee->id, 'status' => 200]);

    }

    public function show($id){
        $model = Employee::findOrFail($id);
        return response()->json(['model' => $model]);
    }

    public function destroy($id){
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()
            ->json(['deleted' => true]);
    }
}