@extends('layouts.app')

@section('content')
    <div class="flex flex-col place-content-center w-screen pt-60">
        @foreach ($playTogethers as $pt)
            <a href="/main-bareng/{{ $pt->id }}" class="border">
                <p>{{ $pt->sport->name }}</p>
                <p>{{ $pt->name }}</p>
                <p>{{ $pt->date }}</p>
                <p>{{ $pt->getFormattedPriceAttribute() }}</p>
                <p>{{ $pt->play_together_details->count('user_count') }}/{{ $pt->player_slot }}</p>
                <p>Playing with: {{ $pt->owner->full_name }}</p>
            </a>
        @endforeach
    </div>
@endsection
