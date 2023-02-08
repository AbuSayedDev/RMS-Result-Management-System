<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function calculateGrade($mark, $full_mark)
    {
        $divider = number_format($full_mark / 10, 2);
        $grade = '0.00';

        switch ($mark && $full_mark && $divider) {
            case $mark >= ($full_mark * 80) / 100:
                $grade = '4.00';
                break;

            case $mark >= ($full_mark * 75) / 100 && $mark <= ($full_mark * 79) / 100:
                $grade = '3.75';
                break;

            case $mark >= ($full_mark * 70) / 100 && $mark <= ($full_mark * 74) / 100:
                $grade = '3.50';
                break;

            case $mark >= ($full_mark * 65) / 100 && $mark <= ($full_mark * 69) / 100:
                $grade = '3.25';
                break;

            case $mark >= ($full_mark * 60) / 100 && $mark <= ($full_mark * 64) / 100:
                $grade = '3.00';
                break;

            case $mark >= ($full_mark * 55) / 100 && $mark <= ($full_mark * 59) / 100:
                $grade = '2.75';
                break;

            case $mark >= ($full_mark * 50) / 100 && $mark <= ($full_mark * 54) / 100:
                $grade = '2.50';
                break;

            case $mark >= ($full_mark * 45) / 100 && $mark <= ($full_mark * 49) / 100:
                $grade = '2.25';
                break;

            case $mark >= ($full_mark * 40) / 100 && $mark <= ($full_mark * 44) / 100:
                $grade = '2.00';
                break;

            case $mark >= ($full_mark * 39) / 100:
                $grade = '0.00';
                break;

            default:
                $grade = '0.00';
                break;
        }

        return $grade;
    }
}