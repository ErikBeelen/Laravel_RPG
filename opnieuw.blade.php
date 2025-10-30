@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 text-center p-6 bg-yellow-100 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-yellow-700 mb-4">🔁 Game opnieuw starten</h2>
    <p class="text-gray-700 mb-6">Je sessie is gereset. Klik hieronder om opnieuw te beginnen.</p>

    <a href="{{ route('game.start') }}" class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition">
        Start Nieuw Spel
    </a>
</div>
@endsection
