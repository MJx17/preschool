<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <x-sections.hero-section />


    <x-sections.about-section />


    <!-- Programs -->
    <x-sections.program-section />

    <!-- Contact -->
    <x-sections.contact-section />

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Hero / main swiper
            new Swiper('.swiper.hero-swiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.hero-swiper .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.hero-swiper .swiper-button-next',
                    prevEl: '.hero-swiper .swiper-button-prev',
                },
            });

            // Programs card swiper

        });
    </script>


</body>

</html>