<x-layout>

    <x-slot name="title">All Jobs</x-slot>

   

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">   
        @forelse($jobs as $job)

              
            <x-job-card :job="$job"/>

            @empty
            <p class="text-black">No Jobs Available</p>
        @endforelse
            </div>
        
    
</x-layout>