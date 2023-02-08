<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;

class SeasonController extends Controller
{
    public function index()
    {
        $seasons = DB::select("select * from seasons");

        return view('backend/seasons/index', compact('seasons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'year' => 'required|date_format:Y',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'year');

            $user = DB::insert(
                            'insert into seasons (name, year, created_at, updated_at) values (?, ?, ?, ?)',
                            [
                                $data['name'],
                                $data['year'],
                                now(),
                                now()
                            ]);

            DB::commit();
            return back()->with('success', 'Season added!');
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
            'year' => 'required|date_format:Y',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('name', 'year');

            $user = DB::update(
                'update seasons set name = ?, year = ?, updated_at = ? where id = ?',
                [
                    $data['name'],
                    $data['year'],
                    now(),
                    $id,
                ]);

            DB::commit();
            return back()->with('success', 'Season updated!');
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
            DB::delete('delete from seasons where id = ? ', [$id]);

            DB::commit();
            return back()->with('success', 'Season deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('danger', 'Something went wrong.');
        }
    }
}