@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <h1>Ver Noticia</h1>

            <show-new new-id="{{ $id }}"></show-new>
            <delete-new new-id="{{ $id }}"></delete-new>

        </div>
    </div></div>
@endsection