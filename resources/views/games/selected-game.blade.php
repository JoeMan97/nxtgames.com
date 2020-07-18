@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <selected-game game="{{ $game }}" user-id="{{ Auth::user()->id }}"></selected-game>

        </div>
    </div>
</div>
@endsection