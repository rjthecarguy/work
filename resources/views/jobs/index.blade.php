<x-layout>

    <div class="h-24 bg-blue-900 px-4 mb-4 flex justify-center items-center rounded ">
        <x-search/>    
    </div>   

    @if(request()->has('keywords') || request()->has('location'))

    <a href="{{route('jobs.index')}}" class="bg-gray-700 text-white hover:bg-gray-600 px-4 py-2 rounde mb-4 inline-block">
        <i class="fa fa-arrow-left mr-1"></i>Back
    </a>

    @endif

    <x-slot name="title">All Jobs</x-slot>

   

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">   
        @forelse($jobs as $job)

              
            <x-job-card :job="$job"/>

            @empty
            <p class="text-black">No Jobs Available</p>
        @endforelse
            </div>
        
    {{$jobs->links()}}

</x-layout>