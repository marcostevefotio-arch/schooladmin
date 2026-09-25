@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "Discipline" }}
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
            <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
                <h4 class="text-uppercase">
                    Spécialité: {{ $specialite->libelleSpecialite }} - {{ $specialite->codeSpecialite }}
                </h4>
            </div>
            <table id="dynamic-table" class="table table-bordered ">
                <thead>
                <th class="bg-primary">Matricule</th>
                <th class="bg-primary">Etudiant</th>
                <th class="bg-primary">Total absences</th>
                <th class="bg-primary">Journée</th>
                </thead>
                <tbody>
                @foreach($absences as $i=>$ab)
                    @foreach($ab as $j=>$et)
                        <tr>
                            <td>{{ $et->matriculeDossier }}</td>
                            <td>{{ $et->lastname }} {{$et->firstname}}</td>
                            <td>{{ $et->absences }}</td>
                            <td>{{ date("d/m/Y", strtotime($i)) }}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("script")
    <script src="{{ asset("") }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset("") }}assets/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.flash.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.html5.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.print.min.js"></script>
    <script src="{{ asset("") }}assets/js/buttons.colVis.min.js"></script>
    <script src="{{ asset("") }}assets/js/dataTables.select.min.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {

            var groupColumn = 3;
            var table = $('#dynamic-table').DataTable({
                columnDefs: [{ visible: false, targets: groupColumn }],
                order: [[groupColumn, 'asc']],
                displayLength: 25,
                drawCallback: function (settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var last = null;

                    api
                        .column(groupColumn, { page: 'current' })
                        .data()
                        .each(function (group, i) {
                            if (last !== group) {
                                $(rows)
                                    .eq(i)
                                    .before('<tr class="group"><td colspan="5" class="bg-info h4"><i class="fa fa-calendar-check-o"></i>&nbsp;' + group + '</td></tr>');

                                last = group;
                            }
                        });
                },
            });

            // Order by the grouping
            $('#dynamic-table tbody').on('click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
                    table.order([groupColumn, 'desc']).draw();
                } else {
                    table.order([groupColumn, 'asc']).draw();
                }
            });
        });
    </script>

@endsection
