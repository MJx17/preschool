<!-- resources/views/components/footer.blade.php -->
<footer class="bg-gray-200 text-black">
    <div class="max-w-7xl mx-auto py-10 px-6 md:px-12 lg:px-20">

        <!-- Upper Section: Logos + Name -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 md:gap-12 pb-10 md:pb-12">
            <!-- Left Logo -->
            <div class="flex-shrink-0">
                <img src="{{ asset('logo.jpeg') }}" alt="CCA Logo" class="w-20 md:w-24 lg:w-28 rounded-full mx-auto md:mx-0">
            </div>

            <!-- Text Section -->
            <div class="flex-1 text-center md:text-center">
                <h2 class="text-lg md:text-xl lg:text-2xl font-bold">
                    Carrisian Community Academe, Inc.
                </h2>
                <p class="italic text-sm md:text-base mt-1">
                    "Quality Education: A Community Commitment"
                </p>
                <p class="mt-2 text-xs md:text-sm">
                    SEC Reg. No.: CN201950870
                </p>
                <p class="text-xs md:text-sm">
                    DepEd School ID: 410451
                </p>
            </div>

            <!-- Right Logo -->
            <div class="flex-shrink-0 max-sm:hidden">
                <img src="{{ asset('deped-logo.png') }}" alt="DepEd Logo" class="w-20 md:w-24 lg:w-28 rounded-full mx-auto md:mx-0 ">
            </div>
        </div>

        <!-- Contact, Socials, Inquiries -->
        <div class="flex flex-col md:flex-row flex-wrap gap-8 md:gap-10 justify-between">

            <!-- Contact -->
            <div class="flex-1 min-w-[220px]">
                <h3 class="text-lg font-semibold mb-4">Contact</h3>
                <ul class="space-y-3 text-sm">

                    <!-- Map Pin -->
                    <li class="flex items-start">
                        <x-far-map class="w-5 h-5 mr-2 flex-shrink-0 text-black" />
                        Block 28 Lot 2 &amp; 4 Phase 6 Carissa Homes Subd.,<br>
                        Brgy. Punta 1, Tanza, Cavite, Philippines 4108
                    </li>

                    <!-- Mail -->
                    <li class="flex items-center">
                        <x-far-envelope class="w-5 h-5 mr-2 flex-shrink-0 text-black" />
                        carrisiancomacad@gmail.com
                    </li>

                    <!-- Phone -->
                    <li class="flex items-center">
                        <x-fas-phone-square-alt class="w-5 h-5 mr-2 flex-shrink-0 text-black" />
                        (046) 8443 3946 | (0994) 933 7408
                    </li>

                    <!-- Clock -->
                    <li class="flex items-center">
                        <x-far-clock class="w-5 h-5 mr-2 flex-shrink-0 text-black" />
                        8am - 5pm
                    </li>
                </ul>
            </div>


            <!-- Socials -->
            <div class="flex-1 min-w-[180px]">
                <h3 class="text-lg font-semibold mb-4">Socials</h3>
                <div class="flex flex-col space-y-2 text-sm">
                    <a href="#" class="flex items-center space-x-2 hover:text-blue-500 transition">
                        <x-fab-facebook class="w-5 h-5 text-blue-600" />
                        <span>Facebook</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 hover:text-pink-500 transition">
                        <x-fab-instagram class="w-5 h-5 text-pink-500" />
                        <span>Instagram</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 hover:text-red-600 transition">
                        <x-fab-youtube class="w-5 h-5 text-red-600" />
                        <span>YouTube</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 hover:text-blue-400 transition">
                        <x-fab-facebook-messenger class="w-5 h-5 text-blue-400" />
                        <span>Messenger</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 hover:text-black transition">
                        <x-fab-tiktok class="w-5 h-5 text-black" />
                        <span>TikTok</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 hover:text-blue-700 transition">
                        <x-fab-linkedin class="w-5 h-5 text-blue-700" />
                        <span>LinkedIn</span>
                    </a>
                </div>
            </div>

            <!-- Inquiries -->
            <div class="flex-1 min-w-[200px]">
                <h3 class="text-lg font-semibold mb-4">Inquiries</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="flex items-center hover:text-yellow-500 transition">
                            <x-fas-file-alt class="w-5 h-5 mr-2" />
                            Terms and Conditions
                        </a></li>
                    <li><a href="#" class="flex items-center hover:text-yellow-500 transition">
                            <x-fas-lock class="w-5 h-5 mr-2" />
                            Privacy Policy
                        </a></li>
                    <li><a href="#" class="flex items-center hover:text-yellow-500 transition">
                            <x-fas-phone-square-alt class="w-5 h-5 mr-2" />
                            Contact Us
                        </a></li>
                    <li><a href="#" class="flex items-center hover:text-yellow-500 transition">
                            <x-fas-question-circle  class="w-5 h-5 mr-2" />
                            FAQ
                        </a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="mt-10 border-t border-gray-400 pt-4 text-center text-xs md:text-sm">
        &copy; {{ date('Y') }} Carrisian Community Academe, Inc. All rights reserved.
    </div>
</footer>