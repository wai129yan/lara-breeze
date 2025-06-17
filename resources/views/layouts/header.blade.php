  <header class="bg-white shadow-sm sticky top-0 z-10">
      <div class="container mx-auto px-4">
          <div class="flex flex-col md:flex-row justify-between items-center py-4">
              <!-- Logo -->
              <div class="flex items-center mb-4 md:mb-0">
                  <a href="index.html" class="flex items-center">
                      <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                      </svg>
                      <span class="ml-2 text-2xl font-bold text-gray-900">BlogVerse</span>
                  </a>
              </div>

              <!-- Navigation -->
              <nav class="hidden md:flex space-x-8">
                  <a href="#" class="text-gray-900 hover:text-primary font-medium transition">Home</a>
                  <a href="{{ route('categories.index') }}"
                      class="text-gray-600 hover:text-primary font-medium transition">Categories</a>
                  <a href="#" class="text-gray-600 hover:text-primary font-medium transition">Popular</a>
                  <a href="#" class="text-gray-600 hover:text-primary font-medium transition">Latest</a>
                  <a href="#" class="text-gray-600 hover:text-primary font-medium transition">About</a>
              </nav>

              <!-- Mobile Menu Button -->
              <button class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none" id="mobile-menu-button">
                  <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                      </path>
                  </svg>
              </button>

              <!-- Search and Account -->
              <div class="hidden md:flex items-center space-x-4">
                  <div class="relative">
                      <input type="text" placeholder="Search..."
                          class="pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                      <div class="absolute left-3 top-2.5">
                          <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                          </svg>
                      </div>
                  </div>
                  <div class="relative group">
                      <a href="#" class="text-gray-600 hover:text-primary">
                          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                          </svg>
                      </a>
                      <div
                          class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg  group-hover:block">
                          @if (Route::has('login'))
                              {{-- <nav class="flex items-center justify-end gap-4"> --}}
                              @auth
                                  <a href="{{ url('/dashboard') }}"
                                      class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                                      Dashboard
                                  </a>

                                  <form method="POST" action="{{ route('logout') }}">
                                      @csrf

                                      <x-dropdown-link :href="route('logout')"
                                          onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                          {{ __('Log Out') }}
                                      </x-dropdown-link>
                                  </form>
                              @else
                                  <a href="{{ route('login') }}"
                                      class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                                      Log in
                                  </a>

                                  @if (Route::has('register'))
                                      <a href="{{ route('register') }}"
                                          class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                                          Register
                                      </a>
                                  @endif
                              @endauth
                              {{-- </nav> --}}
                          @endif

                      </div>
                  </div>
              </div>
          </div>

          <!-- Mobile Menu (hidden by default) -->
          <div class="md:hidden hidden" id="mobile-menu">
              <div class="px-2 pt-2 pb-4 space-y-1">
                  <a href="#"
                      class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 bg-gray-100">Home</a>
                  <a href="#"
                      class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900">Categories</a>
                  <a href="#"
                      class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900">Popular</a>
                  <a href="#"
                      class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900">Latest</a>
                  <a href="#"
                      class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900">About</a>
                  <div class="relative mt-3 px-3">
                      <input type="text" placeholder="Search..."
                          class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                      <div class="absolute left-6 top-2.5">
                          <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                          </svg>

                          <div class="relative mt-3 px-3">
                              <button
                                  class="w-full text-left pl-4 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                  Account
                              </button>
                              <div
                                  class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-lg shadow-lg hidden group-hover:block">

                                  <a href="#"
                                      class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">Login</a>
                                  <a href="#"
                                      class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">Register</a>
                                  <a href="#"
                                      class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">Logout</a>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="relative mt-3 px-3">
                      <button
                          class="w-full text-left pl-4 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                          Account
                      </button>
                      <div
                          class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-lg shadow-lg hidden group-hover:block">
                          <a href="#"
                              class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">Login</a>
                          <a href="#"
                              class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">Register</a>
                          <a href="#"
                              class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">Logout</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </header>
