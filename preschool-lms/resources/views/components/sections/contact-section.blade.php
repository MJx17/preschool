<section id="contact"
    class="contact-bg min-h-screen flex items-center justify-center  bg-cover bg-center bg-no-repeat py-12">
    

    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Contact Form -->
        <div class="bg-white p-6 sm:p-8 rounded shadow w-full">
            <h2 class="text-3xl font-bold mb-6 text-center md:text-left">Contact Us</h2>

            @if(session('success'))
            <p class="mb-4 text-green-600">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('contact.send') }}" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Your Name" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-400" required>
                <input type="email" name="email" placeholder="Your Email" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-400" required>
                <textarea name="message" placeholder="Your Message" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-400" rows="5" required></textarea>
                <button type="submit" class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Send Message</button>
            </form>

            <p class="mt-6 text-center md:text-left">Email: info@myschool.com | Phone: (123) 456-7890</p>
        </div>

        <!-- Google Map -->
        <div class="rounded overflow-hidden shadow w-full h-80 md:h-full">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3162.123456789!2d-122.084249684692!3d37.4220659798251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb5d68f2c7e43%3A0xabcdef123456789!2sMy%20School!5e0!3m2!1sen!2sph!4v1694736543210!5m2!1sen!2sph"
                class="w-full h-full"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>