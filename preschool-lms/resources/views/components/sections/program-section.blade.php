@php
$programs = [
[
'title' => 'Art Forms',
'description' => 'Creative activities with drawing, painting, and crafts.',
'image' => '/program-1.png',
],
[
'title' => 'Story Time',
'description' => 'Engaging storytelling sessions that spark imagination.',
'image' => '/program-2.png',
],
[
'title' => 'Outdoor Play',
'description' => 'Fun and active play to build social and motor skills.',
'image' => '/program-3.png',
],
[
'title' => 'Music and Movement',
'description' => 'Songs, dance, and rhythm-based activities for kids.',
'image' => '/program-4.png',
],
[
'title' => 'Science Explorers',
'description' => 'Hands-on experiments to learn about science and nature.',
'image' => '/program-5.png',
],
[
'title' => 'Cooking Fun',
'description' => 'Simple cooking activities that teach skills and teamwork.',
'image' => '/program-6.png',
],
];
@endphp

<section id="programs" class="min-h-screen flex flex-col bg-gray-50 py-16 ">
  <div class="w-full px-4 sm:px-6 lg:px-20 mx-auto">
    <!-- Heading -->
    <h2 class="text-3xl md:text-4xl font-bold mb-12 text-center">Our Programs</h2>

    <div class="relative">
      <!-- Swiper -->
      <div class="swiper programs-swiper w-full">
        <div class="swiper-wrapper">
          @foreach($programs as $program)
          <div class="swiper-slide flex justify-center">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden  w-full flex flex-col mb-20">
              <!-- Image -->
              <img src="{{ asset($program['image']) }}" alt="{{ $program['title'] }}"
                class="w-full h-[180px] object-cover" />

              <!-- Text -->
              <div class="p-4 flex flex-col flex-grow">
                <h3 class="text-lg font-semibold mb-2">{{ $program['title'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $program['description'] }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const swiperEl = document.querySelector(".programs-swiper");

    if (swiperEl) {
      new Swiper(swiperEl, {
        loop: false,
        spaceBetween: 20,
        slidesPerView: "auto",
        centeredSlides: false,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        breakpoints: {
          320: {
            slidesPerView: 1
          },
          640: {
            slidesPerView: 2
          },
          1024: {
            slidesPerView: 3
          },
          1440: {
            slidesPerView: 4
          },
        },
      });
    }
  });
</script>