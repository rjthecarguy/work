<x-layout>

    <x-slot name="title">Create Job</x-slot>

    <h1>Create New Job</h1>

    <form method="POST" action="/jobs">
        @csrf
        <input type="text" name="name" placeholder="Name"/>
        <input type ="text" name="desc" placeholder="Description"/>
        <button type="submit">Submit</button>
    </form>
</x-layout>