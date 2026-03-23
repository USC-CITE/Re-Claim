<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
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

    <main class="max-w-5xl mx-auto mt-16 px-6">
        <!-- Page Header -->
        <header class="pb-4 mb-8">
            <h1 class="text-3xl font-semibold"><a href="/profile">Return to Profile</a> / <span id="page-title"></span></h1>
            <p class="text-md mt-1 text-gray-700">Update your user profile and contact information</p>
        </header>

        <!-- Tab Buttons -->
        <nav>
            <button type="button" class="tab-btn" data-tab="edit-profile" data-title="Edit Profile">Edit Profile</button>
            <button type="button" class="tab-btn" data-tab="change-pass" data-title="Change Password">Change Password</button>
            <button type="button" class="tab-btn" data-tab="privacy" data-title="Privacy Security">Privacy Security</button>
        </nav>

        <!-- Tab Contents -->
        <section class="tab-content" id="edit-profile">
            <!-- Unified Form for Edit Profile -->
            <form action="/profile/edit" method="post" enctype="multipart/form-data">

                <!-- Avatar -->
                <div>
                    <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '/avatars/default.png') ?>" width="100">
                </div>

                <!-- Upload -->
                <input type="file" name="avatar" accept="image/*">

                <!-- Delete checkbox -->
                <label>
                    <!-- More specific label rather than just 'delete' -->
                    <input type="checkbox" name="delete_avatar">
                    Remove current avatar
                </label>

                <!-- Name -->
                <section>
                    <label>First Name</label>
                    <input name="first_name" value="<?= htmlspecialchars($_SESSION['first_name'] ?? '') ?>">

                    <label>Last Name</label>
                    <input name="last_name" value="<?= htmlspecialchars($_SESSION['last_name'] ?? '') ?>">
                </section>

                <!-- Contact -->
                <section>
                    <label>Mobile Number</label>
                    <input name="phone_number" value="<?= htmlspecialchars($_SESSION['phone_number'] ?? '') ?>">

                    <label>Social Link</label>
                    <input name="social_link" value="<?= htmlspecialchars($_SESSION['social_link'] ?? '') ?>">
                </section>

                <button type="submit">Save Profile</button>
            </form>

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