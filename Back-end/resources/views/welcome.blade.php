@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @guest
        <div class="col-md-6">
            <div class="card">
        
                <div class="card-header">{{ __('Connexion') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <!-- <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->

                            <div class="col-md-6 mx-auto">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Houba mail" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->

                            <div class="col-md-6 mx-auto">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Mot de passe" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 mx-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Se rappeler de moi') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 mx-auto">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endguest
        @if(Auth::User())
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Mon HoubaBook
                    <button type="button" style="float:right;" class="btn btn-dark active" data-toggle="modal" data-target="#myModal"><i class="fa fa-user-plus"></i></button>
                </div>

                <div class="card-body">
                    @if(count(Auth::User()->nbMyFriend()) == 0)
                        <p class="lead">Vous n'avez aucun ami sur HoubaBook ! <i class="fa fa-frown-o"></i> <br> Chercher en depuis la barre de recherche. <br> Ou inviter votre ami à rejoindre HoubaBook, en cliquant sur le bouton à droite de "Mon HoubaBook".</p>
                    @else
                        @foreach($users as $user)
                            @if($user->myFriend())
                                <div class="row">
                                    <p class="lead"><a href="{{ route('detailUser', $user->id) }}"> {{ $user->prenom }} {{ $user->nom }}  </a><br> {{ $user->race }} {{ $user->getAge() }} ans.</p>
                                    <div class="ml-auto">
                                        
                                        <a href="{{ route('deleteFriend', $user->id) }}">
                                            <button type="button" class="btn btn-danger btn-sm" style="float:left;"><i class="fa fa-trash" style="color:white;"></i> Supprimer</button>
                                        </a>
                                    </div>
                                </div><hr>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-light">
            <h4 class="modal-title">Ajouter votre ami sur HoubaBook</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <form method="POST" action="{{ route('newUserAmi') }}" aria-label="{{ __('New User HoubaBook') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-8 mx-auto">
                                <input id="nom" type="nom" class="form-control{{ $errors->has('nom') ? ' is-invalid' : '' }}" name="nom" placeholder="Nom" required autofocus>

                                @if ($errors->has('nom'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-8 mx-auto">
                                <input id="prenom" type="prenom" class="form-control{{ $errors->has('prenom') ? ' is-invalid' : '' }}" name="prenom" placeholder="Prenom" required autofocu>

                                @if ($errors->has('prenom'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('prenom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 mx-auto">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Houba Mail" required autofocus>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>                                            

                        <div class="form-group row mb-0">
                            <div class="col-md-8 mx-auto">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{ __('Ajouter votre ami') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
        </div>
    </div>
  </div>
</div>
@endsection
