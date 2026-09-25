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
        <div class="col-lg-12 col-md-12">
            <div class="card bg-transparent">
                <div class="card-body">
                    <form action="{{ isset($data)? route("ueUpdate", ["slug"=>$data->id]): route("ueStore") }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="h6">
                                        &nbsp;Spécialité *
                                    </label>
                                    <select name="specialite" class="form-control" id="specialite" required >
                                        <option value=""></option>
                                        @foreach($specialite as $f)
                                            <option value="{{ $f->codeSpecialite }}"
                                                    {{ (old("specialite")==$f->codeSpecialite)?
                                                    "selected" :
                                                    ((isset($data) && ($data->specialite->codeSpecialite==$f->codeSpecialite))?
                                                     "selected" : "")
                                                     }}>{{ $f->codeSpecialite }} - {{ $f->libelleSpecialite }}</option>
                                        @endforeach
                                    </select>

                                    @error("specialite")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="h6">
                                        Semestre *
                                    </label>
                                    <select name="semestre" class="form-control" id="semestre" required >
                                        <option value=""></option>
                                        @foreach($semestre as $s)
                                            <option value="{{ $s->id }}" {{ (old("semestre")==$s->id)? "selected" :  ((isset($data) && $data->semestre_id==$s->id)? "selected" : "")  }}>{{ $s->libelleSemestre }}</option>
                                        @endforeach
                                    </select>

                                    @error("semestre")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="h6">
                                        Code de l'UE *
                                    </label>
                                    <input class="form-control input-mask-phone" type="text" id="codeue" name="codeue" value="{{  isset($data)? $data->codeUE : old("codeue") }}" required />

                                    @error("codeue")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="h6">
                                        &nbsp;Unité d'enseignement *
                                    </label>
                                    <select name="ue" class="form-control" id="ue" required >
                                        <option value=""></option>
                                        @foreach($ues as $ue)
                                            <option value="{{ $ue->id }}" {{ (old("ue")==$ue->id)? "selected" :  ((isset($data) && $data->typeue_id==$ue->id)? "selected" : "")  }}>{{ $ue->libelletypeue  }}</option>
                                        @endforeach
                                    </select>

                                    @error("ue")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="h6">
                                        Intitulé de l'enseignement *
                                    </label>
                                    <input class="form-control input-mask-phone" type="text" id="libelleue" name="libelleue" value="{{ isset($data)? $data->libelleUE : old("libelleue") }}" required/>

                                    @error("libelleue")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="h6">CM</label>
                                    <input class="form-control input-mask-phone" type="number" min="0" id="cm" name="cm" value="{{ isset($data)? $data->cm : old("cm") }}" required />

                                    @error("cm")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="h6">TD</label>
                                    <input class="form-control input-mask-phone" type="number" min="0" id="td" name="td" value="{{ isset($data)? $data->td : old("td") }}" required />

                                    @error("td")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="h6">TP</label>
                                    <input class="form-control input-mask-phone" type="number" min="0" id="tp" name="tp" value="{{ isset($data)? $data->tp : old("tp") }}" required />

                                    @error("tp")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="h6">TPE</label>
                                    <input class="form-control input-mask-phone" type="number" min="0" id="tpe" name="tpe" value="{{ isset($data)? $data->tpe : old("tpe") }}" required />

                                    @error("tpe")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="h6">Total *</label>
                                    <input class="form-control input-mask-phone" type="number" min="0" id="total" name="total" value="{{ isset($data)? $data->total : old("total") }}" required  readonly=""/>

                                    @error("total")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group" >
                                    <label class="h6">Nombre de Crédit *</label>
                                    <input class="form-control input-mask-phone" type="number" min="0" id="credit" name="credit" value="{{ isset($data)? $data->credit : old("credit") }}" required readonly=""/>

                                    @error("credit")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6"></div>

                        </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save">&nbsp;</i>Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
            @if(!isset($data))
                var cm = $("#cm").val(0);
                var td = $("#td").val(0);
                var tp = $("#tp").val(0);
                var tpe = $("#tpe").val(0);
            @endif

            $("#cm").change(function(){
                var cm = $("#cm").val();
                var td = $("#td").val();
                var tp = $("#tp").val();
                var tpe = $("#tpe").val();

                var total = parseInt(cm)+parseInt(td)+parseInt(tp)+parseInt(tpe);
                $("#total").val(total);
                $("#credit").val(Math.round(total/15));
            });

            $("#td").change(function(){
                var cm = $("#cm").val();
                var td = $("#td").val();
                var tp = $("#tp").val();
                var tpe = $("#tpe").val();

                var total = parseInt(cm)+parseInt(td)+parseInt(tp)+parseInt(tpe);
                $("#total").val(total);
                $("#credit").val(Math.round(total/15));
            });

            $("#tp").change(function(){
                var cm = $("#cm").val();
                var td = $("#td").val();
                var tp = $("#tp").val();
                var tpe = $("#tpe").val();

                var total = parseInt(cm)+parseInt(td)+parseInt(tp)+parseInt(tpe);
                $("#total").val(total);
                $("#credit").val(Math.round(total/15));
            });

            $("#tpe").change(function(){
                var cm = $("#cm").val();
                var td = $("#td").val();
                var tp = $("#tp").val();
                var tpe = $("#tpe").val();

                var total = parseInt(cm)+parseInt(td)+parseInt(tp)+parseInt(tpe);
                $("#total").val(total);
                $("#credit").val(Math.round(total/15));
            });

        })
    </script>
@endsection
