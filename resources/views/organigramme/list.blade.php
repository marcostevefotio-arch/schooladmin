@extends('layouts.layout')

@section('title')
    {{ isset($title)? $title : "" }}
@endsection

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ isset($module)? route($module->code_menu) : "" }}">{{ isset($parent)? $parent : "" }}</a></li>
    <li><i class="ace-icon home-icon"></i><a href="{{ $option_route }}">{{ isset($title)? $title : "" }}</a></li>
    <li class="active">Arborecence</li>
@endsection

@section('content')

    <div class="row">


        <div class="col-sm-12">
            <div class="widget-box">

                <div class="widget-body">
                    <div class="widget-main no-padding-top">
                        <div class="page-header">
                            <a href="{{ route("organisationcreate") }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i>&nbsp;Ajouter un service</a>
                            <span class="blue bolder"></span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-info">
                                    <th>N°</th>
                                    <th>Servive</th>
                                    <th>Présentation</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($data as $i=>$d)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $d->organisationTitle }}</td>
                                            <td>{{ $d->organisationDescription }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route("organisationEdit", ["slug"=>$d->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route("organisationDelete", ["slug"=>$d->id]) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@section("script")
    <script src="assets/js/tree.min.js"></script>


    <script type="text/javascript">
        jQuery(function($){

            var sampleData = initiateDemoData();//see below


            $('#tree1').ace_tree({
                dataSource: sampleData['dataSource1'],
                multiSelect: true,
                cacheItems: true,
                'open-icon' : 'ace-icon tree-minus',
                'close-icon' : 'ace-icon tree-plus',
                'itemSelect' : true,
                'folderSelect': false,
                'selected-icon' : 'ace-icon fa fa-check',
                'unselected-icon' : 'ace-icon fa fa-times',
                loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
                'selectable' : true,
                onclick: function(data){
                    console.log("bine")
                }
            });



            function initiateDemoData(){

                var tree_data = {
                    'for-sale' : {text: 'For Sale', type: 'folder'}	,
                    'vehicles' : {text: 'Vehicles', type: 'folder'}	,
                    'rentals' : {text: 'Rentals', type: 'folder'}	,
                    'real-estate' : {text: 'Real Estate', type: 'folder'}	,
                    'pets' : {text: 'Pets', type: 'folder'}	,
                    'tickets' : {text: 'Tickets', type: 'item'}	,
                    'services' : {text: 'Services', type: 'item'}	,
                    'personals' : {text: 'Personals', type: 'item'}
                }
                tree_data['for-sale']['additionalParameters'] = {
                    'children' : {
                        'appliances' : {text: 'Appliances', type: 'item'},
                        'arts-crafts' : {text: 'Arts & Crafts', type: 'item'},
                        'clothing' : {text: 'Clothing', type: 'item'},
                        'computers' : {text: 'Computers', type: 'item'},
                        'jewelry' : {text: 'Jewelry', type: 'item'},
                        'office-business' : {text: 'Office & Business', type: 'item'},
                        'sports-fitness' : {text: 'Sports & Fitness', type: 'item'}
                    }
                }
                tree_data['vehicles']['additionalParameters'] = {
                    'children' : {
                        'cars' : {text: 'Cars', type: 'folder'},
                        'motorcycles' : {text: 'Motorcycles', type: 'item'},
                        'boats' : {text: 'Boats', type: 'item'}
                    }
                }
                tree_data['vehicles']['additionalParameters']['children']['cars']['additionalParameters'] = {
                    'children' : {
                        'classics' : {text: 'Classics', type: 'item'},
                        'convertibles' : {text: 'Convertibles', type: 'item'},
                        'coupes' : {text: 'Coupes', type: 'item'},
                        'hatchbacks' : {text: 'Hatchbacks', type: 'item'},
                        'hybrids' : {text: 'Hybrids', type: 'item'},
                        'suvs' : {text: 'SUVs', type: 'item'},
                        'sedans' : {text: 'Sedans', type: 'item'},
                        'trucks' : {text: 'Trucks', type: 'item'}
                    }
                }

                tree_data['rentals']['additionalParameters'] = {
                    'children' : {
                        'apartments-rentals' : {text: 'Apartments', type: 'item'},
                        'office-space-rentals' : {text: 'Office Space', type: 'item'},
                        'vacation-rentals' : {text: 'Vacation Rentals', type: 'item'}
                    }
                }
                tree_data['real-estate']['additionalParameters'] = {
                    'children' : {
                        'apartments' : {text: 'Apartments', type: 'item'},
                        'villas' : {text: 'Villas', type: 'item'},
                        'plots' : {text: 'Plots', type: 'item'}
                    }
                }
                tree_data['pets']['additionalParameters'] = {
                    'children' : {
                        'cats' : {text: 'Cats', type: 'item'},
                        'dogs' : {text: 'Dogs', type: 'item'},
                        'horses' : {text: 'Horses', type: 'item'},
                        'reptiles' : {text: 'Reptiles', type: 'item'}
                    }
                }
                var datase = {};

                var dataSource1 = function(options, callback){
                    var $data = null;
                    var items = {};

                    $.ajax({
                        url: '{{ route("ajaxorganisation") }}',
                        dataType: "json",
                        async: false,
                        success: function(response){
                            datase = response.original
                            datase.forEach(function(item, index){
                                $.extend(items, item);
                            });
                        }
                    });

                    if(!("text" in options) && !("type" in options)){
                        $data = items;
                        callback({ data: $data });
                        return;
                    }
                    else if("type" in options && options.type == "folder") {
                        if("additionalParameters" in options && "children" in options.additionalParameters)
                            $data = options.additionalParameters.children || {};
                        else $data = {}
                    }

                    if($data != null)
                        setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);

                }


                return {'dataSource1': dataSource1}
            }

        });
    </script>

@endsection
