<header class="bg-blue-900 text-white p-4" x-data="{open:false}">
   <div class="container mx-auto flex justify-between items-center">
       <h1 class="text-3xl font-semibold">
           <a href="{{url('/')}}">Workopia</a>
       </h1>
       <nav class="hidden md:flex items-center space-x-4">

         <x-nav-link url='/'  :active="request()->is('/') ">Home</x-nav-link>
         <x-nav-link url='/jobs'  :active="request()->is('jobs')">All Jobs</x-nav-link>

         {{-- Display if user is logged in --}}
         @auth
         <x-nav-link url='/bookmarks'  :active="request()->is('/bookmarks') ">Bookmarks</x-nav-link>
         
        
         <x-logout-button/>
         <x-button url='/jobs/create' icon='edit'>Create Job</x-button>

         <div class="flex space-x-3 items-center">

            <a href="{{route('dashboard')}}">
                @if(Auth::user()->avatar)
                    <img src="{{asset('storage/' . Auth::user()->avatar)}}" 
                    class="h-10 w-10 rounded-full"
                    />
                @else
                 <img src="{{asset('storage/avatars/default-avatar.png')}}" 
                    class="h-10 w-10 rounded-full"
                    />
                @endif
        
            </a>
        
           </div>
         @else 

         <x-nav-link url='/login'  :active="request()->is('login') ">Login</x-nav-link>
         <x-nav-link url='/register'  :active="request()->is('register') ">Register</x-nav-link>
         @endauth  
         {{-- End of Auth for logged in user menu items --}}
      
       </nav>
       <button
            @click="open=!open"
           id="hamburger"
           class="text-white md:hidden flex items-center"
       >
           <i class="fa fa-bars text-2xl"></i>
       </button>
   </div>
   <!-- Mobile Menu -->
   
   
   <nav
        @click.away="open=false"
        x-show="open"  {{-- Logic for mobile menu --}}
       id="mobile-menu"
       class="md:hidden bg-blue-900 text-white mt-5 pb-4 space-y-2"
   >
   <x-nav-link url='/jobs' :mobile="true" :active="request()->is('jobs')">All Jobs</x-nav-link>

   {{-- Only display if user is logged in  --}}
   @auth
   <x-nav-link url='/bookmarks' :mobile="true" :active="request()->is('/bookmarks') ">Bookmarks</x-nav-link>
  
   <x-nav-link url='/dashboard' :mobile="true" :active="request()->is('dashbaord') " icon="gauge">Dashboard</x-nav-link>
   <x-logout-button/>
   <div class="pt-2"></div>    
   <x-button url='/jobs/create' icon='edit' :block="true">Create Job</x-button>

  

   @else
   <x-nav-link url='/login' :mobile="true" :active="request()->is('login') ">Login</x-nav-link>
   <x-nav-link url='/register' :mobile="true" :active="request()->is('register') ">Register</x-nav-link>
   @endauth
   {{-- End of Auth block for logged in user menu items --}}

   </nav>
</header>