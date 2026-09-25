@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Liste</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-11 label label-lg label-primary arrowed-in arrowed-right">
            <b>Etat général</b>
            <div class="space"></div>
        </div>
        <div class="space"></div>
        <div class="col-xs-2 label label-lg label-success arrowed-in arrowed-right">
            <b>Effectifs</b>
            <div class="space"></div>
        </div>
        <div class="col-xs-12 infobox-container">
            <div class="space"></div>
            <div class="infobox infobox-green">
                <div class="infobox-icon">
                    <i class="icon-comments"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number">{{ $state["etudiants"] }}</span>
                    <div class="infobox-content"><b>Effectif total des etudiants</b></div>
                </div>
            </div>

            <div class="infobox infobox-blue">
                <div class="infobox-icon">
                    <i class="icon-twitter"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number">{{ $state["etudiantsG"] }}</span>
                    <div class="infobox-content"><b>Garcons</b></div>
                </div>

                <div class="badge badge-blue">
                    <i class="fa fa-mars-stroke"></i>
                </div>
            </div>

            <div class="infobox infobox-blue">
                <div class="infobox-icon">
                    <i class="icon-twitter"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number">{{ $state["etudiantsF"] }}</span>
                    <div class="infobox-content"><b>Filles</b></div>
                </div>

                <div class="badge badge-pink">
                    <i class="fa fa-venus"></i>
                </div>
            </div>

            <div class="space-6"></div>

        </div>
        <div class="space"></div>

        <div class="col-xs-2 offset-10 label label-lg label-success arrowed-in arrowed-right">
            <b>Filièrs et spécialités</b>
            <div class="space"></div>
        </div>
        <div class="col-xs-10"></div>

        <div class="col-xs-6">
            <h6 class="text-center text-uppercase font-weight-bold">Effectif par filieres</h6>
            <div class="responsive">
                <div id="effectifFiliere" style="height: 250px;"></div>
            </div>
        </div>
        <div class="col-xs-6">
            <h6 class="text-center text-uppercase font-weight-bold">Effectif par Specialité</h6>
            <div class="responsive" >
                <div id="effectifSpecialite" style="height: 250px;"></div>
            </div>
        </div>


        <div class="col-xs-11 label label-lg label-primary arrowed-in arrowed-right">
            <b>Etat Spécifique</b>
            <div class="space"></div>
        </div>
        <div class="space"></div>

        <div class="col-xs-12">
            <label for=""></label>Années academique
            <select name="annee" id="annee" class="form-control">
                <option value=""></option>
                @foreach($state["annee"] as $annee)
                    <option value="{{ $annee->id }}">{{ $annee->numeroAnnee }}-{{ intval($annee->numeroAnnee)+1 }}</option>
                @endforeach
            </select>
            <br>
        </div>
        <div class="space"></div>

        <div class="col-xs-2 offset-10 label label-lg label-success arrowed-in arrowed-right">
            <b>Filièrs et spécialités</b>
            <div class="space"></div>
        </div>
        <div class="col-xs-10"></div>
        <div class="col-xs-6">
            <h6 class="text-center text-uppercase font-weight-bold">Effectif validé par Spécialité</h6>
            <div class="responsive">
                <div id="effectif1" style="height: 250px;"></div>
            </div>
        </div>
        <div class="col-xs-12">
            <h6 class="text-center text-uppercase font-weight-bold">Effectif de choix par filieres</h6>
            <div class="responsive">
                <div id="effectif2" style=""></div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset("") }}assets/css/morris.css">
@endsection

@section("script")
    <script src="{{ asset("") }}assets/js/jquery1.9.0.min.js"></script>
    <script src="{{ asset("") }}assets/js/raphael-min.js"></script>
    <script src="{{ asset("") }}assets/js/morris.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var token = "{{ csrf_token() }}";
            $.ajax({
                url:"{{ route("inscriptionEffectifGeneral") }}",
                type:"post",
                dataType:"json",
                data:{_token: token },
                success: function(response){
                    console.log(response);
                    courbeGenerale(response);
                },
            })

            $("#annee").change(function(){
                var annee = $("#annee").val();
               effectifFiliere(annee)
            });


            function effectifFiliere(annee){
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url:"{{ route("inscriptionEffectif") }}",
                    type:"post",
                    dataType:"json",
                    data:{annee: annee, _token: token },
                    success: function(response){
                        console.log(response);
                        courbeEffectifs(response);
                    },
                })
            }

            function courbeGenerale(data){
                var dataEffectifFiliere = [];
                var dataEffectifSpecialite = [];
                data[0].forEach(function(item){
                    dataEffectifFiliere.push({specialite: item.codeFiliere, effectif: item.effectifs})
                });
                data[1].forEach(function(item){
                    dataEffectifSpecialite.push({specialite: item.codeSpecialite, effectif: item.effectifs})
                });

                $("#effectifFiliere").empty();
                $("#effectifSpecialite").empty();
                new Morris.Bar({
                    element: 'effectifFiliere',
                    data: dataEffectifFiliere,
                    xkey: 'specialite',
                    ykeys: ['effectif'],
                    labels: ['Effectif'],
                });
                new Morris.Bar({
                    element: 'effectifSpecialite',
                    data: dataEffectifSpecialite,
                    xkey: 'specialite',
                    ykeys: ['effectif'],
                    labels: ['Effectif'],
                });
            }

            function courbeEffectifs(data){
                var dataEffectif1 = [];
                var dataEffectif2 = [];
                data[0].forEach(function(item){
                    dataEffectif1.push({specialite: item.codeSpecialite, effectif: item.effectifs})
                });
                data[1].forEach(function(item){
                    dataEffectif2.push({specialite: item.codeSpecialite, effectif: item.effectifs})
                });

                $("#effectif1").empty();
                $("#effectif2").empty();
                new Morris.Bar({
                    element: 'effectif1',
                    data: dataEffectif1,
                    xkey: 'specialite',
                    ykeys: ['effectif'],
                    labels: ['Effectif'],
                });
                new Morris.Bar({
                    element: 'effectif2',
                    data: dataEffectif2,
                    xkey: 'specialite',
                    ykeys: ['effectif'],
                    labels: ['Effectif'],
                });
            }
        });
    </script>
@endsection
