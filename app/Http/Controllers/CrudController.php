<?php

namespace App\Http\Controllers;

use App\Models\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CrudController extends Controller
{
    public function showData()
    {
        $showData = Crud::simplePaginate(5);
        return view('show_data', compact('showData'));
    }

    public function addData()
    {
        return view('add_data');
    }
    public function storeData(Request $request)
    {
        $rules = [
            'name' => 'required|max:20',
            'email' => 'required|email',
        ];

        $messages = [
            'name.required' => 'Input your name',
            'name.max' => 'not greater than 20 character',
            'email.required' => 'Enter your email',
            'email.email' => 'please enter valid email address'
        ];
        $this->validate($request, $rules, $messages);

        $crud = new Crud();
        $crud->name = $request->name;
        $crud->email = $request->email;
        $crud->save();

        Session::flash('msg', 'Data added successfully');



        return redirect('/');
    }
    public function editData($id = null)
    {
        $editData = Crud::find($id);
        return view('edit_data', compact('editData'));
    }
    public function updateData(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:20',
            'email' => 'required|email',
        ];

        $messages = [
            'name.required' => 'Input your name',
            'name.max' => 'not greater than 20 character',
            'email.required' => 'Enter your email',
            'email.email' => 'please enter valid email address'
        ];
        $this->validate($request, $rules, $messages);

        $crud =  Crud::find($id);
        $crud->name = $request->name;
        $crud->email = $request->email;
        $crud->save();

        Session::flash('msg', 'Data updated successfully');
        return redirect('/');
    }

    public function deleteData($id = null)
    {
        $deleteData = Crud::find($id);
        $deleteData->delete();
        Session::flash('msg', 'Data deleted successfully');
        return redirect('/');
    }
}
