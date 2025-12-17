<!-- resources/views/components/footer.blade.php -->
<footer class="bg-gray-200 text-black">

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-20 py-10">

        <!-- Top Section -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 pb-10 border-b border-gray-300">

            <!-- Left Logo -->
            <img src="{{ asset('logo.jpeg') }}" alt="CCA Logo" class="w-20 md:w-24 rounded-full" />

            <!-- School Info -->
            <div class="text-center flex-1">
                <h2 class="text-lg md:text-xl lg:text-2xl font-bold">Carrisian Community Academe, Inc.</h2>
                <p class="italic text-sm mt-1">"Quality Education: A Community Commitment"</p>
                <p class="text-xs mt-2">SEC Reg. No.: CN201950870</p>
                <p class="text-xs">DepEd School ID: 410451</p>
            </div>

            <!-- Right Logo -->
            <img src="{{ asset('deped-logo.png') }}" alt="DepEd Logo" class="w-20 md:w-24 rounded-full hidden md:block" />

        </div>

        <div class="mt-10 flex flex-col md:flex-row justify-between gap-8">

            <!-- Contact -->
            <div class="flex flex-col items-start md:max-w-[48%]">
                <h3 class="text-lg font-semibold mb-2">Contact</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-start gap-2">
                        <x-far-map class="w-5 h-5 mt-0.5 flex-shrink-0" />
                        <span>
                            Block 28 Lot 2 &amp; 4 Phase 6 Carissa Homes Subd.,<br>
                            Brgy. Punta 1, Tanza, Cavite, Philippines 4108
                        </span>
                    </li>
                    <li class="flex items-center gap-2">
                        <x-far-envelope class="w-5 h-5 flex-shrink-0" /> carrisiancomacad@gmail.com
                    </li>
                    <li class="flex items-center gap-2">
                        <x-fas-phone-square-alt class="w-5 h-5 flex-shrink-0" /> (046) 8443 3946 | (0994) 933 7408
                    </li>
                    <li class="flex items-center gap-2">
                        <x-far-clock class="w-5 h-5 flex-shrink-0" /> 8:00 AM – 5:00 PM
                    </li>
                </ul>
            </div>

            <!-- Inquiries -->
            <div class="flex flex-col items-start md:max-w-[48%]">
                <h3 class="text-lg font-semibold mb-2">Inquiries</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <x-fas-file-alt class="w-5 h-5 flex-shrink-0" /> Terms and Conditions
                    </li>
                    <li class="flex items-center gap-2">
                        <x-fas-lock class="w-5 h-5 flex-shrink-0" /> Privacy Policy
                    </li>
                    <li class="flex items-center gap-2">
                        <x-fas-phone-square-alt class="w-5 h-5 flex-shrink-0" /> Contact Us
                    </li>
                    <li class="flex items-center gap-2">
                        <x-fas-question-circle class="w-5 h-5 flex-shrink-0" /> FAQ
                    </li>
                </ul>
            </div>

        </div>




        <!-- Social Icons Container (above copyright) -->
        <div class="mt-6 flex justify-center md:justify-center gap-4">
            <a href="#" class="hover:text-blue-600 transition"><x-fab-facebook class="w-5 h-5 text-blue-600" /></a>
            <a href="#" class="hover:text-pink-500 transition"><x-fab-instagram class="w-5 h-5 text-pink-500" /></a>
            <a href="#" class="hover:text-red-600 transition"><x-fab-youtube class="w-5 h-5 text-red-600" /></a>
            <a href="#" class="hover:text-blue-400 transition"><x-fab-facebook-messenger class="w-5 h-5 text-blue-400" /></a>
            <a href="#" class="hover:text-black transition"><x-fab-tiktok class="w-5 h-5" /></a>
            <a href="#" class="hover:text-blue-700 transition"><x-fab-linkedin class="w-5 h-5 text-blue-700" /></a>
        </div>

    </div>

    <!-- Footer Bottom -->
    <div class="border-t border-gray-400 text-center text-xs md:text-sm py-4">
        &copy; {{ date('Y') }} Carrisian Community Academe, Inc. All rights reserved.
    </div>

</footer>