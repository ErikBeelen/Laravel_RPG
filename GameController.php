<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    // Startpagina / introductie
    public function intro(Request $request)
    {
        // Start sessie met startwaardes als deze nog niet bestaan
        if (!session()->has('hp')) {
            $data = [
                'hp' => 50,
                'aanval' => 30,
                'verdediging' => 1,
                'snelheid' => 60,
                'drankjes' => 1,
                'goud' => 0,
                'ervaring' => 0,
                'level' => 0,
                'xp_nodig' => 20,
                'verslagen' => 0,
                'tegenstander' => $this->nieuweTegenstander(0),
                'bericht' => 'Welkom bij het gevecht!',
            ];
            session(['game' => $data]);
        }

        return view('game.game', session('game'));
    }

    // Speler actie: aanval, heal of stoppen
    public function actie(Request $request)
    {
        $actie = $request->input('actie');
        $data = session('game');

        // Doodscheck: als HP 0 of minder is, kan niets meer
        if ($data['hp'] <= 0) {
            return redirect()->route('over');
        }

        $tegenstander = $data['tegenstander'];

        switch ($actie) {
            case 'aanval':
                $schade = round($data['aanval'] / max($tegenstander['verdediging'], 1));
                $tegenstander['HP'] = max($tegenstander['HP'] - $schade, 0);
                $data['bericht'] = "Je valt aan! Je doet $schade schade aan de {$tegenstander['naam']}.";
                break;

            case 'heal':
                if ($data['drankjes'] > 0) {
                    $healing = 50;
                    $data['hp'] = min($data['hp'] + $healing, 50 * max($data['level'], 1));
                    $data['drankjes']--;
                    $data['bericht'] = "Je hebt jezelf geheeld! Je HP is nu {$data['hp']}.";
                } else {
                    $data['bericht'] = "Je hebt geen drankjes meer!";
                }
                break;

            case 'stoppen':
                return redirect()->route('opnieuw');

            default:
                $data['bericht'] = "Ongeldige actie.";
        }

        // Tegenstander valt terug aan als hij nog leeft
        if ($tegenstander['HP'] > 0) {
            $aanvalschade = rand(10, 20) * max($data['level'], 1);
            $schade = round($aanvalschade / max($data['verdediging'], 1));
            $data['hp'] = max($data['hp'] - $schade, 0);
            $data['bericht'] .= " De {$tegenstander['naam']} doet $schade schade terug.";

            // Doodscheck na tegenaanval
            if ($data['hp'] <= 0) {
                session(['game' => $data]);
                return redirect()->route('over');
            }
        } else {
            // Tegenstander verslagen
            $data['verslagen']++;
            $data['ervaring'] += $tegenstander['xp'];
            $data['goud'] += $tegenstander['goud'];

            // Herstel slechts gedeeltelijk HP na gevecht (niet volledig)
            $data['hp'] = min($data['hp'] + 20, 50 * max($data['level'], 1));

            $data['bericht'] = "Je hebt {$tegenstander['naam']} verslagen! Goud +{$tegenstander['goud']}, XP +{$tegenstander['xp']}.";

            // Level up check
            if ($data['ervaring'] >= $data['xp_nodig']) {
                $data['level']++;
                $data['ervaring'] = 0;
                $data['xp_nodig'] += 10;
                $data['aanval'] += 5;
                $data['snelheid'] += 5;
                $data['hp'] += 10;
                $data['bericht'] .= " Level up! Je bent nu level {$data['level']}.";
            }

            $tegenstander = $this->nieuweTegenstander($data['level']);
        }

        $data['tegenstander'] = $tegenstander;
        session(['game' => $data]);

        return view('game.game', $data);
    }

    // Maak nieuwe vijand, schaling met level
    private function nieuweTegenstander($level)
    {
        $troepen = [
            ['naam' => 'Wolf', 'baseHP' => 40, 'baseVerd' => 1, 'baseSpeed' => 80],
            ['naam' => 'Zombie', 'baseHP' => 45, 'baseVerd' => 1.5, 'baseSpeed' => 50],
            ['naam' => 'Mens', 'baseHP' => 50, 'baseVerd' => 2, 'baseSpeed' => 60],
        ];

        $t = $troepen[array_rand($troepen)];
        $scaling = 1 + ($level * 0.3);

        return [
            'naam' => $t['naam'],
            'HP' => round($t['baseHP'] * $scaling),
            'verdediging' => round($t['baseVerd'] * (1 + $level * 0.2), 2),
            'snelheid' => $t['baseSpeed'] + (5 * $level),
            'xp' => 10 + (8 * $level),
            'goud' => 5 + (5 * $level),
        ];
    }

    // Winkelpagina
    public function winkel()
    {
        $data = session('game');

        if ($data['hp'] <= 0) {
            return redirect()->route('over');
        }

        return view('game.winkel', $data);
    }

    // Koop iets in de winkel
    public function koop(Request $request)
    {
        $data = session('game');

        if ($data['hp'] <= 0) {
            return redirect()->route('over');
        }

        $keuze = $request->input('item');
        switch ($keuze) {
            case '1':
                if ($data['goud'] >= 10) {
                    $data['drankjes']++;
                    $data['goud'] -= 10;
                }
                break;
            case '2':
                if ($data['goud'] >= 20) {
                    $data['aanval'] += 10;
                    $data['goud'] -= 20;
                }
                break;
            case '3':
                if ($data['goud'] >= 35) {
                    $data['verdediging'] += 0.5;
                    $data['goud'] -= 35;
                }
                break;
        }

        session(['game' => $data]);
        return redirect('/winkel');
    }

    // Opnieuw starten
    public function opnieuw()
    {
        session()->flush();
        return redirect('/');
    }

    public function over()
    {
        $data = session('game'); // haalt alle game-sessiewaarden op
        return view('game.over', ['data' => $data]);
    }

    public function restart()
    {
        session()->forget('game'); // reset alles
        return redirect()->route('game.start'); // naar startpagina
    }

}
