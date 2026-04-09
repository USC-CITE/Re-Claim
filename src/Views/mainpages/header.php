<?php 
define('BASE_URL', '/'); 
define('ASSETS_URL', BASE_URL . 'assets/')?>


<header class="w-full bg-white shadow-md">
    <!-- Main Navigation Menu-->
    <nav class="container mx-auto flex justify-between items-center py-4 px-4 md:px-6">
          <!-- Reclaim Logo-->
        <div class="flex-shrink-0">
            <img src="<?= ASSETS_URL ?>reclaim-header.svg" alt="Reclaim Logo" class="h-10 w-auto">
        </div>
        <ul class="flex items-center gap-3 md:gap-6 text-sm md:text-base text-gray-700 font-medium">
            <?php 
                // The found lost & found and post an item link would only be visible once a user is logged in
                if(isset($_SESSION['user_id'])){
                    echo "
                    <li>
                        <a href='/lost' class='hover:text-blue-500 transition'>Lost & Found</a>
                    </li>
                    <li>
                        <a href='/lost' class='hover:text-blue-500 transition'>Post an item</a>
                    </li>
                    ";
                }     
            ?>
            <li>
                <a href="/contact" class='whitespace-nowrap hover:text-blue-500 transition'>Contact Us</a>
            </li>
        </ul>
        <ul class="flex items-center gap-2 md:gap-4 text-sm md:text-base text-gray-700 font-medium ml-3 md:ml-6">
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
    </nav>
   
</header>