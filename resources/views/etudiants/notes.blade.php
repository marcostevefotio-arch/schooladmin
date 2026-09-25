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

            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-large">
                            <h3 class="widget-title grey lighter">
                                <i class="ace-icon fa fa-eye green"></i>
                                Fiche d'inscription
                            </h3>

                            <div class="widget-toolbar no-border invoice-info">
                                <span class="invoice-info-label">N° de dossier :</span>
                                <span class="red">{{ $data->filenumber }}</span>

                                <br />
                                <span class="invoice-info-label">Matricule :</span>
                                <span class="blue">{{ $data->matricule }}</span>
                            </div>

                            <div class="widget-toolbar hidden-480">
                                <a href="{{ route("inscriptionPrint", ["slug"=>$data->id]) }}" target="_blank">
                                    <i class="ace-icon fa fa-print"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-24">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                                <b>INFORMATION DE BASE</b>
                                            </div>
                                        </div>

                                        <div>
                                            <ul class="list-unstyled spaced">
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>{{ $data->filenumber }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>{{ $data->matricule }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Année scolaire :
                                                    <b class="red">{{ $data->year }}</b>
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Date de dépot de dossier :
                                                    <b class="red">{{ $data->depositedate }}</b>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- /.col -->

                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                                <b>IDENTIFICATION DU CANDIDAT</b>
                                            </div>
                                        </div>

                                        <div>
                                            <ul class="list-unstyled  spaced">
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->etudiant->firstname }}{{ $data->etudiant->lastname }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>Né le {{ $data->etudiant->birthday }} à {{ $data->etudiant->birthplace }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->etudiant->nationality }}, {{ $data->etudiant->region }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->etudiant->phonenumber }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->etudiant->email }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>{{ $data->etudiant->language }}
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Sport & loisir :
                                                    <b class="red">{{ $data->etudiant->sport }}, {{ $data->etudiant->leisure }}</b>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->

                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                        <b>PROFIL SCOLAIRE</b>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <table class="table table-striped table-bordered">
                                        <tbody>

                                        <tr>
                                            <td class="center"><h6>Diplome d'admission :</h6></td>

                                            <td>
                                                <a href="#">{{ $data->parcour->admissiondiploma }}</a>
                                            </td>
                                            <td class="hidden-xs">
                                                <h6>Série :</h6>
                                            </td>
                                            <td class="hidden-480"> {{ $data->parcour->option }} </td>
                                        </tr>
                                        <tr>
                                            <td class="center"><h6>Année d'obtention :</h6></td>

                                            <td>
                                                <a href="#">{{ $data->parcour->schoolyear }}</a>
                                            </td>
                                            <td class="hidden-xs">
                                                <h6>Ecole :</h6>
                                            </td>
                                            <td class="hidden-480"> {{ $data->parcour->schoolattended }} </td>
                                        </tr>
                                        <tr>
                                            <td class="center font-weight-bold" colspan="2"><h6>Pays d'obtention :</h6></td>

                                            <td  colspan="2">
                                                <a href="#">{{ $data->parcour->diplomacountry }}</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="space"></div>
                                <div class="row">
                                    <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                        <b>INFORMATIONS COMPLEMENTAIRES</b>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <table class="table table-striped table-bordered">

                                        <tbody>
                                        <tr>
                                            <td class="center">Nom du père :</td>

                                            <td><a href="#">{{ $data->etudiant->parent->fathername }}</a></td>
                                            <td class="hidden-xs">Profession :</td>
                                            <td class="hidden-480">{{ $data->etudiant->parent->fatherprofession }} </td>
                                            <td>Contact :</td>
                                            <td>{{ $data->etudiant->parent->fathercontact }}</td>
                                        </tr>
                                        <tr>
                                            <td class="center">Nom de la mère :</td>

                                            <td><a href="#">{{ $data->etudiant->parent->mothername }}</a></td>
                                            <td class="hidden-xs">Profession :</td>
                                            <td class="hidden-480">{{ $data->etudiant->parent->motherprofession }} </td>
                                            <td>Contact :</td>
                                            <td>{{ $data->etudiant->parent->mothercontact }}</td>
                                        </tr>
                                        <tr>
                                            <td class="center">Personne à contacter :</td>

                                            <td><a href="#" colspan="2">{{ $data->etudiant->parent->emergencyname }}</a></td>
                                            <td class="hidden-xs">Contact :</td>
                                            <td class="hidden-480" colspan="2">{{ $data->etudiant->parent->emergencycontact }} </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
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


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {
            //initiate dataTables plugin
            var myTable =
                $('#dynamic-table')
                //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                    .DataTable( {
                        bAutoWidth: false,
                        "aoColumns": [
                            { "bSortable": false },
                            null, null,null, null,
                            { "bSortable": false }
                        ],
                        "aaSorting": [],


                        //"bProcessing": true,
                        //"bServerSide": true,
                        //"sAjaxSource": "http://127.0.0.1/table.php"	,

                        //,
                        //"sScrollY": "200px",
                        //"bPaginate": false,

                        //"sScrollX": "100%",
                        //"sScrollXInner": "120%",
                        //"bScrollCollapse": true,
                        //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
                        //you may want to wrap the table inside a "div.dataTables_borderWrap" element

                        //"iDisplayLength": 50


                        select: {
                            style: 'multi'
                        }
                    } );



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
