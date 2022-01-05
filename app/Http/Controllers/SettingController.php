<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function first(){
        return response()
        ->json(['results' => Setting::first()]);
    }

    public function index(){
        $results = Setting::latest()->paginate(10);
        return response()
            ->json(['results' => $results]);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string',
            'description' => 'sometimes'
        ]);
 
        $setting = Setting::create($request->all());
 
        return response()
            ->json([
                'saved' => true,
                'result' => $setting,
                'status' => 200
            ]);
    }

    public function show($id){
        $model = Setting::findOrFail($id);
        return response()->json(['model' => $model]);
    }

    public function update(Request $request, $id){

        $setting = Setting::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string',
            'description' => 'sometimes'
        ]);
 
        $setting->update($request->all());

        return response()
            ->json(['saved' => true, 'id' => $setting->id, 'status' => 200]);

    }
    
    public function destroy(){
        //
    }
}
