@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
        
                <div class="card-header">{{ __('Résultat de votre recherche') }}</div>

                <div class="card-body">
                    @foreach($users as $user)
                        <div class="row">
                            <p class="lead"><a href="{{ route('detailUser', $user->id) }}"> {{ $user->prenom }} {{ $user->nom }}  </a><br> {{ $user->race }} {{ $user->getAge() }} ans.</p>
                            <div class="ml-auto">
                                @if($user->invitationsEnvoyer())
                                    <a href="{{ route('annuler', $user->id) }}">
                                        <button type="button" class="btn btn-info btn-sm" style="float:left;"><i class="fa fa-paper-plane" style="color:white;"></i> Invitation envoyée</button>
                                    </a> 
                                @elseif($user->invitationsRecus())
                                    <a href="{{ route('acceptFriend', $user->id) }}">
                                        <button type="button" class="btn btn-info btn-sm" style="float:left;"><i class="fa fa-user-plus" style="color:white;"></i> Accepter</button>
                                    </a>
                                    <a href="{{ route('deleteFriend', $user->id) }}">
                                        <button type="button" class="btn btn-danger btn-sm" style="float:left;"><i class="fa fa-trash" style="color:white;"></i> Décliner</button>
                                    </a>                                    
                                @elseif($user->myFriend())
                                    <a href="{{ route('deleteFriend', $user->id) }}">
                                        <button type="button" class="btn btn-danger btn-sm" style="float:left;"><i class="fa fa-trash" style="color:white;"></i> Supprimer</button>
                                    </a>
                                

                                @else
                                    <a href="{{ route('sendFriend', $user->id) }}">
                                        <button type="button" class="btn btn-primary btn-sm" style="float:left;"><i class="fa fa-user-plus" style="color:white;"></i> Ajouter</button>
                                    </a>
                                @endif                                                              
                            </div>
                        </div><hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
