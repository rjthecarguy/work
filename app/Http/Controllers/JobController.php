<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class JobController extends Controller
{

    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $jobs = Job::paginate(9);
        
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
    
       // Validate submitted user data
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

        // Link current user with new record
        $validatedData['user_id'] = auth()->user()->id;
      
        // If logo exists, get path and save logo and path
        if($request->hasFile('company_logo')) {

            $path=$request->file('company_logo')->store('logos','public');
            $validatedData['company_logo'] = $path;
        }

        // Create new job record
        Job::create($validatedData);

        // Return with "success"
        return redirect()->route('jobs.index')->with('success', "Job listing created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        // Show a single job
        return view('jobs.show')->with('job', $job);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        
        // Tells laravel to use the middleware for authorization
        $this->authorize('update', $job);

        // Go to Edit view
        return view('jobs.edit')->with('job', $job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {

        // Tells laravel to use the middleware for authorization
        $this->authorize('update', $job);

        // Validate Update data
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


      
        // If there is a logo
        if($request->hasFile('company_logo')) {

            // Delete old logo
            Storage::delete('public/logos/' . basename($job->company_logo));

            // Get logo path and save logo and path
            $path=$request->file('company_logo')->store('logos','public');
            $validatedData['company_logo'] = $path;
        }

        // Update record
        $job->update($validatedData);

        // Return with success
        return redirect()->route('jobs.index')->with('success', "Job listing updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job): RedirectResponse
    {

         // Tells laravel to use the middleware for authorization
        $this->authorize('delete', $job);

        // If logo, delete it
        if($job->company_logo) {
            Storage::delete('public/logos/' . $job->company_logo);
        }

        // Delete Job record
        $job->delete();


        // If request came from Dashboard, go there
        if(request()->query('from') == 'dashboard') {

            return redirect()->route('dashboard')->with('success', "Job listing deleted successfully!");

        }

        // Else, to to Jobs page
        return redirect()->route('jobs.index')->with('success', "Job listing deleted successfully!");


    }

    public function search(Request $request): View {

        // Get keywords and set to lowercase
        $keywords = strtolower($request->input('keywords'));
        $location = strtolower($request->input('location'));

        // Create new query
        $query = Job::query();

        // If keywords exist, create a keyword query
        if($keywords) {

            $query->where(function($q) use ($keywords) {
                $q->whereRaw('LOWER(title) like ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(description) like ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(tags) like ?', ['%' . $keywords . '%']);
            });

            
        }

        // If loaction exists, create a location query
        if($location) {

            $query->where(function($q) use ($location) {
                $q->whereRaw('LOWER(address) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(city) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(state) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(zipcode) like ?', ['%' . $location . '%']);
            });
        }

    
        // Create Job var from query with paginate option
        $jobs = $query->paginate(12);

    
        // Return to view with the Job var
        return view('jobs.index')->with('jobs', $jobs);



    }
}
