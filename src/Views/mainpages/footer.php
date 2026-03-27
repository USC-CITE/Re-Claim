<footer class="relative bg-primary-500 text-white mt-12 font-poppins overflow-hidden">
    <!-- Background Watermark Logo -->
    <div class="absolute right-12 -bottom-60 flex items-center justify-center pointer-events-none">
        <div class="w-160 h-160 bg-primary-600 -rotate-19" style="-webkit-mask-image: url('/assets/reclaim-logo.svg'); mask-image: url('/assets/reclaim-logo.svg'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center;"></div>
    </div>

    <div class="relative z-10 container mx-auto py-12 px-6">
        
        <!-- Top Section: Logo & Social/Contact -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12 gap-8">
            <!-- Logo -->
            <a href="/" title="Go to Homepage">
                <div class="w-[208px] h-[48px] shrink-0 bg-[linear-gradient(to_right,var(--color-accent-500)_23%,white_23%)]" style="-webkit-mask-image: url('/assets/reclaim-header.svg'); mask-image: url('/assets/reclaim-header.svg'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: left center; mask-position: left center;"></div>
            </a>

            <!-- Contact Info -->
            <address class="not-italic flex flex-col sm:flex-row gap-6 md:gap-8">
                <!-- SPARK Hub -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 shrink-0 bg-accent-500" style="-webkit-mask-image: url('/assets/envelope.svg'); mask-image: url('/assets/envelope.svg'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center;"></div>
                        <a target="_blank" href="mailto:spark.hub@wvsu.edu.ph" class="text-sm hover:underline">spark.hub@wvsu.edu.ph</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 shrink-0 bg-accent-500" style="-webkit-mask-image: url('/assets/facebook.svg'); mask-image: url('/assets/facebook.svg'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center;"></div>
                        <a target="_blank" href="https://web.facebook.com/WVSUSparkHub" class="text-sm hover:underline">Follow SPARK Hub on Facebook</a>
                    </div>
                </div>

                <!-- USC-CITE -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 shrink-0 bg-accent-500" style="-webkit-mask-image: url('/assets/envelope.svg'); mask-image: url('/assets/envelope.svg'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center;"></div>
                        <a target="_blank" href="mailto:usc.cite@wvsu.edu.ph" class="text-sm hover:underline">usc.cite@wvsu.edu.ph</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 shrink-0 bg-accent-500" style="-webkit-mask-image: url('/assets/facebook.svg'); mask-image: url('/assets/facebook.svg'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: center; mask-position: center;"></div>
                        <a target="_blank" href="https://web.facebook.com/profile.php?id=61564071784342" class="text-sm hover:underline">Follow USC-CITE on Facebook</a>
                    </div>
                </div>
            </address>
        </div>

        <!-- Bottom Section: Navigation -->
        <div class="flex flex-col sm:flex-row flex-wrap gap-8 sm:gap-12 md:gap-20 lg:gap-8">
            <!-- General -->
            <div class="flex flex-col">
                <h4 class="font-semibold text-md mb-8">General</h4>
                <ul class="space-y-7">
                    <li><a href="/" class="text-sm text-white hover:text-white hover:underline transition-colors">Homepage</a></li>
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/lost' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Lost Items Feed</a></li>
                </ul>
            </div>

            <!-- Post -->
            <div class="flex flex-col">
                <h4 class="font-semibold text-md mb-8">Post</h4>
                <ul class="space-y-7">
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/lost/post' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Post Lost Item</a></li>
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/found/post' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Post Found Item</a></li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div class="flex flex-col">
                <h4 class="font-semibold text-md mb-8">Contact Us</h4>
                <ul class="space-y-7">
                    <li><a href="/contact" class="text-sm text-white hover:text-white hover:underline transition-colors">Contact SPARK Hub</a></li>
                    <li><a href="/contact" class="text-sm text-white hover:text-white hover:underline transition-colors">Contact USC-CITE</a></li>
                </ul>
            </div>

            <!-- My Profile -->
            <div class="flex flex-col">
                <h4 class="font-semibold text-md mb-8">My Profile</h4>
                <ul class="space-y-7">
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/profile' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Visit Profile</a></li>
                    <li><a href="<?= isset($_SESSION['user_id']) ? '/profile' : '/register' ?>" class="text-sm text-white hover:text-white hover:underline transition-colors">Posted Items</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-16 pt-8 border-t border-white text-center">
            <p class="text-sm text-white">&copy; 2026 SPARK Hub and USC-CITE. All Rights Reserved.</p>
        </div>
    </div>
</footer>
