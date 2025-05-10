<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
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


        $validatedData['user_id'] = 1;
      


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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
