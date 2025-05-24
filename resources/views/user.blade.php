<!DOCTYPE html>
<html>
<head>
    <title>User Profile Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style> 

    /* make pa ko og css and javascript files */
        body
        {
            font-family: 'Inter', sans-serif;
            background-color: #293241;
            padding: 2rem;
            margin-bottom: 100px;
        }

        .profile-pic
        {
            width: 500px;
            height: 500px;
            border-radius: 100%;
        }

        .button
        {
            background: #5B84AE;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            margin: 0.5rem;
            cursor: pointer;
        }

        .Account-Details-Section
        { 
            border-radius: 10px;
            padding: 1rem;
            text-align: left;
            margin: 1rem auto;
            width: fit-content; 
            background-color: white;
        }

        .orange-button
        {
            background: #F16D45;
            padding: 1rem;
            border-radius: 20px;
            text-align: center;
            color: white;
            font-weight: bold;
            margin: 1rem 0;
        }

        footer
        {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #f1f1f1;
            padding: 1rem;
            display: flex;
            justify-content: space-around;
            color: black;
        }
    </style>
</head>
<body>

    <h1><strong>PROFILE</strong></h1>

    <div style="text-align: center;">
        <img src="/images/avatar.png" alt="Profile Picture" class="profile-pic">
        <div>
            <button class="button">Change Pic</button>
            <button class="button">Edit Profile</button>
        </div>
    </div>

    <h2>Account Details</h2>

    <div style="text-align: center;">
        <div class="Account-Details-Section">Username:<br>Bla2</div>
        <div class="Account-Details-Section">Email:<br>J***@gmail.com show<br>
        <div class="Account-Details-Section">First Name:<br>Big</div>
        <div class="Account-Details-Section">Last Name:<br>Daddy</div>
    </div>

    <h2>Customization</h2>
    <div class="orange-button">Change Password</div>

    <h2>Description</h2>
    <div style="border: 1px solid #ccc; border-radius: 15px; padding: 1rem; margin: 1rem 0; background: white;">
        Ui, chief, leader, alpha wolf, sigma.
    </div>

    <footer>
        <div>🏠</div>
        <div>🔔</div>
        <div style="font-size: 2rem;">➕</div>
        <div>📅</div>
        <div><strong>👤</strong></div>
    </footer>

</body>
</html>
