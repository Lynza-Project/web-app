<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
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
            background-color: #4f46e5;
            color: white;
            padding: 15px 20px;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #4f46e5;
        }
        .message {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 5px;
            border-left: 4px solid #4f46e5;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nouveau message depuis le formulaire de contact</h1>
    </div>

    <div class="content">
        <div class="field">
            <span class="label">Nom:</span>
            <span>{{ $name }}</span>
        </div>

        <div class="field">
            <span class="label">Email:</span>
            <span>{{ $email }}</span>
        </div>

        <div class="message">
            <div class="label">Message:</div>
            <p>{{ $messageContent }}</p>
        </div>

        <div class="footer">
            <p>Ce message a été envoyé depuis le formulaire de contact de Lynza.</p>
        </div>
    </div>
</body>
</html>
