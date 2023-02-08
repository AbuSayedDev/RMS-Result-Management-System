<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;

class SubjectController extends Controller
{
    public function index()
    {
        $batches = DB::select("select * from batches");
        $subjects = DB::select("select `subjects`.*, `batches`.`name` as `batch_name` from `subjects` inner join `batches` on `subjects`.`batch_id` = `batches`.`id`");

        return view('backend/subjects/index', compact('subjects', 'batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'batch_id'  => 'required|exists:batches,id',
            'mark'      => 'required|int',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'batch_id', 'mark');

            $user = DB::insert(
                            'insert into subjects (name, batch_id, mark, created_at, updated_at) values (?, ?, ?, ?, ?)',
                            [
                                $data['name'],
                                $data['batch_id'],
                                $data['mark'],
                                now(),
                                now()
                            ]);

            DB::commit();
            return back()->with('success', 'Subject added!');
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return back()->with('success', 'Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required',
            'batch_id'  => 'required|exists:seasons,id',
            'mark'      => 'required|int',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'batch_id', 'mark');

            $user = DB::update(
                'update subjects set name = ?, batch_id = ?, mark = ?, updated_at = ? where id = ?',
                [
                    $data['name'],
                    $data['batch_id'],
                    $data['mark'],
                    now(),
                    $id,
                ]);

            DB::commit();
            return back()->with('success', 'Subject updated!');
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
            DB::delete('delete from subjects where id = ? ', [$id]);

            DB::commit();
            return back()->with('success', 'Subject deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('danger', 'Something went wrong.');
        }
    }
}