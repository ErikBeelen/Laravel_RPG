@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 text-center p-6 bg-green-100 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-green-700 mb-4">🔁 Spel opnieuw starten</h2>

    <p class="text-gray-700 mb-6">
        Je sessie is gereset. Klik hieronder om opnieuw te beginnen.
    </p>

    <a href="{{ route('game.start') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
        Start Nieuw Spel
    </a>
</div>
@endsection
