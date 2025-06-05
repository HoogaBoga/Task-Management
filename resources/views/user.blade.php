<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Profile</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background: url('images/background.svg') no-repeat center center fixed;
      background-size: cover;
      transition: background 0.5s ease, background-color 0.5s ease; /* Added background-color transition */
    }

    body.dark-mode {
      background: url('images/darkmode-background.svg') no-repeat center center fixed;
      background-size: cover;
    }

    /* Styles for sidebar icons in dark mode if needed, or control via JS/SVG props */
    body.dark-mode #icon-sidebar {
      background-color: #3F4E67; /* Example dark sidebar background */
    }
    body.dark-mode #icon-sidebar a img:not(.icon-filter-to-white) {
      /* Example: make icons lighter in dark mode if they don't adapt automatically */
      /* filter: brightness(0) invert(1); */
    }
     body.dark-mode #icon-sidebar a {
        color: #E0E0E0; /* Lighter text/icon color for dark mode links */
    }
    body.dark-mode #icon-sidebar a:hover {
        background-color: #52617A; /* Darker hover for dark mode */
    }
     body.dark-mode #icon-sidebar a:active {
        background-color: #293241; /* Even darker active for dark mode */
    }


    /* Styles for main content wrappers in dark mode from your original CSS */
    body.dark-mode .background-wrapper {
      background-color: #293241;
    }
    body.dark-mode .inner-wrapper {
      background-color: #797979; /* This was #797979, might need adjustment for text readability */
    }
    body.dark-mode .section-title,
    body.dark-mode label,
    body.dark-mode .top-bar span,
    body.dark-mode #edit-note,
    body.dark-mode input[readonly],
    body.dark-mode textarea[readonly] {
        color: #f0f0f0; /* Lighter text for readability on dark backgrounds */
    }
    body.dark-mode input, body.dark-mode textarea, body.dark-mode select {
        background-color: #3F4E67; /* Darker input backgrounds */
        color: #f0f0f0;
        border-color: #52617A;
    }
    body.dark-mode input::placeholder, body.dark-mode textarea::placeholder {
        color: #a0aec0;
    }


    /* For making dark monochrome icons white (used for the + icon on blue background) */
    .icon-filter-to-white {
        filter: brightness(0) invert(1);
    }
    /* Generic class for main sidebar icons if you need to target them for specific coloring (e.g. if not using currentColor SVGs) */
    .sidebar-icon {
        /* Default color for icons, assuming SVG uses currentColor or this is a placeholder for specific SVG styling */
        color: #4A5568; /* text-slate-700 equivalent */
    }
    .sidebar-icon-hover {
        color: #2563EB; /* text-blue-600 equivalent */
    }
    .sidebar-icon-moon {
        color: #3B82F6; /* text-blue-600 for moon */
    }
    .sidebar-icon-moon-hover {
        color: #1D4ED8; /* text-blue-700 for moon hover */
    }

  </style>
</head>
<body class="font-sans m-0 p-0"> <aside id="icon-sidebar"
         class="hidden md:flex fixed top-16 right-0 w-20 bg-[#F1F2F6] shadow-xl z-30 flex-col items-center justify-between py-6 rounded-l-2xl transition-colors duration-500">
      <div class="flex flex-col items-center space-y-2">
          <a title="Home" href="{{ route('dashboard') }}" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer" onclick="location.href='/dashboard'">
              <img src="images/home2.svg" alt="home" class="w-8 h-8 sidebar-icon group-hover:sidebar-icon-hover">
          </a>
          <a title="Notifications" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer" onclick="location.href='/notification'">
              <img src="images/bell.svg" alt="bell" class="w-8 h-8 sidebar-icon group-hover:sidebar-icon-hover">
          </a>
          <a title="Tasks" href="{{ route('tasks.create') }}" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer" onclick="location.href='/tasks'">
              <img src="images/calendarclock.svg" alt="task" class="w-8 h-8 sidebar-icon group-hover:sidebar-icon-hover">
          </a>
          <a title="User Profile" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer" onclick="location.href='/user'">
              <img src="images/users.svg" alt="profile" class="w-8 h-8 sidebar-icon group-hover:sidebar-icon-hover">
          </a>
      </div>

      <div class="flex flex-col items-center space-y-4">
          <a title="Add New Task" href="{{ route('tasks.create') }}"
             class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 active:bg-blue-800 transition-all duration-150 ease-in-out hover:scale-105 active:scale-95 hover:shadow-xl cursor-pointer" onclick="location.href='/tasks'">
              <img src="images/add.svg" alt="add" class="w-7 h-7 icon-filter-to-white">
          </a>

      </div>
  </aside>

  <div class="container flex flex-row-reverse h-screen">
      <main class="main flex-1 flex justify-start items-center p-[40px] md:mr-20"> <section class="background-wrapper bg-white rounded-[30px] w-full max-w-[1400px] transition-colors duration-500 p-[60px]">
          <div class="inner-wrapper bg-[#E0FBFC] rounded-[20px] p-[30px] transition-colors duration-500">
            <header class="top-bar flex items-center mb-[30px]">
              <img src="images/logo-placeholder.svg" alt="Logo" class="w-[60px] h-[60px]" />
              <span class="ml-[15px] text-[24px]" style="font-family: 'Krona One', sans-serif;">Profile</span>
            </header>
            <div class="top-section flex items-center gap-5 mb-[40px]">
              <div class="avatar w-[100px] h-[100px] rounded-full bg-gray-400 overflow-hidden relative group cursor-pointer">
                <img id="profile-pic" src="images/default-avatar.png" alt="Insert Profile Picture" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-black bg-opacity-50 text-white text-center items-center justify-center hidden group-hover:flex text-sm font-bold" onclick="viewImage()">View Image</div>
              </div>
              <input type="file" id="pic-upload" accept="image/*" class="hidden" />
              <div class="top-buttons flex flex-col gap-2.5">
                <button class="button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#5B84AE] text-white" id="change-pic" onclick="document.getElementById('pic-upload').click()">Change Pic</button>
                <button class="edit-button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-gray-300 text-gray-600" id="edit-btn" onclick="enableEdit()">Edit Details</button>
                <div id="edit-note" class="hidden text-center font-bold text-black my-2.5">Once done, press the "Save Details" button below.</div>
              </div>
            </div>

            <div class="content flex gap-10">
              <div class="left flex-1">
                <h2 class="section-title text-[18px] font-bold mb-2.5">Account Details</h2>
                <div class="section mb-5">
                  <label class="block mb-1 font-bold" for="username">Username:</label>
                  <input type="text" id="username" value="Big Daddy" readonly class="w-full p-2 rounded border border-gray-300 text-[14px] bg-gray-200 cursor-default" />
                </div>
                <div class="section mb-5">
                  <label class="block mb-1 font-bold" for="email">Email:</label>
                  <div class="relative flex items-center">
                    <input type="text" id="email" readonly class="w-full p-2 rounded border border-gray-300 text-[14px] bg-gray-200 cursor-default pr-24" />
                    <button type="button" id="toggle-email" class="ml-2 absolute right-2 text-sm text-blue-600 underline">Show</button>
                  </div>
                </div>
                <div class="section mb-5">
                  <label class="block mb-1 font-bold" for="description">Description:</label>
                  <textarea id="description" rows="4" readonly class="w-full p-2 rounded border border-gray-300 text-[14px] bg-gray-200 cursor-default resize-none">UI, chief, leader, alpha wolf, sigma</textarea>
                </div>
              </div>
              <div class="right flex-1">
                <h2 class="section-title text-[18px] font-bold mb-2.5">Control</h2>
                <div class="customization flex flex-col gap-2.5">
                  <button class="orange-button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#F16D45] text-white font-bold" onclick="location.href='change-password'">Change Password</button>
                  <button class="border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-red-600 text-white font-bold" onclick="handleDelete()">Delete Account</button>
                  <form method="POST" action="{{-- route('logout') --}}" class="inline"> @csrf
                      <button type="submit" class="border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#C41E3A] text-white font-bold">
                          Logout
                      </button>
                  </form>
                  <button class="save-button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#5B84AE] text-white hidden" id="save-button" onclick="saveDetails()">Save Details</button>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
  </div>

<div id="image-popup" class="fixed inset-0 bg-black bg-opacity-70 hidden z-50 flex items-center justify-center">
    <div class="relative bg-white rounded-lg shadow-lg p-4 max-w-[90%] max-h-[90%] flex items-center justify-center">
      <button onclick="closeImagePopup()" class="absolute top-2 right-2 text-white bg-gray-700 hover:bg-gray-900 rounded-full w-8 h-8 flex items-center justify-center">&times;</button>
      <img id="popup-image" src="images/default-avatar.png" alt="Full Profile Image" class="max-w-full max-h-[80vh] rounded" />
    </div>
  </div>

<div id="delete-popup" class="fixed inset-0 bg-black bg-opacity-70 hidden z-60 flex items-center justify-center">
  <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative">
    <button onclick="closeDeletePopup()" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 font-bold text-2xl">&times;</button>
    <h3 class="text-lg font-bold mb-4">Confirm Account Deletion</h3>
    <p class="mb-4 text-sm">Please enter your password and confirm before deleting your account. This action is irreversible.</p>
    <input id="delete-password" type="password" placeholder="Password" class="w-full p-2 border border-gray-300 rounded mb-3" />
    <label class="inline-flex items-center mb-4">
      <input type="checkbox" id="confirm-checkbox" class="mr-2" />
      <span>I understand that deleting my account is irreversible</span>
    </label>
    <button id="confirm-delete-btn" disabled class="w-full bg-red-600 text-white py-2 rounded font-bold opacity-50 cursor-not-allowed">
      Delete Account (10)
    </button>
  </div>
</div>

<script>
    const emailField = document.getElementById('email');
    const toggleEmailBtn = document.getElementById('toggle-email');
    const fields = ['username', 'description'];
    let currentEmail = 'jarod@gmail.com'; // Example email, replace with dynamic data if needed
    let isEmailVisible = false;
    const themeToggle = document.getElementById('theme-toggle'); // This ID is on the moon/sun icon in the new sidebar

    function enableEdit() {
      fields.forEach((id) => {
        const field = document.getElementById(id);
        field.removeAttribute('readonly');
        field.classList.remove('bg-gray-200', 'cursor-default');
        field.classList.add('bg-white'); // Change to white for editing
      });
      document.getElementById('save-button').classList.remove('hidden');
      document.getElementById('edit-btn').classList.add('hidden');
      document.getElementById('edit-note').classList.remove('hidden');
    }

    function saveDetails() {
      fields.forEach((id) => {
        const field = document.getElementById(id);
        field.setAttribute('readonly', true);
        field.classList.remove('bg-white');
        field.classList.add('bg-gray-200', 'cursor-default');
      });
      document.getElementById('save-button').classList.add('hidden');
      document.getElementById('edit-btn').classList.remove('hidden');
      document.getElementById('edit-note').classList.add('hidden');
      // Add AJAX call here to save data to the server if needed
      alert('Details saved (locally)!'); // Placeholder
    }

    function maskEmail(email) {
      if (!email || !email.includes('@')) return 'email@example.com'; // Basic validation
      const [name, domain] = email.split('@');
      if (name.length <= 2) return email;
      return name[0] + '*'.repeat(name.length - 2) + name[name.length - 1] + '@' + domain;
    }

    function updateEmailField() {
      emailField.value = isEmailVisible ? currentEmail : maskEmail(currentEmail);
      toggleEmailBtn.textContent = isEmailVisible ? 'Hide' : 'Show';
    }

    if(toggleEmailBtn && emailField){ // Check if elements exist
        toggleEmailBtn.addEventListener('click', () => {
          isEmailVisible = !isEmailVisible;
          updateEmailField();
        });
        updateEmailField(); // Initial mask/display
    }


    if (themeToggle) { // Check if themeToggle element exists
        themeToggle.addEventListener('click', () => {
          document.body.classList.toggle('dark-mode');
          // Update theme toggle icon src
          if (document.body.classList.contains('dark-mode')) {
            themeToggle.src = 'images/sun.svg'; // Path to sun icon for dark mode
            themeToggle.alt = 'Toggle Light Mode';
          } else {
            themeToggle.src = 'images/moon.svg'; // Path to moon icon for light mode
            themeToggle.alt = 'Toggle Dark Mode';
          }
        });
         // Set initial icon based on current mode (e.g. if dark mode is saved in localStorage)
        if (document.body.classList.contains('dark-mode')) {
            themeToggle.src = 'images/sun.svg';
            themeToggle.alt = 'Toggle Light Mode';
        } else {
            themeToggle.src = 'images/moon.svg';
            themeToggle.alt = 'Toggle Dark Mode';
        }
    }


    const fileInput = document.getElementById('pic-upload');
    const profilePic = document.getElementById('profile-pic');
    const popupImage = document.getElementById('popup-image');


    if(fileInput && profilePic && popupImage) { // Check if elements exist
        fileInput.addEventListener('change', (e) => {
          const file = e.target.files[0];
          if (!file) return;
          const reader = new FileReader();
          reader.onload = (event) => { // Changed e to event to avoid conflict
            profilePic.src = event.target.result;
            popupImage.src = event.target.result; // Update popup image as well
          };
          reader.readAsDataURL(file);
        });
    }


    const deletePopup = document.getElementById('delete-popup');
    const deletePassword = document.getElementById('delete-password');
    const confirmCheckbox = document.getElementById('confirm-checkbox');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    let countdownInterval;
    let countdown = 10;

    function handleDelete() {
      if(!deletePopup || !deletePassword || !confirmCheckbox || !confirmDeleteBtn) return; // Guard clause

      deletePassword.value = '';
      confirmCheckbox.checked = false;
      countdown = 10; // Reset countdown
      confirmDeleteBtn.textContent = `Delete Account (${countdown})`;
      confirmDeleteBtn.disabled = true;
      confirmDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');

      deletePopup.classList.remove('hidden');

      // Clear any existing interval before starting a new one
      if(countdownInterval) clearInterval(countdownInterval);

      countdownInterval = setInterval(() => {
        countdown--;
        if (countdown > 0) {
            confirmDeleteBtn.textContent = `Delete Account (${countdown})`;
        } else {
            confirmDeleteBtn.textContent = 'Delete Account';
            // Only enable if checkbox and password conditions are also met at this point
            validateDeletePopup(); // Re-validate to enable button if conditions met
            clearInterval(countdownInterval);
        }
      }, 1000);
      validateDeletePopup(); // Initial validation state
    }

    function closeDeletePopup() {
      if(!deletePopup) return;
      deletePopup.classList.add('hidden');
      clearInterval(countdownInterval);
    }

    function validateDeletePopup() {
      if(!deletePassword || !confirmCheckbox || !confirmDeleteBtn) return; // Guard clause
      const isPasswordFilled = deletePassword.value.trim().length > 0;
      const isConfirmed = confirmCheckbox.checked;

      if (isPasswordFilled && isConfirmed && countdown <= 0) {
        confirmDeleteBtn.disabled = false;
        confirmDeleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
      } else {
        confirmDeleteBtn.disabled = true;
        confirmDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
        if(countdown > 0 && confirmDeleteBtn.textContent.startsWith("Delete Account (")) {
            // Keep countdown text if button is disabled due to countdown
        } else if (countdown > 0) {
             confirmDeleteBtn.textContent = `Delete Account (${countdown})`;
        }
         else {
            confirmDeleteBtn.textContent = 'Delete Account'; // Default text if not counting down
        }
      }
    }
    if(deletePassword) deletePassword.addEventListener('input', validateDeletePopup);
    if(confirmCheckbox) confirmCheckbox.addEventListener('change', validateDeletePopup);


    // Image Popup JS
    const imagePopup = document.getElementById('image-popup');

    function viewImage() {
      if(imagePopup && profilePic && popupImage) {
        popupImage.src = profilePic.src;
        imagePopup.classList.remove('hidden');
      }
    }

    function closeImagePopup() {
      if(imagePopup) imagePopup.classList.add('hidden');
    }

    // Global event listeners (ensure elements exist where relevant)
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        if (imagePopup && !imagePopup.classList.contains('hidden')) {
            closeImagePopup();
        }
        if (deletePopup && !deletePopup.classList.contains('hidden')) {
            closeDeletePopup();
        }
      }
    });

    if(imagePopup) {
        imagePopup.addEventListener('click', (e) => {
          if (e.target === imagePopup) closeImagePopup(); // Close if backdrop is clicked
        });
    }
    if(deletePopup) {
        deletePopup.addEventListener('click', (e) => {
          if (e.target === deletePopup) closeDeletePopup(); // Close if backdrop is clicked
        });
    }

  </script>
</body>
</html>
