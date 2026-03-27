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
        .js .tab-btn.active { 
            color: #044177; 
            border-bottom: 2px solid #044177; 
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
        <nav class="flex gap-6 sm:gap-12 pl-6 border-b border-gray-400 pb-4 mb-6 overflow-x-auto whitespace-nowrap">
            <button type="button" class="tab-btn shrink-0 py-2 text-md font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="edit-profile" data-title="Edit Profile">Edit Profile</button>
            <button type="button" class="tab-btn shrink-0 py-2 text-md font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="change-pass" data-title="Change Password">Change Password</button>
            <button type="button" class="tab-btn shrink-0 py-2 text-md font-semibold text-gray-600 border-b-2 border-transparent hover:text-gray-800 hover:border-gray-300 transition" data-tab="privacy" data-title="Privacy Security">Privacy Security</button>
        </nav>

        <!-- Tab Contents -->
        <section class="tab-content active max-w-2xl mx-auto" id="edit-profile">
            <!-- Unified Form for Edit Profile -->
            <form action="/profile/edit" method="post" enctype="multipart/form-data" class="space-y-10 mb-6">

                <!-- Avatar -->
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden ring-2 ring-gray-200">
                        <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '/avatars/default.png') ?>"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="flex flex-col gap-2">
                        <!-- Upload Avatar -->
                        <input type="file" name="avatar" class="text-sm">

                        <!-- Delete checkbox -->
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <!-- More specific label rather than just 'delete' -->
                            <input type="checkbox" name="delete_avatar">
                            Remove current avatar
                        </label>
                    </div>
                </div>

                <!-- Name -->
                <section>
                    <h2 class="text-lg font-semibold border-b border-gray-400 pb-2 mb-4 text-gray-600">
                        Update Name
                    </h2>
                    <div  class="space-y-4">
                        <div class="flex flex-col">
                            <label class="text-md font-medium">First Name</label>
                            <input class="w-full mt-1 border rounded-lg px-3 py-2 border-gray-300 text-sm" name="first_name" value="<?= htmlspecialchars($_SESSION['first_name'] ?? '') ?>">
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="text-md font-medium">Last Name</label>
                            <input name="last_name" class="w-full mt-1 border rounded-lg px-3 py-2 border-gray-300 text-sm" value="<?= htmlspecialchars($_SESSION['last_name'] ?? '') ?>">
                        </div>  
                        
                    </div>
                    
                </section>

                <!-- Contact -->
                <section>
                    <h2 class="text-lg font-semibold border-b border-gray-400 pb-2 mb-4 text-gray-600">
                        Update Contact Details
                    </h2>

                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <label  class="text-md font-medium">Mobile Number</label>
                            <input name="phone_number" class="w-full mt-1 border rounded-lg px-3 py-2 border-gray-300 text-sm" value="<?= htmlspecialchars($_SESSION['phone_number'] ?? '') ?>">
                        </div>
                        <div class="flex flex-col">
                            <label  class="text-md font-medium">Social Link</label>
                            <input name="social_link" class="w-full mt-1 border rounded-lg px-3 py-2 border-gray-300 text-sm" value="<?= htmlspecialchars($_SESSION['social_link'] ?? '') ?>">
                        </div>
                    </div>
                    
                </section>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-5 py-2 text-md font-semibold bg-[#055BA8] text-white rounded-xl hover:bg-blue-700 transition">
                        Save Profile
                    </button>
                </div>
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