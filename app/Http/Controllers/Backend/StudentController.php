<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $roles = DB::select("select * from roles");
        $students = DB::select("select * from users where role_id = 2 LIMIT 50");
        foreach ($students as $key => $student) {
            $student->created_at = date('Y-m-d h:i A', strtotime($student->created_at));
        }

        return view('backend/students/index', compact('roles', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'student_id' => 'required|integer|digits_between:6,6',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'email', 'password', 'student_id');
            $data['password']   = bcrypt($data['password']);
            $data['role_id']    = 2;

            $user = DB::insert(
                'insert into users (name, email, password, student_id, role_id, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?)',
                [
                    $data['name'],
                    $data['email'],
                    $data['password'],
                    $data['student_id'],
                    $data['role_id'],
                    now(),
                    now()
                ]
            );

            DB::commit();
            return back()->with('success', 'Student added!');
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return back()->with('success', 'Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'student_id' => 'required|integer|digits_between:6,6',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'email', 'student_id');

            $user = DB::update(
                'update users set name = ?, email = ?, student_id = ?, updated_at = ? where id = ?',
                [
                    $data['name'],
                    $data['email'],
                    $data['student_id'],
                    now(),
                    $id,
                ]
            );

            DB::commit();
            return back()->with('success', 'Student updated!');
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return back()->with('success', 'Something went wrong.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::delete('delete from users where id = ? ', [$id]);

            DB::commit();
            return back()->with('success', 'Student deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('danger', 'Something went wrong.');
        }
    }
}
