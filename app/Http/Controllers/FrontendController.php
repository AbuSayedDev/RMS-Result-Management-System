<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use DB;

class FrontendController extends Controller
{
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'bail|required',
            'new_password' => 'bail|required|min:6'
        ]);

        $admin = auth()->user();
        if (Hash::check($request->old_password, $admin->password)) {
            $admin->update([
                'password' => Hash::make($request->new_password),
                'updated_at' => now(),
            ]);
            return back()->with('success', 'Password updated successfully!');
        }
        else {
            return back()->withInput($request->all())->with('danger', 'Old Password is incorrect');
        }
    }

    public function index()
    {
        if (auth()->user()->role_id == 1) {
            return redirect()->route('admin_index');
        }

        return view('frontend/index');
    }

    public function exam($student_id = null)
    {
        $student_id = $student_id ?? auth()->user()->id;

        // $exams = DB::table('exams')->latest()->get();

        // foreach ($exams as $key => $exam) {
        //     $exam->results = DB::table('results')
        //                     ->where('results.exam_id', $exam->id)
        //                     ->where('results.student_id', $student_id)
        //                     ->join('users', 'users.id', 'results.student_id')
        //                     ->join('subjects', 'results.subject_id', 'subjects.id')
        //                     ->select('results.*', 'subjects.name as subject_name', 'subjects.mark as full_mark')
        //                     ->get();
        //     $result_count = 0;
        //     $total_gpa = 0;
        //     foreach ($exam->results as $key => $result) {
        //         $result->grade = $this->calculateGrade($result->mark, $result->full_mark);
        //         $result_count += 1;
        //         $total_gpa += $result->grade;
        //     }
        //     $exam->gpa = number_format($total_gpa / $result_count, 2);
        // }


        $exams = DB::select('select * from exams order by created_at desc');

        foreach ($exams as $key => $exam) {
            $exam->results = DB::select("select `results`.*, `subjects`.`name` as `subject_name`, `subjects`.`mark` as `full_mark` from `results` inner join `users` on `users`.`id` = `results`.`student_id` inner join `subjects` on `results`.`subject_id` = `subjects`.`id` where `results`.`exam_id` = ? and `results`.`student_id` = ?", [$exam->id, $student_id]);
            $result_count = 0;
            $total_gpa = 0;
            $exam->gpa = 0.00;
            if(count($exam->results)) {
                foreach ($exam->results as $key => $result) {
                    $result->grade = $this->calculateGrade($result->mark, $result->full_mark);
                    $result_count += 1;
                    $total_gpa += $result->grade;
                }
                $exam->gpa = number_format($total_gpa / $result_count, 2);
            }
        }

        return view('frontend/exam', compact('exams'));
    }
}