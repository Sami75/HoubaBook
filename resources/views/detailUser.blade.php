@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
    
                <div class="card-header">
                    {{ $user->nom }} {{ $user->prenom }}, {{ $user->getAge() }} ans<br/>
                    <div class="col-md-6 mx-auto">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$percent}}%;" >Profil completé à {{round($percent)}}%</div>
                        </div>
                    </div>
                </div>
                <div class="card-body"><hr>
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
@endsection
