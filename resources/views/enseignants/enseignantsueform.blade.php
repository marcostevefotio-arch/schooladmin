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
            <form action="{{ route("emStore") }}" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <h4 id="chargement"></h4>
                </div>

                <div class="form-group">
                    <label for="enseignant">Enseignants *</label>
                    <select name="enseignant" id="enseignant" class="form-control" required>
                        <option value=""></option>
                        @foreach($enseignants as $en)
                            <option value="{{ $en->id }}">{{ $en->lastname }} {{ $en->firstname }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="matiere">Unités d'enseignements *</label>
                    <select name="matiere" id="matiere" class="form-control" required>
                        <option value=""></option>
                        @foreach($ue as $matieres)
                            @foreach($matieres->matiere as $m)
                                <option value="{{ $m->id }}">{{ $matieres->codeUE }} - {{ $m->codeMatiere }} : {{ $m->libelleMatiere }} </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="matiere">Niveau *</label>
                    <select name="niveau" id="niveau" class="form-control" required>
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>


                <h4><button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-save">&nbsp;Enregistrer</i></button></h4>
            </form>
        </div>
    </div>
@endsection

@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/chosen.css" />
@endsection

@section("script")
    <script src="{{ asset("") }}assets/js/chosen.jquery.js"></script>
    <script src="{{ asset("") }}assets/js/spin.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $(document).ready(function(){
            var opts = {
                lines: 10, // The number of lines to draw
                length: 5, // The length of each line
                width: 10, // The line thickness
                radius: 20, // The radius of the inner circle
                scale: 1, // Scales overall size of the spinner
                corners: 1, // Corner roundness (0..1)
                speed: 3, // Rounds per second
                rotate: 0, // The rotation offset
                animation: 'spinner-line-fade-quick', // The CSS animation name for the lines
                direction: 1, // 1: clockwise, -1: counterclockwise
                opacity: 0.2,
                color: '#ffb411', // CSS color or array of colors
                fadeColor: 'transparent', // CSS color or array of colors
                top: '50%', // Top position relative to parent
                left: '50%', // Left position relative to parent
                shadow: false, // Box-shadow for the lines
                zIndex: 2000000000, // The z-index (defaults to 2e9)
                className: 'spinner', // The CSS class to assign to the spinner
                position: 'absolute', // Element positioning
            };
            var target = document.getElementById("chargement");
            var spinner = new Spinner(opts).spin();


            $.ajaxSetup({
                beforeSend: function () {
                    target.appendChild(spinner.el);
                },
                complete: function(){
                    target.removeChild(spinner.el);
                }
            })


            $("#specialite").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });

            $('#specialite').on('change', function(evt, params) {
                $.ajax({
                    url: "{{ route("etudiantAjaxList") }}",
                    type: "post",
                    data:{specialite: params.selected, _token: "{{ csrf_token() }}"},
                    dataType: "json",
                    success: function(response){
                        if(response.length>0){
                            $("#submit").css("display", "block");

                            var data = [];

                            var html = "<option value=''></option>";
                            response.forEach(function(item, index){
                                html+="<option value='"+item.id+"'>"+item.lastname+" "+item.firstname+" ("+item.matricule+")</option>";
                            });
                            $("#etudiants").empty();
                            $("#etudiants").append(html);
                        }else{
                            $("#submit").css("display", "none");
                        }
                    },
                });
            });

            $("#du").change(function(){
                var min = $("#du").val();
                if(min!=null){
                    $("#auContent").css("display", "block");
                    $("#au").attr("min", min);
                }
            });

//            setTimeout(function(){
//                $("div.alert").toggle();
//            }, 5000 ); // 5 secs

        })
    </script>

@endsection
