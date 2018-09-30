@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
    
                <div class="card-header">
                    {{ __('Mon Compte') }}
                    <button type="button" style="float:right;" class="btn btn-primary active" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i></button>
                    <div class="col-md-6 mx-auto">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$percent}}%;" >Profil completé à {{round($percent)}}%</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="lead">{{ $user->nom }} {{ $user->prenom }}, {{ $user->getAge() }} ans</p><hr>
                    <div class="row">
                        <div class="col-md-6 mr-auto">
                            <p>Sexe : {{ $user->sexe }} </p>
                            <p>E-mail : {{ $user->email }} </p>
                            <p>Type de pelage : {{ $user->race }}</p>
                        </div>
                        <div class="col-md-6 ml-auto">
                            @if($user->sexe=='Masculin')
                                <p>Né le : {{ $user->dateNaissance }} </p>
                            @elseif($user->sexe=='Féminin')
                                <p>Née le : {{ $user->dateNaissance }} </p>
                            @else
                                <p>Né(e) le : {{ $user->dateNaissance }} </p>
                            @endif
                            <p>Téléphone : {{ $user->tel }} </p>
                            <p>Adresse : {{ $user->adresse }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-light">
            <h4 class="modal-title">Edition de mon compte</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <form method="POST" action="{{ route('editAccount', $user->id) }}" aria-label="{{ __('Edit élève') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-8 mx-auto">
                                <input id="nom" type="nom" class="form-control{{ $errors->has('nom') ? ' is-invalid' : '' }}" name="nom" value="{{ $user->nom }}" required autofocus>

                                @if ($errors->has('nom'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-8 mx-auto">
                                <input id="prenom" type="prenom" class="form-control{{ $errors->has('prenom') ? ' is-invalid' : '' }}" name="prenom" value="{{ $user->prenom }}" required autofocu>

                                @if ($errors->has('prenom'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('prenom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-8 mx-auto">
                                <input id="dateNaissance" type="date" class="form-control{{ $errors->has('dateNaissance') ? ' is-invalid' : '' }}" name="dateNaissance" value="{{ $user->dateNaissance }}" placeholder="Date de Naissance" required autofocus>

                                @if ($errors->has('dateNaissance'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dateNaissance') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @if($user->sexe=="Féminin")
                        <div class="form-group row">
                            <div class="col-md-8 mx-auto">
                                <div class="radio-inline">
                                    <input class="radio" type="radio" name="sexe" value ="Féminin" id="sexe" checked>

                                    <label class="radio-inline" for="sexe">
                                        {{ __('Féminin') }}
                                    </label>
                                    <input class="radio" type="radio" name="sexe" value ="Masculin" id="sexe">
                                    <label class="radio-inline" for="sexe">
                                        {{ __('Masculin') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="form-group row">
                            <div class="col-md-8 mx-auto">
                                <div class="radio-inline">
                                    <input class="radio" type="radio" name="sexe" value ="Féminin" id="sexe">

                                    <label class="radio-inline" for="sexe">
                                        {{ __('Féminin') }}
                                    </label>
                                    <input class="radio" type="radio" name="sexe" value ="Masculin" id="sexe" checked>
                                    <label class="radio-inline" for="sexe">
                                        {{ __('Masculin') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">

                            <div class="col-md-8 mx-auto">
                                <input id="tel" type="tel" class="form-control{{ $errors->has('tel') ? ' is-invalid' : '' }}" name="tel" value="{{ $user->tel }}" placeholder="Numéros de téléphone" required autofocus>

                                @if ($errors->has('tel'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tel') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-8 mx-auto">
                                <input id="adresse" type="adresse" class="form-control{{ $errors->has('adresse') ? ' is-invalid' : '' }}" name="adresse" value="{{ $user->adresse }}" placeholder="Houbba Adresse" required autofocus>

                                @if ($errors->has('adresse'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('adresse') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 mx-auto">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required autofocus>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 mx-auto">
                                <select class="form-control" name ="race" id="race" required aria-required="true">
                                    <option selected disabled="">Sélectionner votre type de pelage</option>
                                    <option value="Marsupilami jaune à tâches noire">Marsupilami jaune à tâches noire</option>
                                    <option value="Marsupilami noire à tâches jaune">Marsupilami noire à tâches jaune</option>
                                    <option value="Marsupilami jaune">Marsupilami jaune</option>
                                    <option value="Marsupilami noire">Marsupilami noire</option>
                                </select>
                            </div>
                        </div>
                        @if($user->privee)
                            <div class="form-group row">
                                <div class="col-md-8 mx-auto">
                                    <div class="radio-inline">
                                        <label for="privee" class="col-md-8 col-form-label">{{ __('Compte privée') }}</label>
                                        <input class="radio" type="radio" name="privee" value ="1" id="privee" checked>

                                        <label class="radio-inline" for="privee">
                                            {{ __('Oui') }}
                                        </label>
                                        <input class="radio" type="radio" name="privee" value ="0" id="privee">
                                        <label class="radio-inline" for="privee">
                                            {{ __('Non') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <div class="col-md-8 mx-auto">
                                    <div class="radio-inline">
                                        <label for="privee" class="col-md-8 col-form-label">{{ __('Compte privée') }}</label>
                                        <input class="radio" type="radio" name="privee" value ="1" id="privee">

                                        <label class="radio-inline" for="privee">
                                            {{ __('Oui') }}
                                        </label>
                                        <input class="radio" type="radio" name="privee" value ="0" id="privee" checked>
                                        <label class="radio-inline" for="privee">
                                            {{ __('Non') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif                           

                        <div class="form-group row mb-0">
                            <div class="col-md-8 mx-auto">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{ __('Editer') }}
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
