<nav class="bg-transparent fixed w-full top-0 z-50 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="#hero" class="text-xl font-bold text-white drop-shadow-lg">
                    MySchool
                </a>
            </div>

            <!-- Desktop Menu -->
            <!-- Desktop Menu -->
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">

                <a href="#hero" class="text-white hover:text-yellow-300 transition cursor-pointer">Home</a>

                <!-- About Dropdown (Desktop) -->
                <div class="relative group">
                    <!-- Trigger (About) -->
                    <a href="#about"
                        class="inline-flex items-center text-white hover:text-yellow-300 transition cursor-pointer">
                        About
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>

                    <!-- Dropdown Menu -->
                    <div
                        class="absolute left-0 top-full mt-0 w-48 bg-[#181818] shadow-lg rounded-lg 
             opacity-0 invisible group-hover:opacity-100 group-hover:visible 
             transition duration-200 z-50">
                        <a href="#history"
                            class="block px-4 py-2 text-white hover:bg-yellow-300 hover:text-black rounded-t-lg cursor-pointer">
                            Our History
                        </a>
                        <a href="#mission"
                            class="block px-4 py-2 text-white hover:bg-yellow-300 hover:text-black cursor-pointer">
                            Mission & Vision
                        </a>
                        <a href="#team"
                            class="block px-4 py-2 text-white hover:bg-yellow-300 hover:text-black rounded-b-lg cursor-pointer">
                            Our Team
                        </a>
                    </div>
                </div>

                <a href="#programs" class="text-white hover:text-yellow-300 transition cursor-pointer">Programs</a>
                <a href="#contact" class="text-white hover:text-yellow-300 transition cursor-pointer">Contact</a>

                <!-- Login Button (Desktop) -->
                <a href="login"
                    class="ml-2 px-4 py-2 rounded-lg bg-green-500 text-black font-medium hover:bg-green-700 transition cursor-pointer">
                    Login
                </a>
            </div>




            <!-- Right section for mobile: Login + Burger -->
            <div class="md:hidden flex items-center space-x-3">
                <!-- Login Button (Mobile) -->
                <a href="login"
                    class="px-3 py-1 rounded-lg bg-green-500 text-black font-medium hover:bg-green-700 transition text-sm">
                    Login
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="text-white focus:outline-none pr-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden md:hidden bg-[#181818] bg-opacity-95 px-4 pt-3 pb-5 space-y-2 shadow-xl rounded-b-2xl">
        <a href="#hero" class="block px-3 py-2 text-white rounded-lg hover:bg-yellow-300 hover:text-black transition">Home</a>

        <!-- About Accordion -->
        <div>
            <button id="mobile-about-btn"
                class="w-full flex items-center justify-between px-3 py-2 text-white rounded-lg hover:bg-yellow-300 hover:text-black transition">
                <span>About</span>
                <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="mobile-about-menu" class="hidden pl-4 mt-1 space-y-1">
                <a href="#history"
                    class="block px-3 py-2 text-white rounded-lg hover:bg-yellow-300 hover:text-black transition">Our History</a>
                <a href="#mission"
                    class="block px-3 py-2 text-white rounded-lg hover:bg-yellow-300 hover:text-black transition">Mission & Vision</a>
                <a href="#team"
                    class="block px-3 py-2 text-white rounded-lg hover:bg-yellow-300 hover:text-black transition">Our Team</a>
            </div>
        </div>

        <a href="#programs" class="block px-3 py-2 text-white rounded-lg hover:bg-yellow-300 hover:text-black transition">Programs</a>
        <a href="#contact" class="block px-3 py-2 text-white rounded-lg hover:bg-yellow-300 hover:text-black transition">Contact</a>
        <!-- (Login removed here) -->
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btn = document.getElementById("mobile-menu-button");
        const menu = document.getElementById("mobile-menu");
        const nav = document.querySelector("nav");

        // Toggle mobile menu
        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });

        // Change navbar background on scroll
        window.addEventListener("scroll", () => {
            if (window.scrollY > window.innerHeight * 0.1) {
                nav.classList.remove("bg-transparent");
                nav.classList.add("bg-[#242424]", "shadow-md");
            } else {
                nav.classList.add("bg-transparent");
                nav.classList.remove("bg-[#242424]", "shadow-md");
            }
        });

        // Accordion for About in mobile
        const aboutBtn = document.getElementById("mobile-about-btn");
        const aboutMenu = document.getElementById("mobile-about-menu");
        const arrow = aboutBtn.querySelector("svg");

        aboutBtn.addEventListener("click", () => {
            aboutMenu.classList.toggle("hidden");
            arrow.classList.toggle("rotate-180");
        });
    });
</script>