@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <h1>Redactar Noticia</h1>

            <write-new user-id="{{ Auth::user()->id }}"></write-new>

        </div>
    </div>
</div>
@endsection