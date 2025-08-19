<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de support</title>
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
        .category {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }
        .category.bug {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .category.improvement {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        .category.question {
            background-color: #f3e8ff;
            color: #7e22ce;
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
        <h1>Nouvelle demande de support</h1>
    </div>

    <div class="content">
        <div class="field">
            <span class="label">Titre:</span>
            <span>{{ $title }}</span>
        </div>

        <div class="field">
            <span class="label">Email:</span>
            <span>{{ $email }}</span>
        </div>

        <div class="field">
            <span class="label">Catégorie:</span>
            <span class="category {{ $category }}">
                @if($category == 'bug')
                    Bug
                @elseif($category == 'improvement')
                    Demande d'amélioration
                @elseif($category == 'question')
                    Question
                @endif
            </span>
        </div>

        <div class="message">
            <div class="label">Description:</div>
            <p>{{ $description }}</p>
        </div>

        <div class="footer">
            <p>Ce message a été envoyé depuis le formulaire de support de Lynza.</p>
        </div>
    </div>
</body>
</html>
