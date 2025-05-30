   <!-- Bottom Banner -->
   <section class="container mx-auto my-6">
    <div
        class="bg-blue-800 text-white rounded p-4 flex items-center justify-between flex-col md:flex-row gap-4"
    >
        <div>
            <h2 class="text-xl font-semibold">Looking to hire?</h2>
            <p class="text-gray-200 text-lg mt-2">
                Post your job listing now and find the perfect
                candidate.
            </p>
        </div>
        
        {{--Display button only if logged in --}}
        @auth
        <x-button url="/jobs/create" icon='edit'>Create Job</x-button>
        @endauth


    </div>
</section>