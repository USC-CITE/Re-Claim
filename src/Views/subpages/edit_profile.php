<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WVSU ReClaim</title>
    
    <script>
        // Progressive enhancement: detect JS
        document.documentElement.classList.remove('no-js');
        document.documentElement.classList.add('js');
    </script>

    <style>
        /* Tabs default */
        .no-js .tab-content {
            display: block;
        }
        .js .tab-content {
            display: none;
        }
        .js .tab-content.active {
            display: block;
        }

    </style>
</head>
<body>
    <?php require __DIR__  . "/../mainpages/header.php"; ?>

    <main>
        <!-- Page Header -->
        <header class="page-header">
            <h2><a href="/profile">Return to Profile</a> / Edit Profile</h2>
            <p>Update your user profile and contact information</p>
        </header>

        <!-- Tab Buttons -->
        <nav>
            <button type="button" class="tab-btn" data-tab="edit-profile">Edit Profile</button>
            <button type="button" class="tab-btn" data-tab="change-pass">Change Password</button>
            <button type="button" class="tab-btn" data-tab="privacy">Privacy Security</button>
        </nav>

        <!-- Tab Contents -->
        <section class="tab-content" id="edit-profile">
            <section>
                <!-- User Avatar -->
                <div>
                    <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '/images/default-avatar.png') ?>" width="100">
                </div>
                
                <!-- This requires file format as value of input field-->
                <form action="/profile/avatar/upload" method="post" enctype="multipart/form-data">
                    <input type="file" name="avatar" accept="image/*" required>
                    <button type="submit">
                        Upload Picture
                    </button>
                </form>
                <form action="/profile/avatar/delete" method="post"> 
                    <button type="button">
                        Delete
                    </button>
                </form>
            </section>

        </section>

        <section class="tab-content" id="change-pass">
            <h3>This is Change Password tab </h3>
        </section>

        <section class="tab-content" id="privacy">
            <h3>This is Privacy Security tab</h3>
        </section>
    </main>

    <!-- Tabs JS -->
    <script src="/js/profile/editProfileTabs.js"></script>
</body>
</html>