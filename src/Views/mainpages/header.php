<header class="container flex justify-between align-center">
    <!-- Main Navigation Menu-->
    <nav class="container">
          <!-- Reclaim Logo-->
        <div>
            <img>
        </div>
        <ul class="container">
            <?php 
                // The found lost & found and post an item link would only be visible once a user is logged in
                if(isset($_SESSION['user_id'])){
                    echo "
                    <li>
                        <a href='/lost'>Lost & Found</a>
                    </li>
                    <li>
                        <a href='/lost'>Post an item</a>
                    </li>
                    ";
                }     
            ?>
            <li>
                <a href="/contact">Contact Us</a>
            </li>
        </ul>
        <ul>
             <!-- Ternary Operator to check if user is logged in display profile and logout if not register-->
            <?php 
                if(!isset($_SESSION['user_id'])){
                    
                    echo "<li><a href='/register'>Sign up</a></li>";
                }else{
                    echo "<li>
                            <a href='/profile'>Profile</a>
                        </li>
                        <li> 
                            <form action='/logout' method='post'>
                                <button type='submit'>Logout</button>
                            </form>
                        </li>
                    ";
                }
            ?>
        </ul>
    </nav>
   
</header>