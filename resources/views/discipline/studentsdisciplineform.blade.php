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
            <form action="{{ route("disciplineETStore") }}" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="specialite">Specialité</label>

                    <select name="specialite" id="specialite">
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
                    <label for="journee">Nombre d'heures</label>
                    <input type="date" name="journee" id="journee" value="{{ date("Y-m-d") }}" class="form-control form-control-sm"/>
                </div>
                <div class="form-group">
                    <h2>Nombre d'etudiants: (<span id="totalStudents">0</span>)</h2>
                    <h4 id="chargement"></h4>
                </div>
                <div class="table-responsive" id="listeStudents" style="display: none">
                    <H2>Liste des étudiants de la spécialité (<span id="libelleSPecialite"></span>)</H2>
                    <table class="table table-bordered table-striped" id="students">
                        <thead>
                        <th>#</th>
                        <th>Matricule</th>
                        <th>Etudiant</th>
                        <th>Absences</th>
                        </thead>
                    </table>
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
    {{--<script src="{{ asset("") }}assets/js/jquery-3.2.1.min.js"></script>--}}
    <script src="{{ asset("") }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset("") }}assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset("") }}assets/js/chosen.jquery.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.flash.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.html5.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.print.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.colVis.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.select.min.js"></script>
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
                position: 'RELATIVE', // Element positioning
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
                           $("#totalStudents").text(response.length);
                           $("#listeStudents").css("display", "block");
                           $("#submit").css("display", "block");

                           var data = [];

                           var html = "";
                           response.forEach(function(item, index){
                               var absence = ((typeof(item.absences) != 'undefined') && item.absences!= null)? item.absences : 0;
                               data.push([
                                   (index + 1),
                                   item.matriculeDossier,
                                   item.lastname + " " + item.firstname,
                                   "<input type='number' name=" + item.id + " min='0' max='10' style='width: 100%' value='"+absence+"'>"
                               ]);
                           });

                           $("#students").dataTable({
                               "aaData": data,
                               "bDestroy": true,
                               "columnDefs": [
                                   { "width": "40%", "targets": 3 }
                               ],
                           });
                       }else{
                           $("#totalStudents").text(response.length);
                           $("#listeStudents").css("display", "none");
                           $("#submit").css("display", "none");
                       }


                       $("#libelleSPecialite").text($("#specialite option:selected").text());
                       $("#etudiants").empty();
                       $("#etudiants").append(html);
                   },
                });
            });
        })
    </script>

@endsection
