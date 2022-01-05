<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function search(){
        $results = User::orderBy('firstname')
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
        $results = User::latest()->paginate(request('total_rows'));
        return response()
            ->json(['results' => $results]);
    }

    public function liveSearch(){
        $results = User::latest()
            ->when(request('q'), function($query) {
                $query->where('first_name', 'like', '%'.request('q').'%')
                    ->orWhere('last_name', 'like', '%'.request('q').'%')
                    ->orWhere('email', 'like', '%'.request('q').'%');
            })->paginate(10);

        return response()
            ->json(['results' => $results]);
    }

    public function index(){
        $results = User::latest()->paginate(10);
        return response()
            ->json(['results' => $results]);
    }

    public function store(Request $request){

        $request->validate([
           'first_name' => 'required',
           'last_name' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'required|string|min:8|confirmed',
           'image' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
        ]);

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        if($request->file('image')) {
            $file = $request->file('image');
            $user->image = Storage::put('public/uploads/user',$request->file('image'));
            $user->save();
        }

        return response()
            ->json([
                'saved' => true,
                'result' => $user,
                'status' => 200
            ]);
    }

    public function edit($id)
    {
        $form = User::findOrFail($id);
        return response()
            ->json(['form' => $form]);
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

    public function show($id){
        $model = User::findOrFail($id);
        return response()->json(['model' => $model]);
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()
            ->json(['deleted' => true]);
    }
}
