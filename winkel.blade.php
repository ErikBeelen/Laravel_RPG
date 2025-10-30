<!DOCTYPE html>
<html>
<head>
    <title>Winkel</title>
    <style>
        body { font-family: monospace; background: #111; color: #0f0; }
        .container { width: 600px; margin: 50px auto; }
    </style>
</head>
<body>
<div class="container">
    <h2>🛒 Winkel</h2>
    <p>Je hebt {{ $goud }} goud en {{ $drankjes }} drankjes.</p>

    <form method="POST" action="/winkel/koop">
        @csrf
        <button name="item" value="1">Koop drankje (+50 HP) - 10 goud</button><br><br>
        <button name="item" value="2">Koop wapen (+10 aanval) - 20 goud</button><br><br>
        <button name="item" value="3">Koop uitrusting (+0.5 verdediging) - 35 goud</button><br><br>
    </form>

    <a href="/">⬅️ Terug naar gevecht</a>
</div>
</body>
</html>