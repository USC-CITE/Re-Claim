<header class="container">
    <!-- Reclaim Logo-->
    <div>
        <img>
    </div>

    <!-- Main Navigation Menu-->
    <nav class="container">
        <a href="/lost">Lost & Found</a>
        <a href="">Post an item</a>
        <a href="/contact">Contact Us</a>
    </nav>
    <!-- Ternary Operator to check if user is logged in display profile and logout if not register-->
    <?php 
        if(!isset($_SESSION['user_id'])){
            
            echo "<a href='/register'>Sign up</a>";
        }else{
            echo "<a>Profile</a> <br> 
            <form action='/logout' method='post'>
                <button type='submit'>Logout</button>
            </form>
            ";
        }
    ?>
</header>