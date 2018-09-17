@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Veuillez renseigner l'objet que vous souhaitez donner</h2><br />
    <form method="post" action="{{url('/')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="idVendeur" value="{{$user->id}}" hidden>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="title">Nom de l'objet:</label>
                <input type="text" class="form-control" name="nomObjet" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="content">Image:</label>
                <input type="file" name="image">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="content">Description:</label>
                <textarea name="description" required></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="categorie">Catégorie:</label>
                <select id="categorie" name="categorie" required>
                    <option value="0" disabled>---</option> 
                    @foreach($categories as $categorie)
                    <option value="{{$categorie->idCat}}" selected>{{$categorie->nomCat}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4" style="margin-top:60px">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
