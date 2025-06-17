 <footer class="bg-dark text-white">
     <div class="container mx-auto px-4 py-12">
         <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
             <!-- About -->
             <div>
                 <div class="flex items-center mb-4">
                     <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                         <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                     </svg>
                     <span class="ml-2 text-2xl font-bold">BlogVerse</span>
                 </div>
                 <p class="text-gray-400 mb-4">Discover stories, thinking, and expertise from writers on any topic.
                     BlogVerse is a platform where readers find dynamic thinking, and where expert and undiscovered
                     voices can share their writing.</p>
                 <div class="flex space-x-4">
                     <a href="#" class="text-gray-400 hover:text-white transition">
                         <i class="fab fa-twitter"></i>
                     </a>
                     <a href="#" class="text-gray-400 hover:text-white transition">
                         <i class="fab fa-facebook-f"></i>
                     </a>
                     <a href="#" class="text-gray-400 hover:text-white transition">
                         <i class="fab fa-instagram"></i>
                     </a>
                     <a href="#" class="text-gray-400 hover:text-white transition">
                         <i class="fab fa-pinterest-p"></i>
                     </a>
                 </div>
             </div>

             <!-- Quick Links -->
             <div>
                 <h4 class="text-lg font-bold mb-4">Quick Links</h4>
                 <ul class="space-y-2">
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Home</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Contact</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a>
                     </li>
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a>
                     </li>
                 </ul>
             </div>

             <!-- Categories -->
             <div>
                 <h4 class="text-lg font-bold mb-4">Categories</h4>
                 <ul class="space-y-2">
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Technology</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Travel</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Food</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Health</a></li>
                     <li><a href="#" class="text-gray-400 hover:text-white transition">Lifestyle</a></li>
                 </ul>
             </div>

             <!-- Subscribe -->
             <div>
                 <h4 class="text-lg font-bold mb-4">Subscribe</h4>
                 <p class="text-gray-400 mb-4">Subscribe to our newsletter for the latest updates.</p>
                 <form class="space-y-3">
                     <div>
                         <input type="email" placeholder="Your email address"
                             class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                     </div>
                     <button type="submit"
                         class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-2 px-4 rounded-lg transition">Subscribe</button>
                 </form>
             </div>
         </div>

         <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
             <p class="text-gray-400 mb-4 md:mb-0">&copy; 2023 BlogVerse. All rights reserved.</p>
             <div class="flex space-x-6">
                 <a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a>
                 <a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a>
                 <a href="#" class="text-gray-400 hover:text-white transition">Cookie Policy</a>
             </div>
         </div>
     </div>
 </footer>

 <!-- Back to Top Button -->
 <button id="backToTop"
     class="fixed bottom-6 right-6 bg-primary hover:bg-primary/90 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg opacity-0 transition-opacity duration-300">
     <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
         </path>
     </svg>
 </button>

 <script>
     // Mobile Menu Toggle
     const mobileMenuButton = document.getElementById('mobile-menu-button');
     const mobileMenu = document.getElementById('mobile-menu');

     mobileMenuButton.addEventListener('click', () => {
         mobileMenu.classList.toggle('hidden');
     });

     // Back to Top Button
     const backToTopButton = document.getElementById('backToTop');

     window.addEventListener('scroll', () => {
         if (window.pageYOffset > 300) {
             backToTopButton.classList.remove('opacity-0');
             backToTopButton.classList.add('opacity-100');
         } else {
             backToTopButton.classList.remove('opacity-100');
             backToTopButton.classList.add('opacity-0');
         }
     });

     backToTopButton.addEventListener('click', () => {
         window.scrollTo({
             top: 0,
             behavior: 'smooth'
         });
     });
 </script>
