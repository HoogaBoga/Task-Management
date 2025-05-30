<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Profile</title>
<!-- FONTS -->

  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet" />

<!-- Tailwind CDN (IMPORTANT DAW NI)-->

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

    body.dark-mode
    {
      background: url('images/darkmode-background.svg') no-repeat center center fixed;
      background-size: cover;
    }

    body.dark-mode .sidebar
    {
      background-color: #3F4E67;
    }

    body.dark-mode .background-wrapper
    {
      background-color: #293241;
    }

    body.dark-mode .inner-wrapper
    {
      background-color: #797979;
    }
  </style>
</head>
<body class="font-sans m-0 p-0">
  <div class="container flex flex-row-reverse h-screen">

<!-- SIDE BAR -->

    <div
      class="sidebar fixed top-0 right-0 flex flex-col items-center pt-5 gap-5 w-[70px] bg-[#F1F2F6] rounded-bl-[40px] rounded-br-[40px] transition-colors duration-500"
    >
      <img src="images/home.svg" alt="Home" class="w-[30px] h-[30px] cursor-pointer" onclick="location.href='/home'" />
      <img src="images/bell.svg" alt="Notifications" class="w-[30px] h-[30px] cursor-pointer" onclick="location.href='/notification'" />
      <img src="images/calendar.svg" alt="Calendar" class="w-[30px] h-[30px] cursor-pointer" />
      <img src="images/user.svg" alt="Profile" class="w-[30px] h-[30px] cursor-pointer" onclick="location.href='/user'" />
      <div
        class="plus-icon w-[80px] h-[80px] bg-[#5B84AE] rounded-full flex items-center justify-center relative right-5 cursor-pointer"
        onclick="location.href='/add-task'"
      >
        <img src="images/add.svg" alt="Add" class="w-[30px] h-[30px]" />
      </div>
      <img
        id="theme-toggle"
        src="images/moon.svg"
        alt="Dark Mode"
        class="w-[30px] h-[30px] cursor-pointer"
      />
    </div>

<!-- SQUEARE -->

    <main class="main flex-1 flex justify-start items-start p-[40px]">
      <section
        class="background-wrapper bg-white rounded-[30px] w-full max-w-[1400px] transition-colors duration-500 p-[60px]"
      >
        <div class="inner-wrapper bg-[#E0FBFC] rounded-[20px] p-[30px] transition-colors duration-500">

<!-- LOGO AND "PROFILE" TEXTT -->

          <header class="top-bar flex items-center mb-[30px]">
            <img src="images/logo-placeholder.svg" alt="Logo" class="w-[60px] h-[60px]" />
            <span class="ml-[15px] text-[24px]" style="font-family: 'Krona One', sans-serif;">
              Profile
            </span>
          </header>

<!-- PROFILE PICTURE AND EDIT DETAILS -->

          <div class="top-section flex items-center gap-5 mb-[40px]">
            <div class="avatar w-[100px] h-[100px] rounded-full bg-gray-400 overflow-hidden">
              <img id="profile-pic" src="images/default-avatar.png" alt="Insert Profile Picture" class="w-full h-full object-cover" />
            </div>
            <input type="file" id="pic-upload" accept="image/*" class="hidden" />
            <div class="top-buttons flex flex-col gap-2.5">
              <button
                class="button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#5B84AE] text-white"
                id="change-pic"
                onclick="document.getElementById('pic-upload').click()"
              >
                Change Pic
              </button>
              <button
                class="edit-button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-gray-300 text-gray-600"
                id="edit-btn"
                onclick="enableEdit()"
              >
                Edit Details
              </button>
              <div id="edit-note" class="hidden text-center font-bold text-black my-2.5">
                Once done, press the "Save Details" button below.
              </div>
            </div>
          </div>

          <div class="content flex gap-10">

<!-- ACCOUNT DETAIL SECTION (LEFT SIDE) -->

            <div class="left flex-1">
              <h2 class="section-title text-[18px] font-bold mb-2.5">Account Details</h2>

              <div class="section mb-5">
                <label class="block mb-1 font-bold" for="username">Username:</label>
                <input
                  type="text"
                  id="username"
                  value="Big Daddy"
                  readonly
                  class="w-full p-2 rounded border border-gray-300 text-[14px] bg-gray-200 cursor-default"
                />
              </div>

              <div class="section mb-5">
                <label class="block mb-1 font-bold" for="email">Email:</label>
                <input
                  type="text"
                  id="email"
                  value="j**@gmail.com"
                  readonly
                  class="w-full p-2 rounded border border-gray-300 text-[14px] bg-gray-200 cursor-default"
                />
              </div>

              <div class="section mb-5">
                <label class="block mb-1 font-bold" for="description">Description:</label>
                <textarea
                  id="description"
                  rows="4"
                  readonly
                  class="w-full p-2 rounded border border-gray-300 text-[14px] bg-gray-200 cursor-default resize-none"
                >UI, chief, leader, alpha wolf, sigma</textarea>
              </div>
            </div>

<!-- CUSTOMIZATION SECTION (RIGHT SIDE) -->

            <div class="right flex-1">
              <h2 class="section-title text-[18px] font-bold mb-2.5">Customization</h2>

              <div class="customization flex flex-col gap-2.5">
                <button
  class="orange-button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#F16D45] text-white font-bold"
  onclick="openPasswordModal()"
>
  Change Password
</button>

                <button
                  class="save-button border-0 px-5 py-2.5 rounded-[10px] text-[14px] cursor-pointer w-fit bg-[#5B84AE] text-white hidden"
                  id="save-button"
                  onclick="saveDetails()"
                >
                  Save Details
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

<!-- PASSWORD POP UP -->

<div id="password-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
  <div class="bg-white dark:bg-[#293241] p-8 rounded-xl w-full max-w-md shadow-lg relative">
    <h2 class="text-xl font-bold mb-4 text-center">Change Password</h2>
    <p class="text-center text-sm font-semibold text-gray-500 mb-5">WORK IN PROGRESSSS</p>
    
    <div class="mb-4">
      <label for="old-password" class="block mb-1 font-bold">Old Password</label>
      <input type="password" id="old-password" class="w-full p-2 rounded border border-gray-300" />
    </div>
    <div class="mb-4">
      <label for="new-password" class="block mb-1 font-bold">New Password</label>
      <input type="password" id="new-password" class="w-full p-2 rounded border border-gray-300" />
    </div>

    <div class="flex justify-between items-center mt-6">
      <button onclick="closePasswordModal()" class="px-4 py-2 bg-gray-300 rounded font-semibold">
        Cancel
      </button>
      <button onclick="savePassword()" class="px-4 py-2 bg-[#5B84AE] text-white rounded font-semibold">
        Save
      </button>
    </div>

    <div class="mt-4 text-center">
      <button onclick="alert('(placeholder rani supposedly it should go sa redirect password pop up')" class="text-sm text-blue-500 underline">
        Forgot Password?
      </button>
    </div>
  </div>
</div>

  </div>

  <script>
    const emailField = document.getElementById('email');
    const fields = ['username', 'email', 'description'];
    let currentEmail = 'jarod@gmail.com';
    const themeToggle = document.getElementById('theme-toggle');

    function enableEdit() {
      fields.forEach((id) => {
        const field = document.getElementById(id);
        field.removeAttribute('readonly');
        if (id === 'email') field.value = currentEmail;
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
        if (id === 'email') {
          currentEmail = field.value;
          field.value = maskEmail(currentEmail);
        }
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

    emailField.value = maskEmail(currentEmail);

    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      themeToggle.src = document.body.classList.contains('dark-mode')
        ? 'images/sun.svg'
        : 'images/moon.svg';
    });

    const fileInput = document.getElementById('pic-upload');
    const profilePic = document.getElementById('profile-pic');

    fileInput.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (e) => {
        profilePic.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });

    function openPasswordModal() {
  document.getElementById('password-modal').classList.remove('hidden');
}

function closePasswordModal() {
  document.getElementById('password-modal').classList.add('hidden');
}

function savePassword() {
  const oldPass = document.getElementById('old-password').value;
  const newPass = document.getElementById('new-password').value;

  if (!oldPass || !newPass)
  {
    alert("DONT LEAVE IT EMPTY (dapat red texts rani sa bottom).");
    return;
  }

  alert(" (place holder rani but its supposed to show another pop up na confirm na).");
  closePasswordModal();
}

  </script>
</body>
</html>