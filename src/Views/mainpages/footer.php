<footer class="site-footer relative bg-primary-500 text-white mt-12 font-poppins overflow-hidden">

    <div class="relative z-10 container mx-auto py-12 px-6 flex flex-col gap-12 lg:grid lg:grid-cols-2 lg:gap-12">
        
        <!-- Logo (Order 1 on Mobile, Top Left on Desktop) -->
        <div class="order-1 lg:col-start-1 lg:row-start-1 lg:justify-self-start">
            <a href="/" title="Go to Homepage" class="inline-block">
                <img src="/assets/reclaim-footer.svg" alt="Re:Claim Logo" class="w-[208px] h-[48px] shrink-0 object-contain object-left">
            </a>
        </div>

        <!-- Navigation -->
        <div class="order-2 lg:order-0 lg:col-span-2 lg:row-start-2 grid grid-cols-2 gap-y-10 gap-x-4 sm:flex sm:flex-row sm:flex-wrap sm:gap-12 md:gap-20 lg:gap-32 w-full">
            <!-- General -->
            <div class="flex flex-col">
                <h4 class="font-semibold text-md mb-6 lg:mb-8">General</h4>
                <ul class="space-y-4 lg:space-y-7">
                    <li><a href="/" class="text-sm text-white hover:text-white hover:underline transition-colors">Homepage</a></li>
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/lost' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Lost Items Feed</a></li>
                    <?= isset($_SESSION['user_id']) ? '<li><a href="/found" class="text-sm text-white hover:text-white hover:underline transition-colors">Found Items Feed</a></li>' : '' ?>
                    <li><a href="/terms-of-service" class="text-sm text-white hover:text-white hover:underline transition-colors">Terms of Service</a></li>
                    <li><a href="/privacy-policy" class="text-sm text-white hover:text-white hover:underline transition-colors">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Post -->
            <div class="flex flex-col">
                <h4 class="font-semibold text-md mb-6 lg:mb-8">Post</h4>
                <ul class="space-y-4 lg:space-y-7">
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/lost/post' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Post Lost Item</a></li>
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/found/post' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Post Found Item</a></li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div class="flex flex-col">
                <h4 class="font-semibold text-md mb-6 lg:mb-8">Contact Us</h4>
                <ul class="space-y-4 lg:space-y-7">
                    <li><a href="/contact" class="text-sm text-white hover:text-white hover:underline transition-colors">Contact SPARK Hub</a></li>
                    <li><a href="/contact" class="text-sm text-white hover:text-white hover:underline transition-colors">Contact USC-CITE</a></li>
                </ul>
            </div>

            <!-- My Profile -->
            <div class="flex flex-col">
                <h4 class="font-semibold text-md mb-6 lg:mb-8">My Profile</h4>
                <ul class="space-y-4 lg:space-y-7">
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/profile' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Visit Profile</a></li>
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/profile' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Posted Items</a></li>
                </ul>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="order-3 lg:col-start-2 lg:row-start-1 lg:justify-self-end mt-4 lg:mt-0">
            <address class="not-italic flex flex-col gap-6 sm:flex-row sm:gap-8 lg:gap-12 w-full">
                <!-- SPARK Hub -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <img src="/assets/envelope-yellow.svg" alt="Email" class="w-5 h-5 shrink-0">
                        <a target="_blank" href="mailto:spark.hub@wvsu.edu.ph" class="text-sm hover:underline">spark.hub@wvsu.edu.ph</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <img src="/assets/facebook-yellow.svg" alt="Facebook" class="w-5 h-5 shrink-0">
                        <a target="_blank" href="https://web.facebook.com/WVSUSparkHub" class="text-sm hover:underline">Follow SPARK Hub on Facebook</a>
                    </div>
                </div>

                <!-- USC-CITE -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <img src="/assets/envelope-yellow.svg" alt="Email" class="w-5 h-5 shrink-0">
                        <a target="_blank" href="mailto:usc.cite@wvsu.edu.ph" class="text-sm hover:underline">usc.cite@wvsu.edu.ph</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <img src="/assets/facebook-yellow.svg" alt="Facebook" class="w-5 h-5 shrink-0">
                        <a target="_blank" href="https://web.facebook.com/profile.php?id=61564071784342" class="text-sm hover:underline">Follow USC-CITE on Facebook</a>
                    </div>
                </div>
            </address>
        </div>

        <!-- Copyright -->
        <div class="order-4 lg:col-span-2 mt-4 pt-8 border-t border-white text-left md:text-center">
            <small class="text-sm text-white">&copy; 2026 SPARK Hub and USC-CITE.<br class="md:hidden"> All Rights Reserved.</small>
        </div>
    </div>
</footer>
