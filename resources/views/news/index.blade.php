@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="container">
                <h1 class="d-inline">Todas las Noticias</h1>
                <a href="/noticias/redactar" class="btn btn-primary float-right">
                    Redactar
                </a>
            </div>
            

            <news-list status="{{ $status }}"></news-list>

        </div>
    </div></div>
@endsection