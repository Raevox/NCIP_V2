<!DOCTYPE html>
<html>
<head>
    <title>Account Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #3E7B27;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .details {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .details ul {
            list-style: none;
            padding: 0;
        }
        .details li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .login-button {
            display: inline-block;
            background-color: #3E7B27;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Account Approved! 🎉</h2>
    </div>

    <div class="content">
        <h3>Hello {{ $applicant->first_name }} {{ $applicant->last_name }},</h3>
        <p>Good news! Your NCIP account has been approved.</p>
        <p>You can now log in to the system using your registered email address: <strong>{{ $applicant->email }}</strong></p>
        
        <center>
            <a href="https://ncip-nuevaecija.site/login" class="login-button">Login to Your Account</a>
        </center>

        <div class="details">
            <h4>Account Details:</h4>
            <ul>
                <li><strong>Name:</strong> {{ $applicant->first_name }} {{ $applicant->last_name }}</li>
                <li><strong>Email:</strong> {{ $applicant->email }}</li>
                <li><strong>Tribe:</strong> {{ $applicant->tribe }}</li>
                <li><strong>Contact:</strong> {{ $applicant->contact }}</li>
                <li><strong>Address:</strong> {{ $applicant->address }}</li>
            </ul>
        </div>

        <p>Click the login button above or visit: <br>
        <a href="https://ncip-nuevaecija.site/login">https://ncip-nuevaecija.site/login</a></p>
    </div>

    <div class="footer">
        <p>Thank you for registering with NCIP Nueva Ecija!<br>
        - NCIP Administration</p>
    </div>
</body>
</html>