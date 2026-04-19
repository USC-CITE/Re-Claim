<?php
    $errors = $_SESSION['errors'] ?? [];
    $flash = $_SESSION['flash'] ?? null;
    $flashOtp = $_SESSION['flash-otp'] ?? null;
    $showOtpModal = $_SESSION['show_otp_modal'] ?? false;

    unset($_SESSION['show_otp_modal']);
    unset($_SESSION['errors']);
    unset($_SESSION['flash']);
?>
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

        const originalAvatar = "<?= htmlspecialchars($_SESSION['avatar'] ?? '/avatars/default.png') ?>";
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

        /* Hide scrollbar for Chrome, Safari and Opera */ 
        .no-scrollbar::-webkit-scrollbar { 
            display: none; 
        } 
        /* Hide scrollbar for IE, Edge and Firefox */ 
        .no-scrollbar { 
            -ms-overflow-style: none; /* IE and Edge */ 
            scrollbar-width: none; /* Firefox */ 
        }
    </style>
</head>
<body>
    
    <?php require __DIR__  . "/../mainpages/header.php"; ?>

    <main class="max-w-5xl mx-auto mt-16 px-6">
        <?php if (!empty($flash) && !empty($flash['success'])): ?>
            <div class="mb-4 max-w-2xl mx-auto p-3 bg-green-100 text-green-700 rounded-lg">
                <?= htmlspecialchars($flash['success']) ?>
            </div>

        <?php elseif (!empty($flash) && !empty($flash['error'])): ?>
            <div class="mb-4 max-w-2xl mx-auto p-3 bg-red-100 text-red-700 rounded-lg">
                <?= htmlspecialchars($flash['error']) ?>
            </div>
        <?php endif; ?>
        
        <!-- Page Header -->
        <header class="pb-4 mb-8">                
            <a class="flex gap-2 text-md font-semibold text-[#5B5B5B] mb-6" href="/profile">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.63556 11.2927C3.44809 11.4802 3.34277 11.7345 3.34277 11.9997C3.34277 12.2648 3.44809 12.5191 3.63556 12.7067L9.29256 18.3637C9.38481 18.4592 9.49515 18.5353 9.61716 18.5878C9.73916 18.6402 9.87038 18.6678 10.0032 18.6689C10.1359 18.6701 10.2676 18.6448 10.3905 18.5945C10.5134 18.5442 10.6251 18.4699 10.719 18.3761C10.8128 18.2822 10.8871 18.1705 10.9374 18.0476C10.9877 17.9247 11.013 17.793 11.0118 17.6603C11.0107 17.5275 10.9831 17.3963 10.9307 17.2743C10.8783 17.1522 10.8021 17.0419 10.7066 16.9497L6.75656 12.9997L19.9996 12.9997C20.2648 12.9997 20.5191 12.8943 20.7067 12.7068C20.8942 12.5192 20.9996 12.2649 20.9996 11.9997C20.9996 11.7344 20.8942 11.4801 20.7067 11.2926C20.5191 11.105 20.2648 10.9997 19.9996 10.9997L6.75656 10.9997L10.7066 7.04966C10.8887 6.86105 10.9895 6.60845 10.9872 6.34626C10.985 6.08406 10.8798 5.83325 10.6944 5.64784C10.509 5.46243 10.2582 5.35726 9.99596 5.35498C9.73376 5.3527 9.48116 5.4535 9.29256 5.63566L3.63556 11.2927Z" fill="#5B5B5B"/>
                </svg>
                 Return to Profile
            </a>
            <h1 class="text-4xl font-semibold">Account Settings</h1>
        </header>

        <!-- Tab Buttons -->
        <nav class="relative w-full border-b border-gray-400 pb-4 mb-6">
            <div class="flex justify-center sm:justify-start">
                <div id="tabScrollSettings"
                    class="flex flex-nowrap overflow-x-auto gap-12 sm:gap-12 no-scrollbar whitespace-nowrap px-4">

                    <button type="button" class="tab-btn shrink-0 py-2 text-md font-semibold text-gray-600 border-b-2 border-transparent hover:border-gray-300 transition"
                        data-tab="edit-profile" data-title="Edit Profile">
                        Edit Profile
                    </button>

                    <button type="button" class="tab-btn shrink-0 py-2 text-md font-semibold text-gray-600 border-b-2 border-transparent hover:border-gray-300 transition"
                        data-tab="change-pass" data-title="Change Password">
                        Change Password
                    </button>

                    <button type="button" class="tab-btn shrink-0 py-2 text-md font-semibold text-gray-600 border-b-2 border-transparent hover:border-gray-300 transition"
                        data-tab="delete-account" data-title="Delete Account">
                        Delete Account
                    </button>

                </div>
            </div>
        </nav>

        <!-- Tab Contents -->
        <section class="tab-content active max-w-2xl mx-auto" id="edit-profile">
            <!-- Unified Form for Edit Profile -->
            <form action="/profile/edit" method="post" enctype="multipart/form-data" class="space-y-10 mb-6">
                
                <?php \App\Core\Router::setCsrf(); ?>
                <!-- Avatar -->
                <div class="flex flex-col items-left gap-6 sm:flex-row sm:items-center">
                    <div class="w-24 h-24 rounded-full overflow-hidden ring-2 ring-gray-200">
                        <img id="avatarPreview" src="<?= htmlspecialchars($_SESSION['avatar'] ?? '/avatars/default.png') ?>"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="flex gap-4">
                        <div class="flex flex-col gap-2">
                            <!-- Upload Avatar -->
                            <!-- Hidden file input -->
                            <input type="file" name="avatar" id="avatarInput" class="absolute opacity-0 w-0 h-0">

                            <!-- Styled button -->
                            <label for="avatarInput"
                                tabindex="0"
                                class="flex gap-2 items-center px-4 py-2 text-md font-semibold border border-gray-800 rounded-xl cursor-pointer hover:bg-gray-300 transition text-center">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0C7.55228 0 8 0.447715 8 1V6H13C13.5523 6 14 6.44772 14 7C14 7.55228 13.5523 8 13 8H8V13C8 13.5523 7.55228 14 7 14C6.44772 14 6 13.5523 6 13V8H1C0.447715 8 0 7.55228 0 7C0 6.44771 0.447715 6 1 6L6 6V1C6 0.447715 6.44772 0 7 0Z" fill="#111827"/>
                                </svg>
                                Upload Picture
                            </label>

                            <span id="file-name" class="text-xs truncate w-40 block text-gray-500"></span>
                        </div>
                        
                        <!-- Hidden input to track delete action -->
                        <input type="hidden" name="delete_avatar" id="deleteAvatarInput" value="0">
                        <div>
                            <!-- Delete Button -->
                            <button type="button"
                                id="deleteAvatarBtn"
                                 <?= (!isset($_SESSION['avatar']) || $_SESSION['avatar'] === '/avatars/default.png') ? 'disabled' : '' ?>
                                class="px-4 py-2 text-md font-semibold border border-gray-800 rounded-xl transition text-center
                                <?= (!isset($_SESSION['avatar']) || $_SESSION['avatar'] === '/avatars/default.png') ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-200' ?>">
                                Remove Avatar
                                
                            </button>
                        </div>
                        
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
                            <input class="w-full mt-1 border rounded-lg px-3 py-2  <?= !empty($errors['first_name']) ? 'border-red-500 border-2' : 'border-gray-300' ?> text-sm" name="first_name" value="<?= htmlspecialchars($_SESSION['first_name'] ?? '') ?>">
                            <p class="text-red-500 text-sm">
                                <?= isset($errors['first_name']) ? '✕ ' . $errors['first_name'] : ''?>
                            </p>
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="text-md font-medium">Last Name</label>
                            <input name="last_name" class="w-full mt-1 border rounded-lg px-3 py-2  <?= !empty($errors['last_name']) ? 'border-red-500 border-2' : 'border-gray-300' ?>text-sm" value="<?= htmlspecialchars($_SESSION['last_name'] ?? '') ?>">
                            <p class="text-red-500 text-sm">
                                <?= isset($errors['last_name']) ? '✕ ' . $errors['last_name'] : ''?>
                            </p>
                        </div>  
                        
                    </div>
                    
                </section>

                <!-- Contact -->
                <section>
                    <h2 class="text-lg font-semibold border-b border-gray-400 pb-2 mb-4 text-gray-600">
                        Update Contact Details
                    </h2>

                    <div class="space-y-6">

                        <!-- Mobile Number -->
                        <div class="flex flex-col">
                            <label class="text-md font-medium">Mobile Number</label>
                            <input name="phone_number"
                                class="w-full mt-1 border rounded-lg px-3 py-2 <?= !empty($errors['phone_number']) ? 'border-red-500 border-2' : 'border-gray-300' ?> text-sm"
                                value="<?= htmlspecialchars($_SESSION['phone_number'] ?? '') ?>">
                            <p class="text-red-500 text-sm">
                                <?= isset($errors['phone_number']) ? '✕ ' . $errors['phone_number'] : ''?>
                            </p>
                        </div>

                        <!-- MAIN SOCIAL LINK -->
                        <div class="flex flex-col">
                            <label class="text-md font-medium">Link to Social Account</label>
                            <input name="social_link"
                                class="w-full mt-1 border rounded-lg px-3 py-2 <?= !empty($errors['social_link']) ? 'border-red-500 border-2' : 'border-gray-300' ?> text-sm "
                                value="<?= htmlspecialchars($_SESSION['social_link'] ?? '') ?>">
                            <p class="text-red-500 text-sm">
                                <?= isset($errors['social_link']) ? '✕ ' . $errors['social_link'] : ''?>
                            </p>
                        </div>

                        <!-- ADDITIONAL SOCIAL LINKS -->
                        <div class="flex flex-col">
                            <label class="text-md font-medium">Other Social Accounts</label>

                            <?php
                                $links = $_SESSION['social_links'] ?? [];
                                if (!is_array($links)) {
                                    $links = json_decode($links, true) ?? [];
                                }
                            ?>

                            <div id="socialLinksContainer" class="space-y-2 mt-2">

                                <?php foreach ($links as $i => $link): ?>
                                    <div class="flex gap-2">
                                        <input type="text"
                                            name="social_links[]"
                                            value="<?= htmlspecialchars($link) ?>"
                                            class="w-full border rounded-lg px-3 py-2 border-gray-300 text-sm">

                                        <button type="button"
                                            onclick="removeLink(this)"
                                            class="px-3 py-2 border rounded-lg text-sm hover:bg-red-100">
                                            ✕
                                        </button>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <button type="button"
                                id="addLinkBtn"
                                onclick="addLink()"
                                class="flex gap-2 mt-2 items-center px-4 py-2 text-md w-fit font-semibold border border-gray-800 rounded-xl cursor-pointer hover:bg-gray-300 transition text-center">
                                + Add another social media account
                            </button>
                        </div>

                    </div>
                    
                </section>
                
                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="button"
                        id="cancelBtn"
                        class="px-5 py-2 text-md mr-4 font-semibold border border-gray-400 rounded-xl hover:bg-gray-100 transition">
                        Cancel
                    </button>
                                    
                    <button type="submit"
                        class="px-5 py-2 text-md font-semibold bg-[#055BA8] text-white rounded-xl hover:bg-blue-700 transition">
                        Save Profile
                    </button>

                </div>
            </form>

        </section>

        <section class="tab-content max-w-2xl mx-auto" id="change-pass">
            <form action="/profile/change-password" method="post" class="space-y-6 mb-2 mt-8">
                <p class="text-sm mb-4">A verification email will be sent once all fields are correctly filled out.</p>

                <!-- Main Section -->
                <div class="space-y-6">
                    <!-- Current Password -->
                    <div class="flex flex-col">
                        <label class="text-md" >Current Password</label>
                        <input name="current_password" type="password" class="w-full mt-1 border rounded-lg px-3 py-2 <?= !empty($errors['current_password']) ? 'border-red-500 border-2' : 'border-gray-300' ?> text-sm" autocomplete="current-password"required>
                        <p class="text-red-500 text-sm">
                            <?= isset($errors['current_password']['error']) ? '✕ ' . $errors['current_password']['error'] : ''?>
                        </p>
                    </div>
                    
                    <!-- New Password -->
                    <div class="flex flex-col">
                        <label class="text-md">New Password</label>
                        <input name="new_password" type="password" class="w-full mt-1 border rounded-lg px-3 py-2 <?= !empty($errors['new_password']) ? 'border-red-500 border-2' : 'border-gray-300' ?> text-sm" autocomplete="new-password" required>
                        <p class="text-red-500 text-sm">
                            <?= isset($errors['new_password']['error']) ? '✕ ' . $errors['new_password']['error'] : ''?>
                        </p>
                    </div>

                    <!-- Confirm Password -->   
                    <div class="flex flex-col">
                        <label class="text-md">Confirm Password</label>
                        <input name="confirm_password" type="password" class="w-full mt-1 border rounded-lg px-3 py-2 <?= !empty($errors['confirm_password']) ? 'border-red-500 border-2' : 'border-gray-300' ?> text-sm" required>
                        <p class="text-red-500 text-sm">
                            <?= isset($errors['confirm_password']['error']) ? '✕ ' . $errors['confirm_password']['error'] : '' ?>
                        </p>
                    </div>
                </div>
                
                  <!-- Change Pass Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-5 py-2 text-md mt-6 font-semibold bg-[#055BA8] text-white rounded-xl hover:bg-blue-700 transition">
                        Change Password
                    </button>
                </div>
            </form>
        </section>

        <section class="tab-content max-w-2xl mx-auto" id="delete-account">
            <form action="/profile/delete" method="post" class="space-y-2">
                <?php \App\Core\Router::setCsrf(); ?>
                <p>Deleting your account will permanently remove your Re:Claim profile and all associated content. This action will be irreversible. </p>
                <div class="flex justify-start">
                    <button type="submit"
                        onclick="return confirm('Are you sure? This action cannot be undone.')"
                        class="px-5 py-2 text-md mt-6 font-semibold bg-[#DE3D31] text-white rounded-xl hover:text-gray-200 transition">
                        Delete Account
                    </button>
                </div>
            </form>
        </section>
         
       
    </main>

    <!-- Tabs JS -->
    <script src="/js/profile/editProfileTabs.js" defer></script>
     <!-- Verification Code Modal -->
        <div id="otpModal" class="fixed p-2 inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 <?=  $showOtpModal ? '' : 'hidden' ?>">
            
        <!-- Modal Contents -->
            <div class="bg-white p-8  max-w-2xl w-fit rounded-3xl relative">
                <button id="closeModal" class="absolute top-3 right-4 text-gray-600 hover:text-black text-lg">
                    ✕
                </button>
                <div class="flex flex-col items-center text-center space-y-3 mb-6">

                <!-- Logo -->
                <div class="w-20 h-20 rounded-full bg-[#055BA8] flex items-center justify-center">
                    <svg width="40" height="39" viewBox="0 0 40 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.5 33.4082V15.1392C1.5 13.7711 2.18697 12.4936 3.33068 11.7347L17.7196 2.18721C19.1005 1.27093 20.8995 1.27093 22.2804 2.18721L36.6693 11.7347C37.813 12.4936 38.5 13.7711 38.5 15.1392V33.4082M1.5 33.4082C1.5 35.6681 3.34061 37.5 5.61111 37.5H34.3889C36.6594 37.5 38.5 35.6681 38.5 33.4082M1.5 33.4082L15.375 24.2018M38.5 33.4082L24.625 24.2018M1.5 14.9953L15.375 24.2018M38.5 14.9953L24.625 24.2018M24.625 24.2018L22.2804 25.7574C20.8995 26.6737 19.1005 26.6737 17.7196 25.7574L15.375 24.2018" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <!-- Text Content -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">
                        Enter Verification Code
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        A verification code has been sent to your email.
                    </p>
                </div>
                
                <form action="/profile/change-password/verify" method="POST" class="space-y-2">
                    <input class="w-full mt-1 border rounded-lg px-3 py-2 text-sm <?= !empty($errors['otp']) ? 'border-red-500 border-2' : 'border-gray-300' ?> algin-" placeholder="Enter 6-digit code" name="otp">
                    <p class="text-red-500 text-sm text-left w-full">
                        <?= isset($errors['otp']) ? '✕ ' . $errors['otp'] : '' ?>
                    </p>
                    <button type="submit" class="px-5 flex gap-2 items-center justify-center w-full py-2 text-md mt-6 font-semibold bg-[#055BA8] text-white rounded-xl hover:bg-blue-700 transition">
                        Verify & Change Password 
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.3644 7.37629C17.5519 7.18876 17.6572 6.93445 17.6572 6.66929C17.6572 6.40412 17.5519 6.14982 17.3644 5.96229L11.7074 0.305288C11.6152 0.209778 11.5048 0.133596 11.3828 0.0811866C11.2608 0.0287776 11.1296 0.00119129 10.9968 3.74652e-05C10.8641 -0.00111636 10.7324 0.0241856 10.6095 0.0744665C10.4866 0.124747 10.3749 0.199 10.281 0.292893C10.1872 0.386786 10.1129 0.498437 10.0626 0.621334C10.0123 0.74423 9.98704 0.87591 9.98819 1.00869C9.98934 1.14147 10.0169 1.27269 10.0693 1.39469C10.1217 1.5167 10.1979 1.62704 10.2934 1.71929L14.2434 5.66929L1.00044 5.66929C0.735224 5.66929 0.480869 5.77464 0.293333 5.96218C0.105797 6.14972 0.000440318 6.40407 0.000440306 6.66929C0.000440294 6.9345 0.105796 7.18886 0.293333 7.37639C0.480869 7.56393 0.735223 7.66929 1.00044 7.66929L14.2434 7.66929L10.2934 11.6193C10.1113 11.8079 10.0105 12.0605 10.0128 12.3227C10.015 12.5849 10.1202 12.8357 10.3056 13.0211C10.491 13.2065 10.7418 13.3117 11.004 13.314C11.2662 13.3162 11.5188 13.2154 11.7074 13.0333L17.3644 7.37629Z" fill="white"/>
                        </svg>
                    </button>
                </form>
                
            </div>
        </div> 
                               
</body>
</html>