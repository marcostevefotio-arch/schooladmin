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
        <div class="col-xs-12  col-md-12">
            <form action="{{ route("demandeStore") }}" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="specialite">Specialité *</label>
                    <select name="specialite" id="specialite" class="form-control" required>
                        <option value=""></option>
                        @foreach($filiere as $f)
                            <optgroup label="{{ $f->libelleFiliere }}">
                                @foreach($f->specialites as $s)
                                    @foreach($s->choice as $c)
                                        @if($c->etat==1)
                                            <option value="{{ $s->id }}">{{ $s->libelleSpecialite }}</option>
                                            @break
                                        @endif
                                    @endforeach
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <h4 id="chargement"></h4>
                </div>

                <div class="form-group">
                    <label for="specialite">Etudiant *</label>
                    <select name="etudiants" id="etudiants" class="form-control" required>
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="du">Du *</label>
                    <input type="date" name="du" id="du" value="{{ date("Y-m-d") }}" class="form-control form-control-sm" required/>
                </div>
                <div class="form-group">
                    <label for="au">Au *</label>
                    <input type="date" name="au" id="au" min="{{ date("Y-m-d") }}" class="form-control form-control-sm" required/>
                </div>
                <div class="form-group">
                    <label for="motif">Motif</label>
                    <textarea name="motif" rows="5" id="motif" class="form-control form-control-sm"></textarea>
                </div>
                <h4><button type="submit" id="submit" class="btn btn-primary" style="float: right; display: none"><i class="fa fa-save">&nbsp;Enregistrer</i></button></h4>
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
                                html+="<option value='"+item.inscrID+"'>"+item.lastname+" "+item.firstname+" ("+item.matriculeDossier+")</option>";
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
