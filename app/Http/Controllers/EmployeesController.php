<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class EmployeesController extends Controller
{
    public function hr_dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'employee')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('users.hr.dashboard');
    }

    public function employee_dashboard()
    {
        $data = Auth::user();
        return view('users.employees.dashboard')->with('data', $data);
    }

    public function new_employee(Request $request)
    {
        $_userModel = User::where('email', $request->email)->first();

        if (!empty($request->id)) {
            $_dataArray = array(
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'is_active' => isset($request->employee_is_active) ? 1 : 0,
                'job_title' => $request->job_title,
                'updated_at' => date("Y-m-d H:i:s")
            );
            User::where('id', $request->id)->update($_dataArray);
            $request->session()->flash('edit_user_status', 'User has been updated successfully');
            $_action = 'update';
        } else {
            if ($_userModel == null) {
                $_dataArray = array(
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'is_active' => isset($request->employee_is_active) ? 1 : 0,
                    'job_title' => $request->job_title,
                    'password' => Hash::make($request->password),
                    'created_at' => date("Y-m-d H:i:s")
                );
                User::insert($_dataArray);
                $_action = 'add';
            } else {
                return response()->json(array(
                    'result' => false
                ));
            }
        }
        return response()->json(array(
            'action' => $_action,
            'result' => true
        ));
    }
    public function get_employee($id)
    {
        $_userModel = User::where('id', $id)->first();
        return response()->json($_userModel);
    }

    public function del_employee($id)
    {
        try {
            User::where('id', $id)->delete();
            return response()->json(array(
                'result' => true,
                'message' => 'Employee has been deleted successfully'
            ));
        } catch (Exception $e) {
            return response()->json(array(
                'result' => false,
                'message' => 'Ops! something went wrong!'
            ));
        }
    }
}
