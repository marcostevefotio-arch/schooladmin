@extends('layouts.layout')

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon fa fa-hand-o-up  home-icon"></i><a href="{{ route("myspace") }}">Mon espace</a></li>
    <li><a href="{{ route("tevaluation", ["slug"=>auth()->user()->id]) }}">Evaluation</a></li>
    <li class="active">Nouvelle évaluation</li>
@endsection

@section('title')
    My Space
@endsection

@section('content')
    <div class="page-content">
        <div class="ace-settings-container" id="ace-settings-container">
            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                <i class="ace-icon fa fa-cog bigger-130"></i>
            </div>

            <div class="ace-settings-box clearfix" id="ace-settings-box">
                <div class="pull-left width-50">
                    <div class="ace-settings-item">
                        <div class="pull-left">
                            <select id="skin-colorpicker" class="hide">
                                <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                            </select>
                        </div>
                        <span>&nbsp; Choose Skin</span>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
                        <label class="lbl" for="ace-settings-add-container">
                            Inside
                            <b>.container</b>
                        </label>
                    </div>
                </div><!-- /.pull-left -->

                <div class="pull-left width-50">
                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                    </div>

                    <div class="ace-settings-item">
                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                    </div>
                </div><!-- /.pull-left -->
            </div><!-- /.ace-settings-box -->
        </div><!-- /.ace-settings-container -->

        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="header smaller lighter blue">
                            Mon espace de travail
                            <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                Evaluation
                                <small>
                                    <i class="ace-icon fa fa-angle-double-right"></i>
                                    Création
                                </small>
                            </small>
                        </h3>

                        <div class="clearfix">
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="col-lg-12 col-xs-12">
                            <div id="clockContaine" onload="showTime()">
                                <div id="MyClockDisplay" class="clock text-center">
                                    <div id="hours" class="lines"></div>
                                    <div id="seconds" class="lines"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-xs-12">
                            <div class="table-header">
                               Nouvelle évaluation
                            </div>
                        </div>



                        <div class="col-lg-6 col-xs-12">
                            <div class="panel">
                                <div class="panel-body">
                                    <form action="{{ route("storeEvaluation") }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="">Specialité *</label>
                                            <select name="" id="" class="form-control" required>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Matiere *</label>
                                            <select name="" id="" class="form-control" required>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Type d'evaluation *</label>
                                            <select name="typeevaluation" id="typeevaluation" class="form-control" required>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Date évaluation *</label>
                                            <input type="date" name="dateevaluation" id="dateevaluation" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Durée de l'evaluation *</label>
                                            <input type="number" name="duree" id="duree" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Epreuve</label>
                                            <input type="file" name="epreuve" id="epreuve" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary"><i class="fa fa-save">&nbsp;</i>Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
@endsection

@section("style")

    <style type="text/css">
        #clockContaine{
            height: 100px;
            padding-top: 0px;
            margin-top:0px;
            width: 100%;
        }
        #MyClockDisplay{
            float: right;
            width: 150px;
            background: linear-gradient(45deg, rgba(218,94,0,0.5),rgba(255,218,58, 1));
        }

        .clock {
            top: 50%;
            left: 50%;
            color: #111111;
            font-weight: bold;
            font-size: 25px;
            font-family: Orbitron;
            letter-spacing: 7px;
        }
        .lines{
            width: 100%;
            float: right;
        }
        #seconds{
            font-size: 12px;
        }
    </style>
@endsection

@section("script")

    <script src="assets/js/jquery-ui.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="assets/js/markdown.min.js"></script>
    <script src="assets/js/bootstrap-markdown.min.js"></script>
    <script src="assets/js/jquery.hotkeys.index.min.js"></script>
    <script src="assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="assets/js/bootbox.js"></script>

    <script type="text/javascript">
        jQuery(function($){

            $('textarea[data-provide="markdown"]').each(function(){
                var $this = $(this);

                if ($this.data('markdown')) {
                    $this.data('markdown').showEditor();
                }
                else $this.markdown()

                $this.parent().find('.btn').addClass('btn-white');
            })



            function showErrorAlert (reason, detail) {
                var msg='';
                if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
                else {
                    //console.log("error uploading file", reason, detail);
                }
                $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
            }

            //$('#editor1').ace_wysiwyg();//this will create the default editor will all buttons

            //but we want to change a few buttons colors for the third style
            $('#editor1').ace_wysiwyg({
                toolbar:
                    [
                        'font',
                        null,
                        'fontSize',
                        null,
                        {name:'bold', className:'btn-info'},
                        {name:'italic', className:'btn-info'},
                        {name:'strikethrough', className:'btn-info'},
                        {name:'underline', className:'btn-info'},
                        null,
                        {name:'insertunorderedlist', className:'btn-success'},
                        {name:'insertorderedlist', className:'btn-success'},
                        {name:'outdent', className:'btn-purple'},
                        {name:'indent', className:'btn-purple'},
                        null,
                        {name:'justifyleft', className:'btn-primary'},
                        {name:'justifycenter', className:'btn-primary'},
                        {name:'justifyright', className:'btn-primary'},
                        {name:'justifyfull', className:'btn-inverse'},
                        null,
                        {name:'createLink', className:'btn-pink'},
                        {name:'unlink', className:'btn-pink'},
                        null,
                        {name:'insertImage', className:'btn-success'},
                        null,
                        'foreColor',
                        null,
                        {name:'undo', className:'btn-grey'},
                        {name:'redo', className:'btn-grey'}
                    ],
                'wysiwyg': {
                    fileUploadError: showErrorAlert
                }
            }).prev().addClass('wysiwyg-style2');


            /**
             //make the editor have all the available height
             $(window).on('resize.editor', function() {
		var offset = $('#editor1').parent().offset();
		var winHeight =  $(this).height();

		$('#editor1').css({'height':winHeight - offset.top - 10, 'max-height': 'none'});
	}).triggerHandler('resize.editor');
             */


            $('#editor2').css({'height':'200px'}).ace_wysiwyg({
                toolbar_place: function(toolbar) {
                    return $(this).closest('.widget-box')
                        .find('.widget-header').prepend(toolbar)
                        .find('.wysiwyg-toolbar').addClass('inline');
                },
                toolbar:
                    [
                        'bold',
                        {name:'italic' , title:'Change Title!', icon: 'ace-icon fa fa-leaf'},
                        'strikethrough',
                        null,
                        'insertunorderedlist',
                        'insertorderedlist',
                        null,
                        'justifyleft',
                        'justifycenter',
                        'justifyright'
                    ],
                speech_button: false
            });




            $('[data-toggle="buttons"] .btn').on('click', function(e){
                var target = $(this).find('input[type=radio]');
                var which = parseInt(target.val());
                var toolbar = $('#editor1').prev().get(0);
                if(which >= 1 && which <= 4) {
                    toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g , '');
                    if(which == 1) $(toolbar).addClass('wysiwyg-style1');
                    else if(which == 2) $(toolbar).addClass('wysiwyg-style2');
                    if(which == 4) {
                        $(toolbar).find('.btn-group > .btn').addClass('btn-white btn-round');
                    } else $(toolbar).find('.btn-group > .btn-white').removeClass('btn-white btn-round');
                }
            });




            //RESIZE IMAGE

            //Add Image Resize Functionality to Chrome and Safari
            //webkit browsers don't have image resize functionality when content is editable
            //so let's add something using jQuery UI resizable
            //another option would be opening a dialog for user to enter dimensions.
            if ( typeof jQuery.ui !== 'undefined' && ace.vars['webkit'] ) {

                var lastResizableImg = null;
                function destroyResizable() {
                    if(lastResizableImg == null) return;
                    lastResizableImg.resizable( "destroy" );
                    lastResizableImg.removeData('resizable');
                    lastResizableImg = null;
                }

                var enableImageResize = function() {
                    $('.wysiwyg-editor')
                        .on('mousedown', function(e) {
                            var target = $(e.target);
                            if( e.target instanceof HTMLImageElement ) {
                                if( !target.data('resizable') ) {
                                    target.resizable({
                                        aspectRatio: e.target.width / e.target.height,
                                    });
                                    target.data('resizable', true);

                                    if( lastResizableImg != null ) {
                                        //disable previous resizable image
                                        lastResizableImg.resizable( "destroy" );
                                        lastResizableImg.removeData('resizable');
                                    }
                                    lastResizableImg = target;
                                }
                            }
                        })
                        .on('click', function(e) {
                            if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
                                destroyResizable();
                            }
                        })
                        .on('keydown', function() {
                            destroyResizable();
                        });
                }

                enableImageResize();
            }
        });
    </script>


    <script type="text/javascript">
        function showTime(){
            var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "AM";

            if(h == 0){
                h = 12;
            }

            if(h > 12){
                h = h - 12;
                session = "PM";
            }

            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;

            var hour = h + ":" + m ;
            var second = s + " " + session;
            document.getElementById("hours").innerText = hour;
            document.getElementById("hours").textContent = hour;
            document.getElementById("seconds").innerText = second;
            document.getElementById("seconds").textContent = second;

            setTimeout(showTime, 1000);

        }

        showTime();
    </script>
@endsection
