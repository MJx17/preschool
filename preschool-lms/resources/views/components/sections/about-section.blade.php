<section id="about" class=" bg-white">
    <div class="max-w-6xl mx-auto px-6 space-y-20">

        <div class="w-screen bg-gray-200 py-16 relative left-1/2 right-1/2 -mx-[50vw]">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center h-[517px]">



                <!-- Text -->
                <div class="text-center md:text-left">
                    <h2 class="text-4xl font-bold mb-6">About Our School</h2>
                    <p class="text-gray-600 text-lg mb-6">
                        Our school is dedicated to nurturing creativity, critical thinking,
                        and strong values. We aim to empower students with the knowledge,
                        skills, and character to thrive in a changing world.
                    </p>
                    <ul class="space-y-3 text-gray-700">
                        <li>📚 Strong Academic Foundation</li>
                        <li>🎨 Creativity & Innovation</li>
                        <li>🤝 Supportive Community</li>
                        <li>🌍 Preparing Global Citizens</li>
                    </ul>
                </div>

                <!-- Image -->
                <div class="flex justify-center">
                    <img src="{{ asset('/school-image.jpg') }}"
                        alt="School Building"
                        class="rounded-lg shadow-lg w-full md:w-[90%] object-cover">
                </div>
            </div>
        </div>

        <!-- Mission -->
        <div class="grid md:grid-cols-2 gap-8 items-center h-[546px]">
            <img src="{{ asset('/mission.png') }}" alt="Mission" class="w-full rounded-lg shadow-md" />
            <div>
                <h2 class="text-3xl font-bold mb-4">Our Mission</h2>
                <p class="text-gray-600">
                    Our mission is to inspire a lifelong love of learning by providing a safe,
                    engaging, and educational environment. We aim to nurture creativity, critical
                    thinking, and values that empower students to excel academically and personally.
                </p>
            </div>
        </div>

        <!-- Vision -->
        <div class="w-screen bg-gray-200 py-16 relative left-1/2 right-1/2 -mx-[50vw]">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid md:grid-cols-2 gap-8 items-center h-[517px]">
                    <img src="{{ asset('/vision.png') }}" alt="Vision" class="w-full rounded-lg shadow-md md:order-2" />
                    <div class="md:order-1">
                        <h2 class="text-3xl font-bold mb-4">Our Vision</h2>
                        <p class="text-gray-700">
                            To be a beacon of education that fosters confidence, curiosity,
                            and compassion, preparing students to thrive in a changing world.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Core Values -->
        <div class="h-[901px] flex flex-col items-center justify-center text-center px-6">
            <h2 class="text-3xl font-bold mb-12">Our Core Values</h2>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 w-full max-w-5xl">
                <div class="p-6 bg-gray-50 rounded-lg shadow hover:shadow-lg transition text-center h-[252px]">
                    <div class="text-4xl mb-3">🎨</div>
                    <h3 class="font-semibold text-lg mb-2">Creativity</h3>
                    <p class="text-gray-600">Encouraging imagination and new ideas in every student.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow hover:shadow-lg transition text-center h-[252px]">
                    <div class="text-4xl mb-3">❤️</div>
                    <h3 class="font-semibold text-lg mb-2">Kindness</h3>
                    <p class="text-gray-600">Teaching empathy, respect, and building positive friendships.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow hover:shadow-lg transition text-center h-[252px]">
                    <div class="text-4xl mb-3">🔍</div>
                    <h3 class="font-semibold text-lg mb-2">Curiosity</h3>
                    <p class="text-gray-600">Sparking wonder and the drive to explore the world.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow hover:shadow-lg transition text-center h-[252px]">
                    <div class="text-4xl mb-3">🤝</div>
                    <h3 class="font-semibold text-lg mb-2">Community</h3>
                    <p class="text-gray-600">Fostering teamwork and a sense of belonging.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow hover:shadow-lg transition text-center h-[252px]">
                    <div class="text-4xl mb-3">💪</div>
                    <h3 class="font-semibold text-lg mb-2">Resilience</h3>
                    <p class="text-gray-600">Building confidence and perseverance through challenges.</p>
                </div>
            </div>
        </div>

        <!-- Organizational Chart -->
      
        <div class="w-screen bg-gray-200 relative left-1/2 right-1/2 -mx-[50vw]">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex flex-col items-center justify-center text-center">
                    <h2 class="text-5xl font-bold mb-8 mt-4">Organizational Structure</h2>
                    <img src="{{ asset('/org-chart.png') }}" alt="Organizational Chart"
                        class="rounded-xl shadow-lg w-full max-w-6xl mb-16" />
                </div>
            </div>
        </div>
 
    </div>
</section>