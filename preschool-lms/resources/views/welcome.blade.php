<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome · Your School Name</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <style>
        /* Remove default Swiper arrow icons */
        .swiper-button-prev,
        .swiper-button-next,
        .swiper-button-next::after,
        .swiper-button-prev::after {
            content: none !important;
        }

        .swiper-button-next svg,
        .swiper-button-prev svg {
            width: 50% !important;
            /* or any size you want */
            height: 50% !important;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

    <!-- Navbar -->
    <x-home-navbar />

    <!-- Hero Carousel Section -->
    <section id="hero" class="relative">
        <div>
            <div class="swiper w-full h-screen md:h-[80vh] relative">
                <div class="swiper-wrapper">
                    @foreach([
                    'https://images.pexels.com/photos/4145191/pexels-photo-4145191.jpeg',
                    'https://images.pexels.com/photos/256401/pexels-photo-256401.jpeg',
                    'https://images.pexels.com/photos/256407/pexels-photo-256407.jpeg'
                    ] as $img)
                    <div class="swiper-slide relative">
                        <img src="{{ $img }}" alt="School Image" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </div>

                    <!-- Next -->
                    <div
                        class="swiper-button-next !static !w-14 !h-14 bg-black/50 hover:bg-indigo-600 rounded-full text-white flex items-center justify-center transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-1/2 h-1/2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </div>



            </div>
        </div>
    </section>

<section id="programs" class=" relative z-20">
  <div class="max-w-6xl mx-auto text-center px-6">
    <div class="pt-20"></div>


    <div class="grid md:grid-cols-3 gap-8">
      <!-- Card -->
      <div class="relative">
        <div
          class="group bg-white border shadow hover:shadow-lg transition-all overflow-hidden 
                 absolute bottom-0 left-0 right-0 z-20
                 max-h-20 hover:max-h-96 duration-500 ease-in-out">
          <!-- Title (always visible) -->
          <div class="p-6">
            <h3 class="text-xl font-semibold">Preschool Program</h3>
          </div>
          <!-- Hidden Content -->
          <div class="px-6 pb-6 text-left">
            <ul class="text-gray-600 list-disc pl-4 space-y-2">
              <li>Reading & Writing</li>
              <li>Basic Math</li>
              <li>Arts & Crafts</li>
              <li>Music & Movement</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

   



    <!-- About -->
    <section id="about" class="min-h-screen flex items-center justify-center bg-[#242424]">
        <div class="max-w-6xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold mb-6">About Our School</h2>
            <p class="text-gray-600">We believe in nurturing creativity, critical thinking, and strong values.</p>
        </div>
    </section>

    <!-- Programs -->
    <section id="programs" class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="max-w-6xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold mb-10">Our Programs</h2>
            {{-- Program cards --}}
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-6xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold mb-6">Contact Us</h2>
            <p>Email: info@myschool.com | Phone: (123) 456-7890</p>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.swiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
            });
        });
    </script>
</body>

</html>