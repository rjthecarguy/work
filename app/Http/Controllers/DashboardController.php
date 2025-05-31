<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Applicant;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    // Index page of Dashboard
    public function index():View {
    
    // Get current user    
    $user = Auth::user();

    // Get records where current user ID matches jobs, also bring in applicants
    $jobs = Job::where('user_id', $user->id)->with('applicants')->get();
   
    
    $jobsApp =DB::table('applicants')
    ->join('job_listings', 'applicants.job_id', '=', 'job_listings.id')
    ->select('job_listings.title')
    ->where('applicants.user_id',$user->id)->get();

   
    

    // Retun view and pass in Jobs and Applicants for this user'
    return view('dashboard.index', compact('user', 'jobs'));

    } 
}
