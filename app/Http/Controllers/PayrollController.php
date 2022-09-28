<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\NepaliDateConverter;
use App\Models\Payroll;

class PayrollController extends Controller
{
    use NepaliDateConverter;

    public function getPayrollDate(){
        $date = $this->get_nepali_date(date('Y'), date('m'), date('d'));
        $todayNepaliDate = $date['y']. '-'.$date['m'] . '-'.$date['d']; 
        return response()->json(['date' => $todayNepaliDate]);
    }

    public function getPayrollHistory($id){
        $payrolls = Payroll::where('employee_id', $id)->with('employee')->paginate(10);

        return response()->json(['results' => $payrolls]);
    }

    public function saveRecord(Request $request, $id){
        $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'bonus' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'status'
        ]);

        $payroll = Payroll::create([
            'employee_id' => $request['employee_id'],
            'salary' => $request['salary'],
            'bonus' => $request['bonus'],
            'date' => $request['date'],
            'status' => $request['status']
        ]);

        return response()
            ->json(['saved' => true, 'model' => $payroll, 'status' => 200]);
    }

    public function update(Request $request, $id){

        $payroll = Payroll::findOrFail($id);

        $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'bonus' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required'
        ]);

        $payroll->update([
            'employee_id' => $request['employee_id'],
            'salary' => $request['salary'],
            'bonus' => $request['bonus'],
            'date' => $request['date'],
            'status' => $request['status']
        ]);

        return response()
            ->json(['saved' => true, 'model' => $payroll, 'status' => 200]);
    }

    public function search(){
        $results = Payroll::orderBy('firstname')
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
        $results = Payroll::latest()->paginate(request('total_rows'));
        return response()
            ->json(['results' => $results]);
    }

    public function liveSearch(){
        $results = Payroll::latest()
            ->when(request('q'), function($query) {
                $query->where('first_name', 'like', '%'.request('q').'%')
                    ->orWhere('last_name', 'like', '%'.request('q').'%')
                    ->orWhere('email', 'like', '%'.request('q').'%');
            })->paginate(10);
        return response()
            ->json(['results' => $results]);
    }

    
    public function show($id){
        $model = Payroll::with('employee')->findOrFail($id);
        return response()->json(['model' => $model]);
    }

    public function destroy($id){
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        return response()
            ->json(['deleted' => true]);
    }
}
