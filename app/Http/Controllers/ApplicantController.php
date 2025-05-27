<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Job;
use App\Models\Applicant;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{

    
    // Save new applicant
    public function store(Request $request, Job $job): RedirectResponse {

        // Check if user has already submitted an application to this job
        // Find record of job in database, check if current user is already linked to record
        $existingApplication = Applicant::where('job_id', $job->id)
                                        ->where('user_id',auth()->id())
                                        ->exists();


        // If application exists with current user, return with error

        if($existingApplication) {

            return redirect()->back()->with('error', 'You have already applied to this job');
        }

        // Else, validate data

        $validatedData = $request->validate([
            'full_name'=> 'required|string',
            'contact_phone'=> 'string',
            'email'=> 'required|string|email',
            'message'=> 'string',
            'location'=> 'string',
            'resume'=>'file|mimes:pdf|max:2048'
        ]);


        // Store resume and save path in database

            if($request->hasFile('resume')) {

                

                $path = $request->file('resume')->store('resumes', 'public');

                
                $validatedData['resume_path'] = $path;
            }

        // Create new Application record, move data, link foreign keys, save

       $application = new Applicant($validatedData);
       $application->job_id = $job->id;
       $application->user_id = auth()->id();
       $application->save();

        // Return with "success' 

        return redirect()->back()->with('success', 'Your application has been submitted');
    }

    // Destory Applicant
    public function destroy($id): RedirectResponse {

        // Find record
        $applicant =Applicant::findOrFail($id);
        //Delete resume
        Storage::delete('public/' . $applicant->resume_path);
        //Delete record
        $applicant->delete();

       
        // Return with "success"
        return redirect(route('dashboard'))->with('success', 'Applicant deleted');
    }
}
