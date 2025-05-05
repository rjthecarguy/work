<x-layout>

    <x-slot name="title">Available Jobs</x-slot>

    <h1 class="text-blue-500 text-2xl font-bold mb-4">Available Jobs</h1>

    <ul>
        @forelse($jobs as $job)

            
            <li><a href="{{route('jobs.show', $job->id)}}">{{$job->title}} - {{$job->description}}</a></l1>
            @empty
            <h1 class="text-black">No Jobs Available</h1>
        @endforelse

        
    </ul>
</x-layout>
