@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <select-game game="{{ $game }}"></select-game>

        </div>
    </div></div>
@endsection