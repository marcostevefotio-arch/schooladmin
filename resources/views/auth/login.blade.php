@extends('layouts.guest')

@section('language')
    {{ (Session::has("locale"))? Session::get("locale") : "en" }}
@endsection

@section('lang')
    {{ (Session::has("locale"))? app()->setLocale(Session::get("locale")) : app()->setLocale('en') }}
@endsection

@section('content')
    <div class="login-container">
        <div class="space-6"></div>
        <br>
        <br>
        <div class="center">
            <h1 class="font-weight-bold" style="font-size: 60px; font-weight: bold; background: transparent; padding: 10px; margin-top:150px; color: #3268a8">
                <i class="ace-icon fa fa-graduation-cap primary"></i>&nbsp;
                <span class="font-weight-bold" style="color:#ffffff; text-shadow: 0px 2px 2px #3268a8">{{ config("app.name", "SCHOOLADMIN") }}</span>
            </h1>
        </div>

        <div class="space-6"></div>

        <div class="position-relative">
            <div id="login-box" class="login-box visible widget-box no-border">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="space-6"></div>
                        <h4 class="header blue lighter bigger">
                            <i class="ace-icon fa fa-coffee green"></i>
                            Remplissez les champs s'il vous plait!!!
                        </h4>

                        <div class="space-6"></div>

                        @if(Session::has("bd_error"))
                            <h6 class="alert alert-danger text-center">
                                {{ Session::get("bd_error") }}
                            </h6>
                        @endif

                        <div class="space-6"></div>

                        <form method="post" action="{{ route('login') }}">
                            @csrf
                            <fieldset>
                                <label class="block clearfix">
                                    <span class="block input-icon input-icon-right">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Identifiant" autofocus/>
                                        <i class="ace-icon fa fa-user"></i>
                                    </span>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>

                                <label class="block clearfix">
                                    <span class="block input-icon input-icon-right">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mot de passe"/>
                                        <i class="ace-icon fa fa-lock"></i>
                                    </span>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </label>

                                <div class="space"></div>

                                <div class="clearfix">
                                    <label class="inline">
                                        <input class="ace" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                                        <span class="lbl"> Se souvenir de moi</span>
                                    </label>

                                    <button type="submit" class="width-35 pull-right btn btn-sm btn-success">
                                        <i class="ace-icon fa fa-key"></i>
                                        <span class="bigger-110">Connexion</span>
                                    </button>
                                </div>

                                <div class="space-4"></div>
                            </fieldset>
                        </form>

                        {{--<div class="social-or-login center">--}}
                            {{--<span class="bigger-110">{{ trans('message.changeLanguageTitle') }}</span>--}}
                        {{--</div>--}}

                        <div class="space-6"></div>

                        <div class="social-login center">

                            &copy Steve M. {{ date("Y") }}
                            {{--<span class="block input-icon input-icon-right">--}}
                                {{--<select name="lang" id="lang" class="form-control">--}}
                                    {{--<option value="en" {{ (Session::has("locale"))? ((Session::get("locale")=="en")? "selected" : "") : "" }}>English</option>--}}
                                    {{--<option value="fr" {{ (Session::has("locale"))? ((Session::get("locale")=="fr")? "selected" : "") : "" }}>Francais</option>--}}
                                {{--</select>--}}
                                {{--<i class="ace-icon fa fa-globe"></i>--}}
                            {{--</span>--}}
                        </div>
                    </div><!-- /.widget-main -->

                </div><!-- /.widget-body -->
            </div><!-- /.login-box -->

        </div><!-- /.position-relative -->

    </div>
@endsection

@section("script")
    <script type="text/javascript">
        $(document).ready(function(){
            $("#lang").change(function(){
                var lang = $(this).val();
                choselange(lang);
            });
        })

        function choselange(lang){
            $.ajax({
                url: "lang/"+lang,
                type: "get",
                success: function (response) {
                    console.log("good");
                    location.reload();
                }
            })
        }

    </script>
@endsection
