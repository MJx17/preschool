<!-- Hero Carousel Section -->
<section id="hero" class="relative">
    <div>
        <div class="swiper hero-swiper w-full h-screen md:h-[80vh] relative">
            <div class="swiper-wrapper">
                @foreach([
                    'https://images.pexels.com/photos/4145191/pexels-photo-4145191.jpeg',
                    'https://images.pexels.com/photos/256401/pexels-photo-256401.jpeg',
                    'https://images.pexels.com/photos/256407/pexels-photo-256407.jpeg'
                ] as $img)
                <div class="swiper-slide relative">
                    <img src="{{ $img }}" alt="School Image" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                        <div class="text-center text-white px-4">
                            <h1 class="text-3xl md:text-5xl font-bold">Welcome to ABC School</h1>
                            <p class="mt-2 text-lg md:text-2xl">Empowering learners for tomorrow</p>
                            <a href="#admissions"
                               class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Custom Navigation -->
            <div class="absolute bottom-12 right-10 flex space-x-4 z-50">
                <!-- Prev -->
                <div
                    class="swiper-button-prev !static !w-14 !h-14 bg-black/50 hover:bg-indigo-600 rounded-full text-white flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" class="w-1/2 h-1/2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                </div>

                <!-- Next -->
                <div
                    class="swiper-button-next !static !w-14 !h-14 bg-black/50 hover:bg-indigo-600 rounded-full text-white flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" class="w-1/2 h-1/2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
