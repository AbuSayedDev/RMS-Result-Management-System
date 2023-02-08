<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;

class ExamController extends Controller
{
    public function index()
    {
        $seasons = DB::select("select * from seasons");
        $exams = DB::select("select `exams`.*, `seasons`.`name` as `season_name`, `seasons`.`year` as `season_year` from `exams` inner join `seasons` on `exams`.`season_id` = `seasons`.`id`");

        return view('backend/exams/index', compact('exams', 'seasons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'season_id' => 'required|exists:seasons,id',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'season_id');

            $user = DB::insert(
                            'insert into exams (name, season_id, created_at, updated_at) values (?, ?, ?, ?)',
                            [
                                $data['name'],
                                $data['season_id'],
                                now(),
                                now()
                            ]);

            DB::commit();
            return back()->with('success', 'Exam added!');
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
            'season_id' => 'required|exists:seasons,id',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'season_id');

            $user = DB::update(
                'update exams set name = ?, season_id = ?, updated_at = ? where id = ?',
                [
                    $data['name'],
                    $data['season_id'],
                    now(),
                    $id,
                ]);

            DB::commit();
            return back()->with('success', 'Exam updated!');
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
            DB::delete('delete from exams where id = ? ', [$id]);

            DB::commit();
            return back()->with('success', 'Exam deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('danger', 'Something went wrong.');
        }
    }
}