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
        <div class="col-xs-12">
            <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
                <div class="btn-group">
                    {{--<a href="{{ route("notesForm") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>&nbsp;Enregistrer les notes</a>--}}
                    <a href="{{ route("matiere") }}" class="btn btn-info btn-sm"><i class="fa fa-table"></i>&nbsp;Matieres</a>
                    <a href="{{ route("classe") }}" class="btn btn-info btn-sm"><i class="fa fa-table"></i>&nbsp;Classes</a>
                </div>
            </div>
            <div class="table-header">
                Enregistrement de l'évaluations
            </div>

            <form action="{{ route("notesStore") }}" method="post">
                {{ csrf_field() }}
                <div>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Specialite</th>
                            <th>Matiere</th>
                            <th>Evaluation</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>
                                <select name="semestre" id="semestre" class="form-control" required>
                                    <option value=""></option>
                                    @foreach($data["semestre"] as $s)
                                        <option value="{{ $s->id }}">{{ $s->libelleSemestre }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="specialite" id="specialite" class="form-control" required>
                                    <option value=""></option>
                                    @foreach($data["specialite"] as $s)
                                        <option value="{{ $s->id }}">{{ $s->libelleSpecialite }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="matiere" id="matiere" class="form-control" required>
                                    <option value=""></option>

                                </select>
                            </td>
                            <td>
                                <select name="evaluation" id="evaluation" class="form-control" required>
                                    <option value=""></option>
                                    <option value="cc">Control continu</option>
                                    <option value="normal">Nomale</option>
                                    <option value="recove">Rattrapage</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <div>
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom et prenom</th>
                            <th>Note /20</th>
                        </tr>
                        </thead>

                        <tbody id="etudiants">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <br>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section("script")
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/buttons.flash.min.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.colVis.min.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>
    <script src="assets/js/jquery.maskedinput.min.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $(document).ready(function(){

            $(".mask").mask("99");

            $("#specialite").change(function(){
                var specialite = $("#specialite").val();
                var semestre = $("#semestre").val();
                var examen = $("#evaluation").val();
                $("#semestre").css("border", "1px solid #D5D5D5");
                $("#specialite").css("border", "1px solid #D5D5D5");

                if(semestre !="" && examen!=""){
                    $.ajax({
                        url: "{{ route("getMatieres") }}",
                        type: "post",
                        dataType: "json",
                        data: {specialite: specialite, semestre:semestre, examen:examen, _token: "{{ csrf_token() }}"},
                        success: function(response){
                            var html= '<option value=""></option>';
                            $("#matiere").empty();
                            if(response[0].length>0){
                                response[0].forEach(function(item){
                                    html+='<option value="'+item.id+'">('+item.codeUE+') '+item.libelleMatiere+'</option>'
                                })
                            }

                            $("#matiere").append(html);


                            var html2= '';
                            if(response[1].length>0){
                                response[1].forEach(function(item){
                                    html2+='<tr>';
                                    html2+='<td>'+item.matriculeDossier+'</td>';
                                    html2+='<td>'+item.lastname+' '+item.firstname+'</td>';
                                    html2+='<td><input type="number" name="'+item.id+'" class="form-control mask" max="20" min="0" step="0.01" value="0" required></td>';
                                    html2+='</tr>';
                                });
                                $("#etudiants").empty();
                                $("#etudiants").append(html2);
                            }
                        },
                    });
                }else{
                    $("#semestre").css("border", "1px solid red");
                }
            });

            $("#semestre").change(function(){
                var specialite = $("#specialite").val();
                var semestre = $("#semestre").val();
                var examen = $("#evaluation").val();
                $("#semestre").css("border", "1px solid #D5D5D5");
                $("#specialite").css("border", "1px solid #D5D5D5");

                if(semestre !="" && examen!=""){
                    $.ajax({
                        url: "{{ route("getMatieres") }}",
                        type: "post",
                        dataType: "json",
                        data: {specialite: specialite, semestre:semestre, examen:examen, _token: "{{ csrf_token() }}"},
                        success: function(response){
                            var html= '<option value=""></option>';
                            if(response[0].length>0){
                                response[0].forEach(function(item){
                                    html+='<option value="'+item.id+'">('+item.codeUE+') '+item.libelleMatiere+'</option>'
                                })
                            }
                            $("#matiere").empty();
                            $("#matiere").append(html);
                        },
                    });
                }else{
                    $("#semestre").css("border", "1px solid red");
                }
            });

            $("#evaluation").change(function(){
                var specialite = $("#specialite").val();
                var semestre = $("#semestre").val();
                var examen = $("#evaluation").val();
                $("#semestre").css("border", "1px solid #D5D5D5");
                $("#specialite").css("border", "1px solid #D5D5D5");

                if(semestre !="" && examen!=""){
                    $.ajax({
                        url: "{{ route("getMatieres") }}",
                        type: "post",
                        dataType: "json",
                        data: {specialite: specialite, semestre:semestre, examen:examen, _token: "{{ csrf_token() }}"},
                        success: function(response){
                            console.log(examen);
                            var html= '<option value=""></option>';
                            $("#matiere").empty();
                            if(response[0].length>0){
                                response[0].forEach(function(item){
                                    html+='<option value="'+item.id+'">('+item.codeUE+') '+item.libelleMatiere+'</option>'
                                })
                            }

                            $("#matiere").append(html);


                            var html2= '';
                            if(response[1].length>0){
                                response[1].forEach(function(item){
                                    html2+='<tr>';
                                    html2+='<td>'+item.matricule+'</td>';
                                    html2+='<td>'+item.lastname+' '+item.firstname+'</td>';
                                    html2+='<td><input type="number" name="'+item.id+'" class="form-control mask" max="20" min="0" step="0.01" value="0" required></td>';
                                    html2+='</tr>';
                                });
                                $("#etudiants").empty();
                                $("#etudiants").append(html2);
                            }
                        },
                    });
                }else{
                    $("#semestre").css("border", "1px solid red");
                }
            });
        });

        jQuery(function($) {
            //initiate dataTables plugin
            var myTable =
                $('#dynamic-table').DataTable();



            $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

            new $.fn.dataTable.Buttons( myTable, {
                buttons: [
                    {
                        "extend": "colvis",
                        "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
                        "className": "btn btn-white btn-primary btn-bold",
                        columns: ':not(:first):not(:last)'
                    },
                    {
                        "extend": "copy",
                        "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                    },
                    {
                        "extend": "csv",
                        "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                    },
                    {
                        "extend": "excel",
                        "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                    },
                    {
                        "extend": "pdf",
                        "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                    },
                    {
                        "extend": "print",
                        "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
                        "className": "btn btn-white btn-primary btn-bold",
                        autoPrint: false,
                        message: 'This print was produced using the Print button for DataTables'
                    }
                ]
            } );
            myTable.buttons().container().appendTo( $('.tableTools-container') );

            //style the message box
            var defaultCopyAction = myTable.button(1).action();
            myTable.button(1).action(function (e, dt, button, config) {
                defaultCopyAction(e, dt, button, config);
                $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
            });


            var defaultColvisAction = myTable.button(0).action();
            myTable.button(0).action(function (e, dt, button, config) {

                defaultColvisAction(e, dt, button, config);


                if($('.dt-button-collection > .dropdown-menu').length == 0) {
                    $('.dt-button-collection')
                        .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                        .find('a').attr('href', '#').wrap("<li />")
                }
                $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
            });

            ////

            setTimeout(function() {
                $($('.tableTools-container')).find('a.dt-button').each(function() {
                    var div = $(this).find(' > div').first();
                    if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
                    else $(this).tooltip({container: 'body', title: $(this).text()});
                });
            }, 500);





            myTable.on( 'select', function ( e, dt, type, index ) {
                if ( type === 'row' ) {
                    $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
                }
            } );
            myTable.on( 'deselect', function ( e, dt, type, index ) {
                if ( type === 'row' ) {
                    $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
                }
            } );




            /////////////////////////////////
            //table checkboxes
            $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

            //select/deselect all rows according to table header checkbox
            $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
                var th_checked = this.checked;//checkbox inside "TH" table header

                $('#dynamic-table').find('tbody > tr').each(function(){
                    var row = this;
                    if(th_checked) myTable.row(row).select();
                    else  myTable.row(row).deselect();
                });
            });

            //select/deselect a row when the checkbox is checked/unchecked
            $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
                var row = $(this).closest('tr').get(0);
                if(this.checked) myTable.row(row).deselect();
                else myTable.row(row).select();
            });



            $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
                e.stopImmediatePropagation();
                e.stopPropagation();
                e.preventDefault();
            });



            //And for the first simple table, which doesn't have TableTools or dataTables
            //select/deselect all rows according to table header checkbox
            var active_class = 'active';
            $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
                var th_checked = this.checked;//checkbox inside "TH" table header

                $(this).closest('table').find('tbody > tr').each(function(){
                    var row = this;
                    if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                    else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                });
            });

            //select/deselect a row when the checkbox is checked/unchecked
            $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
                var $row = $(this).closest('tr');
                if($row.is('.detail-row ')) return;
                if(this.checked) $row.addClass(active_class);
                else $row.removeClass(active_class);
            });



            /********************************/
            //add tooltip for small view action buttons in dropdown menu
            $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

            //tooltip placement on right or left
            function tooltip_placement(context, source) {
                var $source = $(source);
                var $parent = $source.closest('table')
                var off1 = $parent.offset();
                var w1 = $parent.width();

                var off2 = $source.offset();
                //var w2 = $source.width();

                if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
                return 'left';
            }


            $('.show-details-btn').on('click', function(e) {
                e.preventDefault();
                $(this).closest('tr').next().toggleClass('open');
                $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
            });

        })
    </script>
@endsection
