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
            <div class="hidden md:flex items-center space-x-6">
                <a href="#hero" class="text-white hover:text-yellow-300 transition">Home</a>
                <a href="#about" class="text-white hover:text-yellow-300 transition">About</a>
                <a href="#programs" class="text-white hover:text-yellow-300 transition">Programs</a>
                <a href="#contact" class="text-white hover:text-yellow-300 transition">Contact</a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <!-- Icon (Hamburger) -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-black bg-opacity-80 px-4 pt-2 pb-3 space-y-2 shadow-lg">
        <a href="#hero" class="block text-white hover:text-yellow-300">Home</a>
        <a href="#about" class="block text-white hover:text-yellow-300">About</a>
        <a href="#programs" class="block text-white hover:text-yellow-300">Programs</a>
        <a href="#contact" class="block text-white hover:text-yellow-300">Contact</a>
    </div>
</nav>

<script>
    // Toggle mobile menu
    document.addEventListener("DOMContentLoaded", () => {
        const btn = document.getElementById("mobile-menu-button");
        const menu = document.getElementById("mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    });
</script>
