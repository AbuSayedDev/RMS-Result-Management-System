<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;

class TeacherController extends Controller
{
    public function index()
    {
        $roles = DB::select("select * from roles");
        $teachers = DB::select("select * from users where role_id = 3 LIMIT 50");
        foreach ($teachers as $key => $teacher) {
            $teacher->created_at = date('Y-m-d h:i A', strtotime($teacher->created_at));
        }

        return view('backend/teachers/index', compact('roles', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'email', 'password');
            $data['password']   = bcrypt($data['password']);
            $data['role_id']    = 3;

            $user = DB::insert(
                            'insert into users (name, email, password, role_id, created_at, updated_at) values (?, ?, ?, ?, ?, ?)',
                            [
                                $data['name'],
                                $data['email'],
                                $data['password'],
                                $data['role_id'],
                                now(),
                                now()
                            ]);

            DB::commit();
            return back()->with('success', 'Teacher added!');
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
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'email');

            $user = DB::update(
                'update users set name = ?, email = ?, updated_at = ? where id = ?',
                [
                    $data['name'],
                    $data['email'],
                    now(),
                    $id,
                ]);

            DB::commit();
            return back()->with('success', 'Teacher updated!');
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
            return back()->with('success', 'Teacher deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('danger', 'Something went wrong.');
        }
    }
}