<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message from NEN Global</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .message-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .sender-info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>NEN Global Network</h1>
            <p>Trainer Contact Message</p>
        </div>

        <div class="content">
            <p>Dear {{ $trainerName }},</p>
            
            <p>You have received a new contact message through the NEN Global website from someone interested in your training services.</p>

            <div class="sender-info">
                <h3>Contact Information:</h3>
                <p><strong>Name:</strong> {{ $senderName }}</p>
                <p><strong>Email:</strong> {{ $senderEmail }}</p>
                <p><strong>Subject:</strong> {{ $subject }}</p>
            </div>

            <div class="message-box">
                <h3>Message:</h3>
                <p>{{ nl2br(e($messageContent)) }}</p>
            </div>

            <p>You can reply directly to this email to respond to {{ $senderName }}.</p>
        </div>

        <div class="footer">
            <p>This message was sent through the NEN Global website trainer contact form.</p>
            <p>© {{ date('Y') }} NEN Global. All rights reserved.</p>
            <p>Visit us at: <a href="https://nen-global.org">nen-global.org</a></p>
        </div>
    </div>
</body>
</html>