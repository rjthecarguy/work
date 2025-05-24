<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Job;
use App\Models\Applicant;

class ApplicantController extends Controller
{

    

    public function store(Request $request, Job $job): RedirectResponse {

    

        $validatedData = $request->validate([
            'full_name'=> 'required|string',
            'contact_phone'=> 'string',
            'email'=> 'required|string|email',
            'message'=> 'string',
            'location'=> 'string',
            'resume'=>'file|mimes:pdf|max:2048'
        ]);



            if($request->hasFile('resume')) {

                

                $path = $request->file('resume')->store('resumes', 'public');

                
                $validatedData['resume_path'] = $path;
            }

       $application = new Applicant($validatedData);
       $application->job_id = $job->id;
       $application->user_id = auth()->id();
       $application->save();

        return redirect()->back()->with('success', 'Your application has been submitted');
    }
}
