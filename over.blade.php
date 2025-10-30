@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 text-center p-6 bg-red-100 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-red-700 mb-4">💀 Je bent verslagen!</h2>

    <p class="text-gray-700 mb-6">
        Je HP is 0 geworden. Je hebt {{ $data['verslagen'] ?? 0 }} tegenstanders verslagen.
    </p>

    <form action="{{ route('restart') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
            Opnieuw starten
        </button>
    </form>
</div>
@endsection
