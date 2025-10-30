<!DOCTYPE html>
<html>
<head>
    <title>RPG Game - Start</title>
    <style>
        body { font-family: monospace; background: #111; color: #0f0; text-align: center; }
        .container { margin-top: 100px; }
        button { background: #0f0; color: #111; padding: 10px 20px; border: none; cursor: pointer; font-size: 18px; }
        button:hover { background: #0c0; }
    </style>
</head>
<body>
<div class="container">
    <h1>Welkom bij de RPG Game!</h1>
    <p>Je bent een held die het opneemt tegen vijanden. Verzamel goud, XP en word sterker!</p>

    <form method="GET" action="{{ route('game.actie') }}">
        <button type="submit">Start Game</button>
    </form>
</div>
</body>
</html>