@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
           <div class="card-header">
               {{$user->name}}
           </div>
           <div class="card-body">
               <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{$user->score}}%;" aria-valuenow="{{$user->score}}" aria-valuemin="0" aria-valuemax="100">{{$user->score}}%</div>
                </div>
           </div>
        </div>
        @foreach($notifs as $notif)
        <div class="card">
           <div class="card-body">
                {{$notif->contenu}}
           </div>
        </div>
        @endforeach
    </div>
</div>
@endsection