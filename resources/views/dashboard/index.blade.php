<x-layout>

    <div class="bg-white p-8 rounded-lg shadow-md w-full">
        <h3 class="text-3xl text-center font-bold mb-4">My Job Listings</h3>

        @forelse($jobs as $job)
            <div class="flex justify-between items-center border-b-2 border-gray-200 py-2">
                <div>

                <h3 class="text-xl font-semibold">{{$job->title}}</h3>
                <p class="text-gray-700">{{$job->job_type}}</p>

                </div>

                <div class="flex x-space-3">
                    <a href="{{route('jobs.edit', $job->id)}}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">
                    Edit
                    </a>

                       <!-- Delete Form -->
                       <form method="POST" 
                       action="{{route('jobs.destroy', $job->id)}}?from=dashboard"
                       onsubmit="return confirm('Are you sure you want to delete this listing?')"
                       >
                       @csrf
                       @method('DELETE')

                           <button
                               type="submit"
                               class="ml-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm"
                           >
                               Delete
                           </button>
                       </form>
                       <!-- End Delete Form -->


                </div>
            </div>

        @empty
        <p class="text-gray-700">You have no Job Listings</p>
        @endforelse
    </div>

</x-layout>