@extends('layouts.app')

@section('content')
    <div class="flex flex-col place-content-center w-screen pt-60">
        <p>{{ $playTogether->sport->name }}</p>
        <p>{{ $playTogether->name }}</p>
        <p>{{ $playTogether->play_together_details->count('user_count') }}/{{ $playTogether->player_slot }}</p>
        <p>About</p>
        <p>{{ $playTogether->description }}</p>
        <p>Location</p>
        @foreach ($playTogether->getLocations() as $loc)
            <p>{{ $loc }}</p>
        @endforeach
        <p>Price</p>
        <p>{{ $playTogether->getFormattedPriceAttribute() }}</p>
        <p>Waktu dan Tanggal</p>
        <p>{{ $playTogether->date }}</p>
        <p>{{ $playTogether->start_hour }}</p>
        <p>{{ $playTogether->end_hour }}</p>
        <p>Lapangan</p>
        @foreach ($playTogether->getFieldVenueDetails() as $f)
            <p>{{ $f->field_name }}</p>
            <p>{{ $f->venue_name }}</p>
            <p>{{ $f->venue_location }}</p>
        @endforeach
        <p>Dibuat oleh:</p>
        <p>{{ $playTogether->owner->full_name }}</p>
    </div>
@endsection
