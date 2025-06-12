<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Profile</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background: url("{{ asset('images/background.svg') }}") no-repeat center center fixed;
      background-size: cover;
    }
    .font-krona-one { font-family: 'Krona One', sans-serif; }
    .icon-filter-to-white { filter: brightness(0) invert(1); }
  </style>
</head>
<body class="font-sans pb-24 md:pb-0">

  <aside id="icon-sidebar" class="hidden md:flex fixed top-16 right-0 w-20 bg-[#F1F2F6] shadow-xl z-30 flex-col items-center justify-between py-6 rounded-l-2xl">
      <div class="flex flex-col items-center space-y-2">
          <a title="Home" href="{{ route('dashboard') }}" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer">
              <img src="{{ asset('images/home2.svg') }}" alt="home" class="w-8 h-8">
          </a>
          <div class="relative">
            <button title="Notifications" id="desktop-bell-icon" class="p-3 rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95 cursor-pointer">
              <img src="{{ asset('images/bell.svg') }}" alt="bell" class="w-8 h-8">
            </button>
          </div>
          <a title="User Profile" href="{{ route('user.profile') }}" class="p-3 rounded-xl bg-slate-300">
              <img src="{{ asset('images/users.svg') }}" alt="profile" class="w-8 h-8">
          </a>
      </div>
      <div class="flex flex-col items-center w-full space-y-4">
          <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" title="Logout" class="w-full p-3 flex justify-center rounded-xl hover:bg-slate-300 active:bg-slate-400 transition-all duration-150 ease-in-out group hover:scale-110 active:scale-95">
                    <img src="{{ asset('images/logout-light.svg') }}" alt="Logout" class="w-8 h-8 text-slate-700 group-hover:text-red-500">
                </button>
            </form>
          <a title="Add New Task" href="{{ route('tasks.create') }}"
             class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 active:bg-blue-800 transition-all duration-150 ease-in-out hover:scale-105 active:scale-95 hover:shadow-xl cursor-pointer">
              <img src="{{ asset('images/add.svg') }}" alt="add" class="w-7 h-7 icon-filter-to-white">
          </a>
      </div>
  </aside>

  <div id="notification-popup" class="fixed bottom-20 right-4 md:top-16 md:right-24 md:bottom-auto w-80 bg-white rounded-xl shadow-lg border border-gray-200 hidden z-50">
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

  <div class="min-h-screen flex items-center justify-center p-4 md:pl-0 md:pr-24">
      <main class="w-full max-w-5xl">
        <section class="bg-white rounded-3xl shadow-lg w-full p-6 md:p-10">

          @if (session('success'))
              <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                  <span>{{ session('success') }}</span>
              </div>
          @endif
          @if (session('error'))
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                  <span>{{ session('error') }}</span>
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
                <div class="avatar w-24 h-24 rounded-full bg-gray-400 overflow-hidden relative group cursor-pointer flex-shrink-0" onclick="viewImage()">
                    @if (Auth::user()->avatar_url)
                        <img id="profile-pic" src="{{ Auth::user()->avatar_url }}" alt="Profile Picture" class="w-full h-full object-cover">
                    @else
                        <img id="profile-pic" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=128&background=5B84AE&color=FFFFFF&bold=true" alt="User Initials" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-50 text-white text-center flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                      <span class="text-sm font-bold">View Image</span>
                    </div>
                </div>
                <input type="file" name="avatar" id="pic-upload" accept="image/*" class="hidden" onchange="document.getElementById('avatar-form').submit();" />
                <div class="flex flex-col items-center md:items-start gap-2.5">
                  <div class="flex flex-row gap-2.5">
                    <button type="button" class="button border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-[#5B84AE] text-white hover:bg-opacity-90" onclick="document.getElementById('pic-upload').click()">Change Pic</button>
                    <button type="button" class="edit-button border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-gray-300 text-gray-600 hover:bg-gray-400" id="edit-btn">Edit Details</button>
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
                                <input type="text" id="username" name="name" value="{{ old('name', Auth::user()->name) }}" readonly class="w-full p-2.5 rounded-md border border-gray-300 text-sm bg-gray-200 cursor-default" />
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
                        <button type="button" id="delete-account-btn" class="border-0 px-5 py-2.5 rounded-lg text-sm cursor-pointer bg-red-600 text-white font-bold hover:bg-opacity-90">
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

  <div id="image-popup" class="fixed inset-0 bg-black bg-opacity-70 hidden z-50 flex items-center justify-center p-4">
    <div class="relative bg-white rounded-lg shadow-lg p-4 max-w-[90vw] max-h-[90vh] flex items-center justify-center">
      <button onclick="closeImagePopup()" class="absolute -top-2 -right-2 text-white bg-gray-700 hover:bg-gray-900 rounded-full w-8 h-8 flex items-center justify-center text-2xl z-10">&times;</button>
        @if (Auth::user()->avatar_url)
            <img id="popup-image" src="{{ Auth::user()->avatar_url }}" alt="Full Profile Image" class="max-w-full max-h-full rounded" />
        @else
            <img id="popup-image" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=512&background=5B84AE&color=FFFFFF&bold=true" alt="User Initials" class="max-w-full max-h-full rounded" />
        @endif
    </div>
  </div>

  <div id="delete-popup" class="fixed inset-0 bg-black bg-opacity-70 hidden z-60 flex items-center justify-center p-4">
      <form id="delete-account-form" action="{{ route('user.account.delete') }}" method="POST" class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative">
        @csrf
        <button type="button" id="close-delete-popup-btn" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 font-bold text-2xl">&times;</button>
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

  <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white shadow-lg z-40">
    <div class="flex justify-around items-center p-2">
      <a href="{{ route('dashboard') }}" title="Dashboard" class="p-3 {{ request()->routeIs('dashboard') ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-500">
        <i class="fas fa-home text-xl"></i>
      </a>
      <a href="#" id="mobile-bell-icon" title="Notifications" class="p-3 text-gray-500 hover:text-blue-500">
        <i class="fas fa-bell text-xl"></i>
      </a>
      <a href="{{ route('tasks.create') }}" title="Add Task" class="p-3 text-gray-500 hover:text-blue-500 -mt-8">
        <div class="bg-blue-600 text-white p-4 rounded-full shadow-lg">
          <i class="fas fa-plus text-2xl"></i>
        </div>
      </a>
      <a href="{{ route('user.profile') }}" title="Profile" class="p-3 {{ request()->routeIs('user.profile') ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-500">
        <i class="fas fa-user text-xl"></i>
      </a>
      <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" title="Logout" class="p-3 text-gray-500 hover:text-blue-500">
          <i class="fas fa-sign-out-alt text-xl"></i>
        </button>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
        // === ELEMENTS ===
        const userHasPassword = @json(!empty(Auth::user()->password));

        // Notifications
        const desktopBell = document.getElementById('desktop-bell-icon');
        const mobileBell = document.getElementById('mobile-bell-icon');
        const notificationPopup = document.getElementById('notification-popup');

        // Profile Editing
        const editBtn = document.getElementById('edit-btn');
        const saveButton = document.getElementById('save-button');
        const editNote = document.getElementById('edit-note');
        const editableFields = ['username', 'description'];
        const emailField = document.getElementById('email');
        const toggleEmailBtn = document.getElementById('toggle-email');

        // Image Popup
        const imagePopup = document.getElementById('image-popup');
        const profilePic = document.getElementById('profile-pic');
        const popupImage = document.getElementById('popup-image');

        // Delete Account Popup
        const deletePopup = document.getElementById('delete-popup');
        const deleteAccountBtn = document.getElementById('delete-account-btn');
        const closeDeletePopupBtn = document.getElementById('close-delete-popup-btn');
        const deletePassword = document.getElementById('delete-password');
        const confirmCheckbox = document.getElementById('confirm-checkbox');
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        const passwordContainer = document.getElementById('password-field-container');
        const confirmationContainer = document.getElementById('confirmation-field-container');
        const confirmationInput = document.getElementById('delete-confirmation');
        let countdownInterval;
        let countdown = 10;

        // === NOTIFICATIONS LOGIC ===
        const togglePopup = (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (notificationPopup) notificationPopup.classList.toggle('hidden');
        };
        if (desktopBell) desktopBell.addEventListener('click', togglePopup);
        if (mobileBell) mobileBell.addEventListener('click', togglePopup);

        if (notificationPopup) {
            document.addEventListener('click', (e) => {
                const isClickInside = notificationPopup.contains(e.target) ||
                                      (desktopBell && desktopBell.contains(e.target)) ||
                                      (mobileBell && mobileBell.contains(e.target));
                if (!isClickInside) {
                    notificationPopup.classList.add('hidden');
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
        }

        // === PROFILE EDITING LOGIC ===
        if (editBtn) {
            editBtn.addEventListener('click', () => {
                editableFields.forEach((id) => {
                    const field = document.getElementById(id);
                    if(field) {
                        field.removeAttribute('readonly');
                        field.classList.remove('bg-gray-200', 'cursor-default');
                        field.classList.add('bg-white');
                    }
                });
                if (saveButton) saveButton.classList.remove('hidden');
                editBtn.classList.add('hidden');
                if (editNote) editNote.classList.remove('hidden');
            });
        }

        // Email Masking
        let currentEmail = "{{ Auth::user()->email }}";
        let isEmailVisible = false;
        const maskEmail = (email) => {
            if (!email || !email.includes('@')) return 'email@example.com';
            const [name, domain] = email.split('@');
            if (name.length <= 2) return name[0] + '*@' + domain;
            return name[0] + '*'.repeat(name.length - 2) + name.slice(-1) + '@' + domain;
        };
        if (toggleEmailBtn && emailField) {
            toggleEmailBtn.addEventListener('click', () => {
                isEmailVisible = !isEmailVisible;
                emailField.value = isEmailVisible ? currentEmail : maskEmail(currentEmail);
                toggleEmailBtn.textContent = isEmailVisible ? 'Hide' : 'Show';
            });
            emailField.value = maskEmail(currentEmail);
        }

        // === IMAGE POPUP LOGIC ===
        const viewImage = () => {
            if (imagePopup && profilePic && popupImage) {
                popupImage.src = profilePic.src;
                imagePopup.classList.remove('hidden');
            }
        };
        const closeImagePopup = () => {
            if (imagePopup) imagePopup.classList.add('hidden');
        };
        if (imagePopup) {
            imagePopup.addEventListener('click', (e) => { if (e.target === imagePopup) closeImagePopup(); });
        }
        window.viewImage = viewImage;
        window.closeImagePopup = closeImagePopup;

        // === DELETE ACCOUNT POPUP LOGIC ===
        const validateDeleteButtonState = () => {
            if(!confirmCheckbox || !confirmDeleteBtn) return;
            let isPrimaryFieldFilled = userHasPassword ?
                deletePassword.value.trim().length > 0 :
                confirmationInput.value.trim().toLowerCase() === currentEmail.toLowerCase();

            const isConfirmed = confirmCheckbox.checked;

            if (isPrimaryFieldFilled && isConfirmed && countdown <= 0) {
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                confirmDeleteBtn.disabled = true;
                confirmDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        };
        const openDeletePopup = () => {
            if(!deletePopup) return;
            if (deletePassword) deletePassword.value = '';
            if (confirmationInput) confirmationInput.value = '';
            if (confirmCheckbox) confirmCheckbox.checked = false;
            countdown = 10;
            confirmDeleteBtn.textContent = `Delete Account (${countdown})`;

            if (userHasPassword) {
                if(passwordContainer) passwordContainer.classList.remove('hidden');
                if(confirmationContainer) confirmationContainer.classList.add('hidden');
            } else {
                if(passwordContainer) passwordContainer.classList.add('hidden');
                if(confirmationContainer) confirmationContainer.classList.remove('hidden');
            }

            deletePopup.classList.remove('hidden');

            if (countdownInterval) clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                countdown--;
                if (countdown > 0) {
                    confirmDeleteBtn.textContent = `Delete Account (${countdown})`;
                } else {
                    confirmDeleteBtn.textContent = 'Delete Account';
                    clearInterval(countdownInterval);
                }
                validateDeleteButtonState();
            }, 1000);
            validateDeleteButtonState();
        };
        const closeDeletePopup = () => {
            if (deletePopup) deletePopup.classList.add('hidden');
            clearInterval(countdownInterval);
        };
        if (deleteAccountBtn) deleteAccountBtn.addEventListener('click', openDeletePopup);
        if (closeDeletePopupBtn) closeDeletePopupBtn.addEventListener('click', closeDeletePopup);
        if (deletePassword) deletePassword.addEventListener('input', validateDeleteButtonState);
        if (confirmationInput) confirmationInput.addEventListener('input', validateDeleteButtonState);
        if (confirmCheckbox) confirmCheckbox.addEventListener('change', validateDeleteButtonState);
        if (deletePopup) {
            deletePopup.addEventListener('click', (e) => { if (e.target === deletePopup) closeDeletePopup(); });
        }

        // Global keydown listener for ESC key
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
    });
  </script>
</body>
</html>
