<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use app\Models\applicationModel;
use Illuminate\Support\Facades\Validator;

class CrudCOntroller extends Controller
{
    //
    public function index()
    {
        // $select = application::select();
        // // $query = DB::select("SELECT *
        // // FROM application");

        // // dd($query);


        $application = DB::table('application')
            ->get();

        // dd($application);

        return view('welcome', compact(['application']));
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'bday' => 'required',
            'phoneno' => 'required',
            'address' => 'required',
            'phoneno' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Required All Fields!'
            ]);
        } else {

            $query = DB::table('application')->insert([
                'first_name' => $request->fname,
                'middle_name' => $request->mname,
                'last_name' => $request->lname,
                'birthdate' => $request->bday,
                'gender' => $request->gender,
                'cellphone_no' => $request->phoneno,
                'address' => $request->address,
            ]);

            if ($query) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Application Added!'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Faild to Save!'
                ]);
            }
        }
    }

    public function select(Request $request)
    {
        $query = DB::table('application')
            ->where('id', $request->id)
            ->get();

        if ($query) {
            return response()->json([
                'status' => 200,
                'query' => $query
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Faild to Get Data!'
            ]);
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'bday' => 'required',
            'phoneno' => 'required',
            'address' => 'required',
            'phoneno' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => 'Required All Fields!'
            ]);
        } else {
            $query = DB::table('application')
                ->where('id', $request->id)
                ->update([
                    'first_name' => $request->fname,
                    'middle_name' => $request->mname,
                    'last_name' => $request->lname,
                    'birthdate' => $request->bday,
                    'gender' => $request->gender,
                    'cellphone_no' => $request->phoneno,
                    'address' => $request->address,
                ]);

            if ($query) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Update Succes!'
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Update ERROR!'
                ]);
            }
        }
    }

    public function delete(Request $request)
    {
        $query = DB::table('application')
            ->where('id', $request->id)
            ->delete();
        if ($query) {
            return response()->json([
                'status' => 200,
                'message' => 'Delete Succes!'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Delete ERROR!'
            ]);
        }
    }
}
