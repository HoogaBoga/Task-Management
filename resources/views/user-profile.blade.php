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
      /* Using Laravel's asset() helper for robust pathing */
      background: url("{{ asset('images/background.svg') }}") no-repeat center center fixed;
      background-size: cover;
    }

    .font-krona-one {
        font-family: 'Krona One', sans-serif;
    }

    .icon-filter-to-white {
        filter: brightness(0) invert(1);
    }
  </style>
</head>
<body class="font-sans">

  <aside id="icon-sidebar" class="hidden md:flex fixed top-16 right-0 w-20 bg-[#F1F2F6] shadow-xl z-30 flex-col items-center justify-between py-6 rounded-l-2xl">
      <div class="flex flex-col items-center space-y-2">
          <a title="Home" href="{{ route('dashboard') }}" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer">
              <img src="{{ asset('images/home2.svg') }}" alt="home" class="w-8 h-8">
          </a>
          <div class="relative">
            <button title="Notifications" id="bell-icon" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer">
              <img src="{{ asset('images/bell.svg') }}" alt="bell" class="w-8 h-8">
            </button>

          <div id="notification-popup" class="absolute right-20 -mt-40 w-80 bg-white rounded-xl shadow-lg border border-gray-200 hidden z-40">
              <div class="p-4 border-b border-gray-300">
                <h3 class="text-lg font-bold">Notifications</h3>
              </div>
              <div class="flex items-center justify-between px-4 py-2">
                <div class="flex gap-2">
                  <button id="notif-all" class="text-sm font-medium px-3 py-1 rounded-full bg-blue-100 text-blue-700">All</button>
                  <button id="notif-unread" class="text-sm font-medium px-3 py-1 rounded-full hover:bg-gray-200">Unread</button>
                </div>
                <button id="mark-read" class="text-sm text-blue-600 underline hover:text-blue-800">Mark all as Read</button>
              </div>
              <div class="p-4 text-sm text-gray-500">No new notifications.</div>
            </div>
          </div>

          <a title="Tasks" href="{{ route('tasks.create') }}" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer">
              <img src="{{ asset('images/calendarclock.svg') }}" alt="task" class="w-8 h-8">
          </a>
          <a title="User Profile" href="{{ route('user.profile') }}" class="p-3 rounded-xl bg-slate-300">
              <img src="{{ asset('images/users.svg') }}" alt="profile" class="w-8 h-8">
          </a>
      </div>
      <div class="flex flex-col items-center space-y-4">
          <a title="Add New Task" href="{{ route('tasks.create') }}"
             class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 active:bg-blue-800 transition-all duration-150 ease-in-out hover:scale-105 active:scale-95 hover:shadow-xl cursor-pointer">
              <img src="{{ asset('images/add.svg') }}" alt="add" class="w-7 h-7 icon-filter-to-white">
          </a>
      </div>
  </aside>

  <div class="min-h-screen flex items-center justify-center p-4 md:pl-0 md:pr-24">
      <main class="w-full max-w-5xl">
        <section class="bg-white rounded-3xl shadow-lg w-full p-6 md:p-10">

          @if (session('success'))
              <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                  <span class="block sm:inline">{{ session('success') }}</span>
              </div>
          @endif
          @if (session('error'))
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                  <span class="block sm:inline">{{ session('error') }}</span>
              </div>
          @endif
          @if ($errors->any())
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <div class="bg-[#E0FBFC] rounded-2xl p-6 md:p-8">

            <header class="flex items-center mb-8">
              <img src="{{ asset('images/logo-placeholder.svg') }}" alt="Logo" class="w-12 h-12 md:w-14 md:h-14" />
              <span class="ml-4 text-xl md:text-2xl font-krona-one">Profile</span>
            </header>

            <form id="avatar-form" action="{{ route('user.avatar.update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="flex flex-col md:flex-row items-center gap-6 mb-8 pb-8 border-b border-gray-300">
                <div class="avatar w-24 h-24 rounded-full bg-gray-400 overflow-hidden relative group cursor-pointer flex-shrink-0">
                  <img id="profile-pic" src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" alt="Profile Picture" class="w-full h-full object-cover" />
                  <div class="absolute inset-0 bg-black bg-opacity-50 text-white text-center flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" onclick="viewImage()">
                    <span class="text-sm font-bold">View Image</span>
                  </div>
                </div>
                <input type="file" name="avatar" id="pic-upload" accept="image/*" class="hidden" onchange="document.getElementById('avatar-form').submit();" />
                <div class="flex flex-col items-center md:items-start gap-2.5">
                  <div class="flex flex-row gap-2.5">
                    <button type="button" class="button border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-[#5B84AE] text-white hover:bg-opacity-90" onclick="document.getElementById('pic-upload').click()">Change Pic</button>
                    <button type="button" class="edit-button border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-gray-300 text-gray-600 hover:bg-gray-400" id="edit-btn" onclick="enableEdit()">Edit Details</button>
                  </div>
                  <div id="edit-note" class="hidden text-center text-sm font-bold text-black mt-2">Once done, press the "Save Details" button below.</div>
                </div>
              </div>
            </form>

            <div class="grid md:grid-cols-2 gap-x-10 gap-y-8">
                <form action="{{ route('user.profile.update') }}" method="POST" id="profile-update-form">
                    @csrf
                    <div class="flex-1">
                        <h2 class="text-lg font-bold mb-4">Account Details</h2>
                        <div class="space-y-5">
                            <div>
                                <label class="block mb-1 font-bold" for="username">Username:</label>
                                <input type="text" id="username" name="username" value="{{ old('username', Auth::user()->name) }}" readonly class="w-full p-2.5 rounded-md border border-gray-300 text-sm bg-gray-200 cursor-default" />
                            </div>
                            <div>
                                <label class="block mb-1 font-bold" for="email">Email:</label>
                                <div class="relative flex items-center">
                                    <input type="text" id="email" value="{{ Auth::user()->email }}" readonly class="w-full p-2.5 rounded-md border border-gray-300 text-sm bg-gray-200 cursor-default pr-16" />
                                    <button type="button" id="toggle-email" class="absolute right-3 text-sm text-blue-600 underline font-semibold">Show</button>
                                </div>
                            </div>
                            <div>
                                <label class="block mb-1 font-bold" for="description">Description:</label>
                                <textarea id="description" name="description" rows="4" readonly class="w-full p-2.5 rounded-md border border-gray-300 text-sm bg-gray-200 cursor-default resize-none">{{ old('description', Auth::user()->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="flex-1">
                    <h2 class="text-lg font-bold mb-4">Control</h2>
                    <div class="flex flex-col items-start gap-3">
                        <a href="{{ route('change-password') }}" class="inline-block text-center border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-[#F16D45] text-white font-bold hover:bg-opacity-90">
                            Change Password
                        </a>
                        <button type="button" class="border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-red-600 text-white font-bold hover:bg-opacity-90" onclick="handleDelete()">
                            Delete Account
                        </button>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-[#C41E3A] text-white font-bold hover:bg-opacity-90">
                                Logout
                            </button>
                        </form>

                        <button type="submit" form="profile-update-form" class="save-button border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-[#5B84AE] text-white hidden" id="save-button">
                            Save Details
                        </button>
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
      <img id="popup-image" src="{{ asset('images/default-avatar.png') }}" alt="Full Profile Image" class="max-w-full max-h-[80vh] rounded" />
    </div>
  </div>


    <div id="delete-popup" class="fixed inset-0 bg-black bg-opacity-70 hidden z-60 flex items-center justify-center">
      <form id="delete-account-form" action="{{ route('user.account.delete') }}" method="POST" class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative">
        @csrf
        <button type="button" onclick="closeDeletePopup()" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 font-bold text-2xl">&times;</button>
        <h3 class="text-lg font-bold mb-4">Confirm Account Deletion</h3>

        <div id="password-field-container">
            <p class="mb-4 text-sm">Please enter your password to confirm. This action is irreversible.</p>
            <input id="delete-password" name="password" type="password" placeholder="Password" class="w-full p-2 border border-gray-300 rounded mb-3" />
        </div>

        <div id="confirmation-field-container" class="hidden">
            <p class="mb-4 text-sm">To confirm, please type your email address <strong class="text-black">{{ Auth::user()->email }}</strong> in the box below.</p>
            <input id="delete-confirmation" name="confirmation" type="text" placeholder="Type your email to confirm" class="w-full p-2 border border-gray-300 rounded mb-3" />
        </div>

        <label class="inline-flex items-center mb-4">
          <input type="checkbox" id="confirm-checkbox" class="mr-2" />
          <span>I understand that deleting my account is irreversible</span>
        </label>

        <button type="submit" id="confirm-delete-btn" disabled class="w-full bg-red-600 text-white py-2 rounded font-bold opacity-50 cursor-not-allowed">
          Delete Account (10)
        </button>
      </form>
    </div>
    <script>
    // NEW: Pass a flag from Laravel to know if the user has a password set.
    const userHasPassword = @json(!empty(Auth::user()->password));

    //Notification popup js
    document.addEventListener('DOMContentLoaded', () => {
      const bellIcon = document.getElementById('bell-icon');
      const notificationPopup = document.getElementById('notification-popup');

      if (bellIcon && notificationPopup) {
        let isVisible = false;

        bellIcon.addEventListener('click', (e) => {
          e.stopPropagation();
          isVisible = !isVisible;
          if (isVisible) {
            notificationPopup.classList.remove('hidden');
            requestAnimationFrame(() => {
              notificationPopup.classList.remove('opacity-0', 'scale-95');
              notificationPopup.classList.add('opacity-100', 'scale-100');
            });
          } else {
            notificationPopup.classList.remove('opacity-100', 'scale-100');
            notificationPopup.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
              if (!isVisible) notificationPopup.classList.add('hidden');
            }, 300);
          }
        });

        document.addEventListener('click', (e) => {
          if (!notificationPopup.contains(e.target) && !bellIcon.contains(e.target)) {
            if (isVisible) {
              isVisible = false;
              notificationPopup.classList.remove('opacity-100', 'scale-100');
              notificationPopup.classList.add('opacity-0', 'scale-95');
              setTimeout(() => {
                notificationPopup.classList.add('hidden');
              }, 300);
            }
          }
        });
      }
    });

    document.getElementById('notif-all').addEventListener('click', () => {
      document.getElementById('notif-all').classList.add('bg-blue-100', 'text-blue-700');
      document.getElementById('notif-unread').classList.remove('bg-blue-100', 'text-blue-700');
    });

    document.getElementById('notif-unread').addEventListener('click', () => {
      document.getElementById('notif-unread').classList.add('bg-blue-100', 'text-blue-700');
      document.getElementById('notif-all').classList.remove('bg-blue-100', 'text-blue-700');
    });

    const emailField = document.getElementById('email');
    const toggleEmailBtn = document.getElementById('toggle-email');
    const fields = ['username', 'description'];
    let currentEmail = "{{ Auth::user()->email }}"; // Dynamically set email from Laravel
    let isEmailVisible = false;

    function enableEdit() {
      fields.forEach((id) => {
        const field = document.getElementById(id);
        field.removeAttribute('readonly');
        field.classList.remove('bg-gray-200', 'cursor-default');
        field.classList.add('bg-white');
      });
      document.getElementById('save-button').classList.remove('hidden');
      document.getElementById('edit-btn').classList.add('hidden');
      document.getElementById('edit-note').classList.remove('hidden');
    }

    function maskEmail(email) {
      if (!email || !email.includes('@')) return 'email@example.com';
      const [name, domain] = email.split('@');
      if (name.length <= 2) return email;
      return name[0] + '*'.repeat(name.length - 1) + '@' + domain;
    }

    function updateEmailField() {
      emailField.value = isEmailVisible ? currentEmail : maskEmail(currentEmail);
      toggleEmailBtn.textContent = isEmailVisible ? 'Hide' : 'Show';
    }

    if(toggleEmailBtn && emailField){
        toggleEmailBtn.addEventListener('click', () => {
          isEmailVisible = !isEmailVisible;
          updateEmailField();
        });
        updateEmailField();
    }

    const fileInput = document.getElementById('pic-upload');
    const profilePic = document.getElementById('profile-pic');
    const popupImage = document.getElementById('popup-image');


    if(fileInput && profilePic && popupImage) {
        fileInput.addEventListener('change', (e) => {
          const file = e.target.files[0];
          if (!file) return;
          const reader = new FileReader();
          reader.onload = (event) => {
            profilePic.src = event.target.result;
            popupImage.src = event.target.result;
          };
          reader.readAsDataURL(file);
        });
    }

    // --- UPDATED DELETE LOGIC ---
    const deletePopup = document.getElementById('delete-popup');
    const deletePassword = document.getElementById('delete-password');
    const confirmCheckbox = document.getElementById('confirm-checkbox');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    const passwordContainer = document.getElementById('password-field-container');
    const confirmationContainer = document.getElementById('confirmation-field-container');
    const confirmationInput = document.getElementById('delete-confirmation');

    let countdownInterval;
    let countdown = 10;

    function handleDelete() {
      if(!deletePopup) return;

      // Reset all fields
      deletePassword.value = '';
      confirmationInput.value = '';
      confirmCheckbox.checked = false;
      countdown = 10;
      confirmDeleteBtn.textContent = `Delete Account (${countdown})`;
      confirmDeleteBtn.disabled = true;
      confirmDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');

      // NEW: Show the correct input field based on the user type
      if (userHasPassword) {
          passwordContainer.classList.remove('hidden');
          confirmationContainer.classList.add('hidden');
      } else {
          passwordContainer.classList.add('hidden');
          confirmationContainer.classList.remove('hidden');
      }

      deletePopup.classList.remove('hidden');

      if(countdownInterval) clearInterval(countdownInterval);

      countdownInterval = setInterval(() => {
        countdown--;
        if (countdown > 0) {
            confirmDeleteBtn.textContent = `Delete Account (${countdown})`;
        } else {
            confirmDeleteBtn.textContent = 'Delete Account';
            validateDeleteButtonState();
            clearInterval(countdownInterval);
        }
      }, 1000);
      validateDeleteButtonState();
    }

    function closeDeletePopup() {
      if(!deletePopup) return;
      deletePopup.classList.add('hidden');
      clearInterval(countdownInterval);
    }

    function validateDeleteButtonState() {
        if(!confirmCheckbox || !confirmDeleteBtn) return;

        let isPrimaryFieldFilled = false;
        // NEW: Check the input that is currently visible
        if (userHasPassword) {
            isPrimaryFieldFilled = deletePassword.value.trim().length > 0;
        } else {
            // For extra safety, ensure they typed the exact email
            isPrimaryFieldFilled = confirmationInput.value.trim() === "{{ Auth::user()->email }}";
        }

        const isConfirmed = confirmCheckbox.checked;

        if (isPrimaryFieldFilled && isConfirmed && countdown <= 0) {
            confirmDeleteBtn.disabled = false;
            confirmDeleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    // Attach listeners to all relevant inputs
    if(deletePassword) deletePassword.addEventListener('input', validateDeleteButtonState);
    if(confirmationInput) confirmationInput.addEventListener('input', validateDeleteButtonState);
    if(confirmCheckbox) confirmCheckbox.addEventListener('change', validateDeleteButtonState);
    // You no longer need a separate event listener on the delete button click

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
          if (e.target === imagePopup) closeImagePopup();
        });
    }
    if(deletePopup) {
        deletePopup.addEventListener('click', (e) => {
          if (e.target === deletePopup) closeDeletePopup();
        });
    }
  </script>
  </body>
</html>
