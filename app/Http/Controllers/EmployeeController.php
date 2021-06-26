<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Yajra\Datatables\Datatables;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }


    public function getEmployees(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('users');
    }

    public function store(Request $request)
    {  
 
        $employeeId = $request->id;
 
        $employee   =   Employee::updateOrCreate(
                    [
                     'id' => $employeeId
                    ],
                    [
                    'name' => $request->name,
                    'designation' => $request->designation, 
                    'email' => $request->email,
                    'address' => $request->address,
                    'phone' => $request->phone
                    ]);    
                         
        return Response()->json($employee);
 
    }
      
      
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $employee  = Employee::where($where)->first();
      
        return Response()->json($employee);
    }
      
      
    public function destroy(Request $request)
    {
        $employee = Employee::where('id',$request->id)->delete();
      
        return Response()->json($employee);
    }
}
