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
                    <a href="{{ route("newCours", ["slug"=>"$specialite->id"]) }}" class="btn btn-info btn-sm"><i class="fa fa-table"></i>&nbsp;Nouveau Cours</a>
                    <a href="{{ route("matiere") }}" class="btn btn-info btn-sm"><i class="fa fa-table"></i>&nbsp;Matieres</a>
                    <a href="{{ route("enseignant") }}" class="btn btn-warning btn-sm"><i class="fa fa-tablet"></i>&nbsp;Enseignants</a>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-sm-9">
                    <div class="space"></div>

                    <div id="calendar"></div>
                </div>

                <div class="col-sm-3">
                    <div class="widget-box transparent">
                        <div class="widget-header">
                            <h4>Liste de cours</h4>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <div id="external-events">
                                    @foreach($specialite->ues as $ue)
                                        <div class="row p-0 m-0">
                                            <div class="col-xs-12  label label-lg label-inverse arrowed-in arrowed-right p-2 m-0">
                                                <p>({{ $ue->codeUE }}) {{ $ue->libelleUE }}</p>
                                            </div>
                                        </div>
                                        @foreach($ue->matiere as $m)
                                            <div class="row">
                                                <div class="col-xs-11 label label-lg label-warning arrowed-in arrowed-right">
                                                    <b>{{ $m->libelleMatiere }} ({{ count($m->cours) }})</b>
                                                </div>
                                            </div>
                                            @foreach($m->cours as $c)
                                                <div class="external-event label-info" data-class="label-grey">
                                                    <i class="ace-icon fa fa-arrows"></i>
                                                    {{ !empty($c->intituleCours)? $c->intituleCours : $m->libelleMatiere }}
                                                </div>
                                            @endforeach
                                            <div class="space"></div>
                                        @endforeach
                                        <div class="space"></div>
                                    @endforeach
                                    <hr>
                                    <label>
                                        <input type="checkbox" class="ace ace-checkbox" id="drop-remove" checked />
                                        <span class="lbl"> Remove after drop</span>
                                    </label>
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


@section("style")
    <link rel="stylesheet" href="{{ asset("") }}assets/css/jquery-ui.custom.min.css" />
    <link rel="stylesheet" href="{{ asset("") }}assets/css/fullcalendar.min.css" />
    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9] -->
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
    <![endif]-->
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace-rtl.min.css" />

    <link rel="stylesheet" href="{{ asset("") }}assets/css/ace-ie.min.css" />

    <script src="{{ asset("") }}assets/js/ace-extra.min.js"></script>
@endsection

@section("script")
    <!-- page specific plugin scripts -->
    <script src="{{ asset("") }}assets/js/jquery-ui.custom.min.js"></script>
    <script src="{{ asset("") }}assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="{{ asset("") }}assets/js/moment.min.js"></script>
    <script src="{{ asset("") }}assets/js/fullcalendar.min.js"></script>
    <script src="{{ asset("") }}assets/js/bootbox.js"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {

            /* initialize the calendar
            -----------------------------------------------------------------*/

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var calendar = $('#calendar').fullCalendar({
                //isRTL: true,
                //firstDay: 1,// >> change first day of week
//                initialView: 'listWeek',
                defaultView: "agendaWeek",
                minTime: "07:00:00",
                maxTime: "22:00:00",
                buttonHtml: {
                    prev: '<i class="ace-icon fa fa-chevron-left"></i>',
                    next: '<i class="ace-icon fa fa-chevron-right"></i>'
                },

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaWeek,agendaDay,month,basicWeek'
                },
                events: [
                @foreach($specialite->ues as $ue)
                    @foreach($ue->matiere as $m)
                        @foreach($m->cours as $c)
                            {
                                name: '{{ $c->id }}',
                                title: '{{ $m->libelleMatiere }} \n\n({{ $c->enseignant->firstname }} {{ $c->enseignant->lastname }})\n\n{{ $c->enseignant->lastname }}',
                                start: new Date(parseInt("{{ date("Y", strtotime($c->debutCours)) }}"), parseInt("{{ date("m", strtotime($c->debutCours)) }}")-1, parseInt("{{ date("d", strtotime($c->debutCours)) }}"), parseInt("{{ date("H", strtotime($c->debutCours)) }}"), 0),
                                end: new Date(parseInt("{{ date("Y", strtotime($c->debutCours)) }}"), parseInt("{{ date("m", strtotime($c->debutCours)) }}")-1, parseInt("{{ date("d", strtotime($c->debutCours)) }}"), parseInt("{{ date("H", strtotime($c->debutCours)) }}")+parseInt("{{ $c->dureeCours }}"), 0),
                                allDay: false,
                                edit: "{{ route("coursEdit", ["slug"=>$ue->specialite_id, "cours"=>$c->id]) }}",
                                delete: "{{ route("coursDelete", ["slug"=>$c->id]) }}",
                                className: 'label-info',
                            },
                        @endforeach
                    @endforeach
                @endforeach

                ]
                ,


                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    var $extraEventClass = $(this).attr('data-class');


                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = false;
                    if($extraEventClass) copiedEventObject['className'] = [$extraEventClass];

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }

                }
                ,
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {

                    bootbox.prompt("New Event Title:", function(title) {
                        if (title !== null) {
                            calendar.fullCalendar('renderEvent',
                                {
                                    title: title,
                                    start: start,
                                    end: end,
                                    allDay: allDay,
                                    className: 'label-info'
                                },
                                true // make the event "stick"
                            );
                        }
                    });


                    calendar.fullCalendar('unselect');
                }
                ,
                {{--eventClick: function(calEvent, jsEvent, view) {--}}
                    {{--console.log(calEvent);--}}
                    {{--window.location.href = "{!! \Illuminate\Support\Facades\URL::to("/cours-edit") !!}/"+calEvent.name--}}
                {{--},--}}
                eventClick: function(calEvent, jsEvent, view) {
                    console.log(calEvent);
                    //display a modal
                    var modal =
                    '<div class="modal fade">\
                      <div class="modal-dialog">\
                       <div class="modal-content">\
                         <div class="modal-body">\
                           <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px;">&times;</button>\
                            <table class="table table-bordered table-responssive">\
                                <tr>\
                                    <td colspan="2">'+calEvent.title+'</td>\
                                </tr>\
                                <tr>\
                                    <td>'+calEvent.source.origArray[0].start.toLocaleTimeString()+'</td>\
                                    <td>'+calEvent.source.origArray[0].end.toLocaleTimeString()+'</td>\
                                </tr>\
                            </table>\
                         </div>\
                         <div class="modal-footer">\
                            <a class="btn btn-sm btn-warning" href="'+calEvent.edit+'" data-action="edit"><i class="ace-icon fa fa-edit"></i> Edit Event</a>\
                            <a class="btn btn-sm btn-danger" href="'+calEvent.delete+'"><i class="ace-icon fa fa-trash-o"></i> Delete Event</a>\
                            <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
                         </div>\
                      </div>\
                     </div>\
                    </div>';


                    var modal = $(modal).appendTo('body');
                    modal.find('form').on('submit', function(ev){
                        ev.preventDefault();

                        calEvent.title = $(this).find("input[type=text]").val();
                        calendar.fullCalendar('updateEvent', calEvent);
                        modal.modal("hide");
                    });
                    modal.find('button[data-action=delete]').on('click', function() {
                        calendar.fullCalendar('removeEvents' , function(ev){
                            return (ev._id == calEvent._id);
                        })
                        modal.modal("hide");
                    });

                    modal.modal('show').on('hidden', function(){
                        modal.remove();
                    });

                }

            });


        })
    </script>
@endsection
