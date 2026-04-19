<?php 
define('BASE_URL', '/'); 
define('ASSETS_URL', BASE_URL . 'assets/')?>


<header class="w-full bg-white shadow-md relative z-50">
    <!-- Main Navigation Menu-->
    <nav class="mx-auto flex w-full max-w-[1327px] flex-col px-4 py-4 md:flex-row md:items-center md:justify-between sm:px-6">
          <!-- Reclaim Logo & Mobile Hamburger Menu-->
        <div class="flex w-full shrink-0 items-center justify-center md:w-auto md:justify-start relative">
            <a href="/">
                <img src="<?= ASSETS_URL ?>reclaim-header.svg" alt="Reclaim Logo" class="h-9 w-auto sm:h-10">
            </a>
            <!-- Hamburger Button -->
            <button id="mobile-menu-btn" class="absolute right-0 md:static md:block md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <!-- Mobile Dropdown Wrapper -->
        <div id="mobile-dropdown" class="absolute left-0 right-0 top-full hidden w-full flex-col gap-6 border-t border-gray-100 bg-white px-4 py-6 shadow-lg md:contents md:border-0 md:shadow-none md:p-0">
            <ul class="flex w-full flex-col md:flex-row flex-wrap items-center justify-center gap-x-5 gap-y-4 text-center font-medium text-gray-700 md:w-auto md:justify-center md:gap-y-3">
                <?php 
                    // The found lost & found and post an item link would only be visible once a user is logged in
                    if(isset($_SESSION['user_id'])){
                        echo "
                        <li>
                            <a href='/lost' class='hover:text-blue-500 transition'>Lost & Found</a>
                        </li>
                        <li>
                            <a href='/post-item' class='hover:text-blue-500 transition'>Post an item</a>
                        </li>
                        ";
                    }     
                ?>
                <li>
                    <a href="/contact" class='whitespace-nowrap hover:text-blue-500 transition'>Contact Us</a>
                </li>
            </ul>
            <ul class="flex w-full flex-col md:flex-row flex-wrap items-center justify-center gap-x-4 gap-y-4 border-t border-gray-200 pt-5 text-center font-medium text-gray-700 md:ml-6 md:w-auto md:justify-end md:border-0 md:pt-0 md:gap-y-3">
                 <!-- Ternary Operator to check if user is logged in display profile and logout if not register-->
                <?php 
                    if(!isset($_SESSION['user_id'])){
                        echo "<li><a href='/register' class='whitespace-nowrap hover:text-blue-600 transition'>Sign up</a></li>";
                    }else{
                        echo "<li>
                                <a href='/profile' class='whitespace-nowrap hover:text-blue-600 transition'>Profile</a>
                            </li>
                            <li> 
                                <form action='/logout' method='post'>
                                    <button type='submit' class='hover:text-blue-600 transition'>Logout</button>
                                </form>
                            </li>
                        ";
                    }
                ?>
            </ul>
        </div>
    </nav>
</header>
<script src="/js/main/header.js" defer></script>