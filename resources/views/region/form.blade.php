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
            <form action="{{ isset($data)? route("regionUpdate", ["slug"=>$data->id]) : route("regionStore") }}" method="post">
                @csrf
                <div class="form-group">
                    <label>
                        <h4 class="">Pays *</h4>
                    </label>
                    <select class="form-control input-mask-phone @error('pays_id') is-invalid @enderror" id="pays_id" name="pays_id"  required>
                        <option value=""></option>
                        @foreach($pays as $p)
                            <option value="{{ $p->id }}" {{ isset($data)? (($data->pays_id==$p->id)? "selected" : "") : old('pays_id') }}>({{ $p->codePays }}, {{ $p->indicatifPays }})&nbsp;{{ $p->nomPays }}</option>
                        @endforeach
                    </select>
                    @error('pays_id')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>
                        <h4 class="">Code de la région *</h4>
                    </label>
                    <input class="form-control input-mask-phone @error('codeRegion') is-invalid @enderror" type="text" id="codeRegion" name="codeRegion" value="{{ isset($data)? $data->codeRegion : old('codeRegion') }}" required/>
                    @error('codeRegion')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>
                        <h4 class="">Nom de la région</h4>
                    </label>
                    <input class="form-control input-mask-phone @error('nomRegion') is-invalid @enderror" type="text" id="nomRegion" name="nomRegion" value="{{ isset($data)? $data->nomRegion : old('nomRegion') }}" required/>
                    @error('nomRegion')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>


                <div class="form-group">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save">&nbsp;</i>Enregistrer</button>
                    </div>
                </div>
            </form>

            <div class="hr hr-18 dotted hr-double"></div>

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

    <script type="text/javascript">
        jQuery(function($) {
            var myTable =
                $('#dynamic-table')
                    .DataTable( {
                        bAutoWidth: false,
                        "aoColumns": [
                            { "bSortable": false },
                            null, null,null, null,
                            { "bSortable": false }
                        ],
                        "aaSorting": [],
                        select: {
                            style: 'multi'
                        }
                    } );

        })
    </script>
@endsection
