<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;

class ResultController extends Controller
{
    public function index()
    {
        $students = DB::select('select * from users where role_id = 2');
        $exams = DB::select("select * from exams");
        $subjects = DB::select("select * from subjects");

        // $results = DB::table('results')->leftJoin('users', 'results.student_id', 'users.id')->leftJoin('exams', 'results.exam_id', 'exams.id')->leftJoin('subjects', 'results.subject_id', 'subjects.id')->leftJoin('batches', 'subjects.batch_id', 'batches.id')->select('results.*', 'users.name as student_name', 'exams.name as exam_name', 'subjects.name as subject_name', 'batches.name as batch_name')->toSql();
        // dd($results);

        $results = DB::select("select `results`.*, `users`.`name` as `student_name`, `exams`.`name` as `exam_name`, `subjects`.`name` as `subject_name`, `batches`.`name` as `batch_name` from `results` left join `users` on `results`.`student_id` = `users`.`id` left join `exams` on `results`.`exam_id` = `exams`.`id` left join `subjects` on `results`.`subject_id` = `subjects`.`id` left join `batches` on `subjects`.`batch_id` = `batches`.`id`");

        return view('backend/results/index', compact('results', 'students', 'exams', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'    => 'required|exists:users,id',
            'exam_id'       => 'required|exists:exams,id',
            'subject_id'    => 'required|exists:subjects,id',
            'mark'          => 'required|int',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('student_id', 'exam_id', 'subject_id', 'mark');

            $user = DB::insert(
                            'insert into results (student_id, exam_id, subject_id, mark, created_at, updated_at) values (?, ?, ?, ?, ?, ?)',
                            [
                                $data['student_id'],
                                $data['exam_id'],
                                $data['subject_id'],
                                $data['mark'],
                                now(),
                                now()
                            ]);

            DB::commit();
            return back()->with('success', 'Result added!');
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return back()->with('success', 'Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id'    => 'required|exists:users,id',
            'exam_id'       => 'required|exists:exams,id',
            'subject_id'    => 'required|exists:subjects,id',
            'mark'          => 'required|int',
        ]);

        DB::beginTransaction();
        try {
            $data               = $request->only('student_id', 'exam_id', 'subject_id', 'mark');

            $user = DB::update(
                'update results set student_id = ?, exam_id = ?, subject_id = ?, mark = ?, updated_at = ? where id = ?',
                [
                    $data['student_id'],
                    $data['exam_id'],
                    $data['subject_id'],
                    $data['mark'],
                    now(),
                    $id,
                ]);

            DB::commit();
            return back()->with('success', 'Result updated!');
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
            DB::delete('delete from results where id = ? ', [$id]);

            DB::commit();
            return back()->with('success', 'Result deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('danger', 'Something went wrong.');
        }
    }
}