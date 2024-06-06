@extends('layouts.app')

@section('content')
    <div class="flex flex-col place-content-center w-screen pt-60">
        @foreach ($playTogethers as $pt)
            <a href="" class="border">
                <p>{{ $pt->name }}</p>
                <p>{{ $pt->date }}</p>
                <p>{{ $pt->getFormattedPriceAttribute() }}</p>
            </a>
        @endforeach
    </div>
@endsection
