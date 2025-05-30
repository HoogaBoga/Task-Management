<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <style>
        /* SEPARATE LATER OG CSS AND JS KAY GUBOT*/
        body
        {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/background.svg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            display: flex;
            flex-direction: row-reverse;
            height: 100vh;
        }

        .sidebar {
            width: 70px;
            background-color: #F1F2F6;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            gap: 20px;
            position: fixed;
            top: 0;
            right: 0;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
        }

        .sidebar img {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .plus-icon {
            width: 80px;
            height: 80px;
            background-color: #5B84AE;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            right: 20px;
        }

        .main {
            margin-right: 100px;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
        }

        .background-wrapper {
            background-color: white;
            border-radius: 30px;
            padding: 60px;
            width: 95%;
            max-width: 1400px;
        }

        .inner-wrapper {
            background-color: #E0FBFC;
            border-radius: 20px;
            padding: 30px;
        }

        .top-bar {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .top-bar img {
            width: 60px;
            height: 60px;
        }

        .top-bar span {
            font-family: 'Krona One', sans-serif;
            font-size: 24px;
            margin-left: 15px;
        }

        .top-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #ccc;
        }

        .top-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .button, .edit-button, .save-button, .orange-button {
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            cursor: pointer;
            width: fit-content;
        }

        .button {
            background-color: #5B84AE;
            color: white;
        }

        .edit-button {
            background-color: #E2E2E2;
            color: #757575;
        }

        .save-button {
            background-color: #5B84AE;
            color: white;
            display: none;
        }

        .orange-button {
            background-color: #F16D45;
            color: white;
            font-weight: bold;
        }

        .content {
            display: flex;
            gap: 40px;
        }

        .left, .right {
            flex: 1;
        }

        .section {
            margin-bottom: 20px;
        }

        .section label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        textarea {
            resize: none;
        }

        input[readonly], textarea[readonly] {
            background-color: #f0f0f0;
            cursor: default;
        }

        .customization {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        #edit-note {
            display: none;
            text-align: center;
            font-weight: bold;
            color: black;
            margin: 10px auto;
        }

        body, .sidebar, .background-wrapper, .inner-wrapper {
    transition: background 0.5s ease, background-color 0.5s ease;
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

.sidebar::after {
    content: '';
    display: block;
    height: 10px;
}


    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <img src="images/home.svg" alt="Home">
        <img src="images/bell.svg" alt="Notifications">
        <img src="images/calendar.svg" alt="Calendar">
        <img src="images/user.svg" alt="Profile">
        <div class="plus-icon">
            <img src="images/add.svg" alt="Add" style="width: 30px; height: 30px;">
        </div>
        <img id="theme-toggle" src="images/moon.svg" alt="Dark Mode">
    </div>

    <div class="main">
        <div class="background-wrapper">
            <div class="top-bar">
                <img src="images/logo-placeholder.svg" alt="Logo">
                <span>Profile</span>
            </div>
            <div class="inner-wrapper">
                <div class="top-section">
                    <div class="avatar"></div>
                    <div class="top-buttons">
                        <button class="button" id="change-pic">Change Pic</button>
                        <button class="edit-button" id="edit-btn" onclick="enableEdit()">Edit Details</button>
                        <div id="edit-note">Once done, press the "Save Details" button below.</div>
                    </div>
                </div>

                <div class="content">
                    <div class="left">
                        <div class="section-title">Account Details</div>

                        <div class="section">
                            <label>Username:</label>
                            <input type="text" id="username" value="Big Daddy" readonly>
                        </div>

                        <div class="section">
                            <label>Email:</label>
                            <input type="text" id="email" value="j**@gmail.com" readonly>
                        </div>

                        <div class="section">
                            <label>Description:</label>
                            <textarea id="description" rows="4" readonly>UI, chief, leader, alpha wolf, sigma</textarea>
                        </div>
                    </div>

                    <div class="right">
                        <div class="section">
                            <label>First Name:</label>
                            <input type="text" id="first-name" value="Big" readonly>
                        </div>

                        <div class="section">
                            <label>Last Name:</label>
                            <input type="text" id="last-name" value="Daddy" readonly>
                        </div>

                        <div class="section-title">Customization</div>
                        <div class="customization">
                            <button class="orange-button">Change Password</button>
                            <button class="save-button" id="save-button" onclick="saveDetails()">Save Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const emailField = document.getElementById('email');
    const fields = ['username', 'email', 'first-name', 'last-name', 'description'];
    let currentEmail = 'jarod@gmail.com';
    const themeToggle = document.getElementById('theme-toggle');

    function enableEdit() {
        fields.forEach(id => {
            const field = document.getElementById(id);
            field.removeAttribute('readonly');
            if (id === 'email') field.value = currentEmail;
        });
        document.getElementById('save-button').style.display = 'inline-block';
        document.getElementById('edit-btn').style.display = 'none';
        document.getElementById('edit-note').style.display = 'block';
    }

    function saveDetails() {
        fields.forEach(id => {
            const field = document.getElementById(id);
            field.setAttribute('readonly', true);
            if (id === 'email') {
                currentEmail = field.value;
                field.value = maskEmail(currentEmail);
            }
        });
        document.getElementById('save-button').style.display = 'none';
        document.getElementById('edit-btn').style.display = 'inline-block';
        document.getElementById('edit-note').style.display = 'none';
    }

    function maskEmail(email) {
        const [user, domain] = email.split('@');
        return user[0] + '**@' + domain;
    }

    themeToggle.addEventListener('click', () => {
    const body = document.body;
    const isDark = body.classList.toggle('dark-mode');
    themeToggle.src = isDark ? 'images/sun.svg' : 'images/moon.svg';
});

</script>
</body>
</html>
