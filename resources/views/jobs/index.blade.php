<x-layout>

    <x-slot name="title">Available Jobs</x-slot>

    <h1 class="text-blue-500">Available Jobs</h1>

    <ul>
        @foreach($jobs as $job)
            <li>{{$job}}</l1>
        @endforeach
    </ul>
</x-layout>
