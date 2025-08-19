<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre demande de support</title>
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
        .message {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0fdf4;
            border-radius: 5px;
            border-left: 4px solid #16a34a;
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
        <h1>Confirmation de votre demande de support</h1>
    </div>

    <div class="content">
        <p>Bonjour,</p>

        <p>Nous vous confirmons la bonne réception de votre demande de support concernant :</p>

        <div class="message">
            <p><strong>{{ $title }}</strong></p>
        </div>

        <p>Notre équipe va étudier votre demande dans les plus brefs délais et vous répondra directement par email.</p>

        <p>Si vous avez d'autres questions ou informations à nous communiquer concernant cette demande, n'hésitez pas à répondre directement à cet email.</p>

        <p>Merci de votre confiance,</p>
        <p>L'équipe Lynza</p>

        <div class="footer">
            <p>Ce message est un accusé de réception automatique, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
