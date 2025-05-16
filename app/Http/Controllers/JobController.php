<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{

    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $jobs = Job::all();
        
        return view('jobs.index')->with('jobs', $jobs);
    } 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
    
       
        $validatedData = $request->validate([
            'title'=> 'required|string',
            'description'=> 'nullable|string',
            'salary'=> 'required|integer',
            'tags'=> 'nullable|string',
            'job_type'=> 'nullable|string',
            'remote'=> 'nullable|string',
            'requirements'=> 'nullable|string',
            'benefits'=> 'nullable|string',
            'address'=> 'nullable|string',
            'city'=> 'required|string',
            'state'=> 'required|string',
            'zipcode'=> 'nullable|string',
            'contact_email'=> 'required|string',
            'contact_phone'=> 'nullable|string',
            'company_name'=> 'required|string',
            'company_description'=> 'nullable|string',
            'company_logo'=> 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'company_website'=> 'nullable|string'
           
        ]);


        $validatedData['user_id'] = auth()->user()->id;
      
        if($request->hasFile('company_logo')) {

            $path=$request->file('company_logo')->store('logos','public');
            $validatedData['company_logo'] = $path;
        }


        Job::create($validatedData);

        return redirect()->route('jobs.index')->with('success', "Job listing created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return view('jobs.show')->with('job', $job);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {

        $this->authorize('update', $job);

        $validatedData = $request->validate([
            'title'=> 'required|string',
            'description'=> 'nullable|string',
            'salary'=> 'required|integer',
            'tags'=> 'nullable|string',
            'job_type'=> 'nullable|string',
            'remote'=> 'nullable|string',
            'requirements'=> 'nullable|string',
            'benefits'=> 'nullable|string',
            'address'=> 'nullable|string',
            'city'=> 'required|string',
            'state'=> 'required|string',
            'zipcode'=> 'nullable|string',
            'contact_email'=> 'required|string',
            'contact_phone'=> 'nullable|string',
            'company_name'=> 'required|string',
            'company_description'=> 'nullable|string',
            'company_logo'=> 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'company_website'=> 'nullable|string'
           
        ]);


      
      
        if($request->hasFile('company_logo')) {

            Storage::delete('public/logos/' . basename($job->company_logo));

            $path=$request->file('company_logo')->store('logos','public');
            $validatedData['company_logo'] = $path;
        }


        $job->update($validatedData);

        return redirect()->route('jobs.index')->with('success', "Job listing updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job): RedirectResponse
    {

        $this->authorize('delete', $job);

        if($job->company_logo) {
            Storage::delete('public/logos/' . $job->company_logo);
        }

        $job->delete();


        if(request()->query('from') == 'dashboard') {

            return redirect()->route('dashboard')->with('success', "Job listing deleted successfully!");

        }

        return redirect()->route('jobs.index')->with('success', "Job listing deleted successfully!");


    }
}
