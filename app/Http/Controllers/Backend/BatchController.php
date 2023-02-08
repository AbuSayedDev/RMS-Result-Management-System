<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;

class BatchController extends Controller
{
    public function index()
    {
        $seasons = DB::select("select * from seasons");
        $batches = DB::select("select `batches`.*, `seasons`.`name` as `season_name`, `seasons`.`year` as `season_year` from `batches` inner join `seasons` on `batches`.`season_id` = `seasons`.`id`");

        return view('backend/batches/index', compact('batches', 'seasons'));
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
                            'insert into batches (name, season_id, created_at, updated_at) values (?, ?, ?, ?)',
                            [
                                $data['name'],
                                $data['season_id'],
                                now(),
                                now()
                            ]);

            DB::commit();
            return back()->with('success', 'Batch added!');
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
                'update batches set name = ?, season_id = ?, updated_at = ? where id = ?',
                [
                    $data['name'],
                    $data['season_id'],
                    now(),
                    $id,
                ]);

            DB::commit();
            return back()->with('success', 'Batch updated!');
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
            DB::delete('delete from batches where id = ? ', [$id]);

            DB::commit();
            return back()->with('success', 'Season deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('danger', 'Something went wrong.');
        }
    }
}