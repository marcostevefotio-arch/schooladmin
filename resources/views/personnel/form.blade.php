@extends('layouts.layout')


@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Create</li>
@endsection


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <form class="form-horizontal" role="form" method="post" action="{{ route("personnelStore") }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nom *</label>

                    <div class="col-sm-9">
                        <input type="text" id="lastname" placeholder="Nom" name="lastname" class="form-control @error('lastname') is-invalid @enderror" value="{{ isset($personnel)? $personnel->lastname : old('lastname') }}" required/>
                        @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Prénom *</label>

                    <div class="col-sm-9">
                        <input type="text" id="firstname" placeholder="Prénom" name="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ isset($personnel)? $personnel->firstname : old('firstname') }}" required/>
                        @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sexe *</label>

                    <div class="col-sm-9">
                        <select class="form-control @error('sexe') is-invalid @enderror" id="sexe" name="sexe" required>
                            <option value=""></option>
                            <option value="M" {{ old("sexe")=="M"? "selected" : "" }}>Homme</option>
                            <option value="F" {{ old("sexe")=="F"? "selected" : "" }}>Femme</option>
                        </select>
                        @error('sexe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Date de naissance *</label>

                    <div class="col-sm-9">
                        <input type="date" id="birthday" placeholder="Date de naissance" name="birthday" class="form-control @error('birthday') is-invalid @enderror" value="{{ isset($personnel)? $personnel->birthday : old('birthday') }}" required/>
                        @error('birthday')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Groupe *</label>

                    <div class="col-sm-9">
                        <select class="form-control @error('groupe') is-invalid @enderror" id="groupe" name="groupe" required>
                            <option value=""></option>
                            @foreach($groupe as $g)
                                <option value="{{ $g->id }}" {{ old("groupe")==$g->id? "selected" : "" }}>{{ $g->titre_groupe }}</option>
                            @endforeach
                        </select>
                        @error('groupe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Numero de la pièce d'identité (CNI) *</label>

                    <div class="col-sm-9">
                        <input type="text" id="cni" placeholder="Numéro de la pièce d'identité" name="cni" class="form-control @error('cni') is-invalid @enderror" value="{{ isset($personnel)? $personnel->cni : old('cni') }}" required/>
                        @error('cni')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Pays</label>

                    <div class="col-sm-9">
                        <input type="text" id="country" placeholder="Pays" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ isset($personnel)? $personnel->country : old('country') }}" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Adresse de residence</label>

                    <div class="col-sm-9">
                        <input type="text" id="address" placeholder="Adresse de residence" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ isset($personnel)? $personnel->address : old('address') }}"/>
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Numero de téléphone</label>

                    <div class="col-sm-9">
                        <input type="text" id="phone" placeholder="Numéro de téléphone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ isset($personnel)? $personnel->phone : old('phone') }}"/>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="form-group text-left">
                    <div class="col-sm-3 text-right">
                        <input type="checkbox" name="createUser" id="createUser"/>
                    </div>
                    <label class="col-sm-9 control-label" for="form-field-1-1" style="text-align: left!important;"> Creer un compte utilisateur pour ce personnel</label>
                </div>
                <div class="form-group" id="email_user" style="display: none">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Email *</label>

                    <div class="col-sm-9">
                        <input type="email" id="email" placeholder="Adresse email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ isset($personnel)? $personnel->email : old('email') }}"/>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-info" type="submit">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            Enregistrer
                        </button>

                        &nbsp; &nbsp; &nbsp;
                        <a class="btn" href="{{ route("user") }}">
                            <i class="ace-icon fa fa-undo bigger-110"></i>
                            Annuler
                        </a>
                    </div>
                </div>

                <div class="hr hr-24"></div>
            </form>

            <div class="hr hr-18 dotted hr-double"></div>

        </div><!-- /.col -->
    </div>

@endsection

@section("script")

    <script type="text/javascript">
        $(document).ready(function(){
            $("#createUser").change(function(){
                const checked = document.querySelector('#createUser:checked') !== null;
                if(checked){
                    $("#email_user").css("display", "block");
                }else{
                    $("#email_user").css("display", "none");
                }
            });
        })
    </script>
@endsection
