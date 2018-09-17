@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if ($user!=NULL)
            <a  href="{{ url('/create') }}">Donner un objet</a>
        @endif
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <div class="navbar-brand">Catégories : </div>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="/">Toutes les catégories</a>
              </li>
             @foreach($categories as $categorie)
              <li class="nav-item">
                <a class="nav-link" href="/cat/{{$categorie->idCat}}">{{$categorie->nomCat}}</a>
              </li>
             @endforeach
            </ul>
          </div>
        </nav>
        @foreach($objets as $objet)
        @php
        $date=$objet->created_at;
        @endphp
        <br>     
        <div class="card">

            <div class="card-header"><h3>{{$objet->nomObjet}}</h3></div>
            <div class="row card-body">
                <div class="col col-md-2"><img class="img-responsive" src="{{secure_asset('storage/upload/'.$objet->image)}}"></div>
                <div class="col col-md-10">@php  echo ($objet->description) @endphp <br></div>
            </div>
            <div class="card-footer">
                <div class="float-left">Par {{$objet->name}} le {{$date}}</div>
                @if ($user!=NULL)
                @if ($user->id != $objet->idVendeur)
                    <div class="float-right">
                        <a href="/take/{{$objet->idObjet}}"><button class="btn btn-secondary">Je suis interessé</button></a>
                    </div> 
                @endif
                @if ($user->id == $objet->idVendeur)
                    <div class="float-right">
                        <a href="/delete/{{$objet->idObjet}}"><button class="btn btn-warning">Supprimer L'objet</button></a>
                    </div> 
                @endif
                @endif
            </div>
            </div>
        @endforeach
        
    </div>
</div>
@endsection
