<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Profile</title>

  <!-- FONTS -->
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet" />

  <!-- Tailwind CDN (IMPORTANT DAW NI) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background: url('images/background.svg') no-repeat center center fixed;
      background-size: cover;
      transition: background 0.5s ease;
    }

    body.dark-mode {
      background: url('images/darkmode-background.svg') no-repeat center center fixed;
      background-size: cover;
    }

    body.dark-mode .sidebar {
      background-color: #3F4E67;
    }

    body.dark-mode .background-wrapper {
      background-color: #293241;
    }

    body.dark-mode .inner-wrapper {
      background-color: #797979;
    }
  </style>
</head>
<body class="font-sans m-0 p-0">
  <div class="container flex flex-row-reverse h-screen">

<!-- SIDE BAR -->
    <div class="sidebar fixed top-0 right-0 flex flex-col items-center pt-5 gap-5 w-[70px] bg-[#F1F2F6] rounded-bl-[40px] rounded-br-[40px] transition-colors duration-500">
      <img src="images/home.svg" alt="Home" class="w-[30px] h-[30px] cursor-pointer" onclick="location.href='/dashboard'" />
      <img src="images/bell.svg" alt="Notifications" class="w-[30px] h-[30px] cursor-pointer" onclick="location.href='/notification'" />
      <img src="images/calendar.svg" alt="Calendar" class="w-[30px] h-[30px] cursor-pointer" />
      <img src="images/user.svg" alt="Profile" class="w-[30px] h-[30px] cursor-pointer" onclick="location.href='/user'" />
      <div class="plus-icon w-[80px] h-[80px] bg-[#5B84AE] rounded-full flex items-center justify-center relative right-5 cursor-pointer" onclick="location.href='/tasks'">
        <img src="images/add.svg" alt="Add" class="w-[30px] h-[30px]" />
      </div>
      <img id="theme-toggle" src="images/moon.svg" alt="Dark Mode" class="w-[30px] h-[30px] cursor-pointer" />
    </div>

    <main class="main flex-1 flex justify-start items-center p-[40px]">
      <section class="background-wrapper bg-white rounded-[30px] w-full max-w-[1400px] transition-colors duration-500 p-[60px]">
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
                <button class="orange-button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#F16D45] text-white font-bold" onclick="location.href='/change-password'">Change Password</button>
                <button class="border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-red-600 text-white font-bold" onclick="handleDelete()">Delete Account</button>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#C41E3A] text-white font-bold">
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

<!-- PROFILE PIC VIEW -->
  <div id="image-popup" class="fixed inset-0 bg-black bg-opacity-70 hidden z-50 flex items-center justify-center">
    <div class="relative bg-white rounded-lg shadow-lg p-4 max-w-[90%] max-h-[90%] flex items-center justify-center">
      <button onclick="closeImagePopup()" class="absolute top-2 right-2 text-white bg-gray-700 hover:bg-gray-900 rounded-full w-8 h-8 flex items-center justify-center">&times;</button>
      <img id="popup-image" src="images/default-avatar.png" alt="Full Profile Image" class="max-w-full max-h-[80vh] rounded" />
    </div>
  </div>

<!-- DELETEE -->
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

<!-- js -->
  <script>
    const emailField = document.getElementById('email');
    const toggleEmailBtn = document.getElementById('toggle-email');
    const fields = ['username', 'description'];
    let currentEmail = 'jarod@gmail.com';
    let isEmailVisible = false;
    const themeToggle = document.getElementById('theme-toggle');

    function enableEdit() {
      fields.forEach((id) => {
        const field = document.getElementById(id);
        field.removeAttribute('readonly');
        field.classList.remove('bg-gray-200', 'cursor-default');
      });
      document.getElementById('save-button').classList.remove('hidden');
      document.getElementById('edit-btn').classList.add('hidden');
      document.getElementById('edit-note').classList.remove('hidden');
    }

    function saveDetails() {
      fields.forEach((id) => {
        const field = document.getElementById(id);
        field.setAttribute('readonly', true);
        field.classList.add('bg-gray-200', 'cursor-default');
      });
      document.getElementById('save-button').classList.add('hidden');
      document.getElementById('edit-btn').classList.remove('hidden');
      document.getElementById('edit-note').classList.add('hidden');
    }

    function maskEmail(email) {
      const [name, domain] = email.split('@');
      if (name.length <= 2) return email;
      return name[0] + '*'.repeat(name.length - 2) + name[name.length - 1] + '@' + domain;
    }

    function updateEmailField() {
      emailField.value = isEmailVisible ? currentEmail : maskEmail(currentEmail);
      toggleEmailBtn.textContent = isEmailVisible ? 'Hide' : 'Show';
    }

    toggleEmailBtn.addEventListener('click', () => {
      isEmailVisible = !isEmailVisible;
      updateEmailField();
    });

    updateEmailField();

    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      themeToggle.src = document.body.classList.contains('dark-mode') ? 'images/sun.svg' : 'images/moon.svg';
    });

    const fileInput = document.getElementById('pic-upload');
    const profilePic = document.getElementById('profile-pic');

    fileInput.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (e) => {
        profilePic.src = e.target.result;
        document.getElementById('popup-image').src = e.target.result;
      };
      reader.readAsDataURL(file);
    });

    const deletePopup = document.getElementById('delete-popup');
const deletePassword = document.getElementById('delete-password');
const confirmCheckbox = document.getElementById('confirm-checkbox');
const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
let countdownInterval;
let countdown = 10;

function handleDelete() {
  deletePassword.value = '';
  confirmCheckbox.checked = false;
  confirmDeleteBtn.disabled = true;
  confirmDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
  confirmDeleteBtn.textContent = `Delete Account (${countdown})`;

  deletePopup.classList.remove('hidden');


  countdown = 10;
  countdownInterval = setInterval(() => {
    countdown--;
    confirmDeleteBtn.textContent = `Delete Account (DIli pani mo work) (${countdown})`;
    if (countdown <= 0) {
      confirmDeleteBtn.textContent = 'Delete Account';
      confirmDeleteBtn.disabled = false;
      confirmDeleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
      clearInterval(countdownInterval);
    }
  }, 1000);
}

function closeDeletePopup() {
  deletePopup.classList.add('hidden');
  clearInterval(countdownInterval);
}

function validateDeletePopup() {
  const isPasswordFilled = deletePassword.value.trim().length > 0;
  const isConfirmed = confirmCheckbox.checked;
  confirmDeleteBtn.disabled = !(isPasswordFilled && isConfirmed) || countdown > 0;

  if (confirmDeleteBtn.disabled) {
    confirmDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
  } else {
    confirmDeleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
  }
}

deletePassword.addEventListener('input', validateDeletePopup);
confirmCheckbox.addEventListener('change', validateDeletePopup);

window.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && !deletePopup.classList.contains('hidden')) {
    closeDeletePopup();
  }
});

deletePopup.addEventListener('click', (e) => {
  if (e.target === deletePopup) {
    closeDeletePopup();
  }
});

    function viewImage() {
      const popup = document.getElementById('image-popup');
      document.getElementById('popup-image').src = profilePic.src;
      popup.classList.remove('hidden');
    }

    function closeImagePopup() {
      document.getElementById('image-popup').classList.add('hidden');
    }

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeImagePopup();
    });

    document.getElementById('image-popup').addEventListener('click', (e) => {
      if (e.target.id === 'image-popup') closeImagePopup();
    });
  </script>
</body>
</html>
