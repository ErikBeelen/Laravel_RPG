<!DOCTYPE html>
<html>
<head>
    <title>RPG Game</title>
    <style>
        body { font-family: monospace; background: #111; color: #0f0; }
        .container { width: 600px; margin: 50px auto; }
        .stats { border: 1px solid #0f0; padding: 10px; margin-bottom: 10px; }
        form { margin-top: 10px; }
        button { background: #0f0; color: #111; padding: 5px 10px; border: none; cursor: pointer; margin-right: 5px; }
        button:hover { background: #0c0; }
    </style>
</head>
<body>
<div class="container">
    <h2>Gevecht tegen {{ $tegenstander['naam'] }}</h2>

    <div class="stats">
        <p><strong>Jij:</strong> HP {{ $hp }} | Aanval {{ $aanval }} | Verdediging {{ $verdediging }} | Snelheid {{ $snelheid }} | Drankjes {{ $drankjes }}</p>
        <p><strong>Tegenstander:</strong> HP {{ $tegenstander['HP'] }}</p>
        <p><strong>Level:</strong> {{ $level }} | XP {{ $ervaring }}/{{ $xp_nodig }} | Goud {{ $goud }}</p>
    </div>

    @if(isset($bericht))
        <p>{{ $bericht }}</p>
    @endif

    @if($hp > 0)
        <!-- Actieknoppen -->
        <form method="POST" action="{{ route('game.actie') }}">
            @csrf
            <button name="actie" value="aanval">⚔️ Aanval</button>
            <button name="actie" value="heal">🧪 Heal</button>
            <button name="actie" value="stoppen">🏳️ Stoppen</button>
        </form>

        <!-- Ga naar winkel -->
        <form method="GET" action="{{ route('game.winkel') }}">
            <button>🛒 Ga naar winkel</button>
        </form>
    @else
        <p>Je bent verslagen! 😵</p>
        <form method="GET" action="{{ route('over') }}">
            <button>Bekijk verliespagina</button>
        </form>
    @endif
</div>
</body>
</html>
