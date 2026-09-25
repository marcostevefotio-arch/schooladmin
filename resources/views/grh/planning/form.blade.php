@extends('layouts.layout')

@section('breadcrum')
    <li><i class="ace-icon fa fa-home home-icon"></i><a href="{{ route("home") }}">Home</a></li>
    <li><i class="ace-icon fa fa-hand-o-up  home-icon"></i><a href="{{ route("user") }}">Utilisateurs</a></li>
    <li class="active">Creation</li>
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

        <div class="page-header">
            <h1>
                Gestion des chambres/espaces
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Création d'un espace
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-6">
                <!-- PAGE CONTENT BEGINS -->
                <form class="form-horizontal" role="form" method="post" action="#">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Catégorie *</label>

                        <div class="col-sm-9">
                            <select class="form-control" id="form-field-select-1" name="categorie" required>
                                <option value=""></option>
                                @foreach($data as $c)
                                    <option value="{{ $c->id }}">{{ $p->titre_categorie }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nom *</label>

                        <div class="col-sm-9">
                            <input type="email" id="form-field-1-1" placeholder="Nom de l'espace" name="nom" class="form-control" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Montant *</label>

                        <div class="col-sm-9">
                            <input type="number" id="form-field-1-1" placeholder="Montant de l'espace" name="montant" class="form-control" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Description</label>

                        <div class="col-sm-9">
                            <textarea id="form-field-1-1" name="description" class="form-control" ></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Localisation</label>

                        <div class="col-sm-9">
                            <select multiple="" class="chosen-select form-control" id="form-field-select-4" data-placeholder="Choisir des localisation">
                                <option value=""></option>
                            </select>

                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-info" type="submit">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Enregistrer
                            </button>

                            &nbsp; &nbsp; &nbsp;
                            <a class="btn" href="{{ route("user") }}">
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                Annuler
                            </a>
                        </div>
                    </div>

                    <div class="hr hr-24"></div>
                </form>

                <div class="hr hr-18 dotted hr-double"></div>

            </div>
            <div class="col-xs-6">
                <div>
                    <form action="#" class="dropzone well" id="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" multiple="" />
                        </div>
                    </form>
                </div>

                <div id="preview-template" class="hide">
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image">
                            <img data-dz-thumbnail="" />
                        </div>

                        <div class="dz-details">
                            <div class="dz-size">
                                <span data-dz-size=""></span>
                            </div>

                            <div class="dz-filename">
                                <span data-dz-name=""></span>
                            </div>
                        </div>

                        <div class="dz-progress">
                            <span class="dz-upload" data-dz-uploadprogress=""></span>
                        </div>

                        <div class="dz-error-message">
                            <span data-dz-errormessage=""></span>
                        </div>

                        <div class="dz-success-mark">
                            <span class="fa-stack fa-lg bigger-150">
                                <i class="fa fa-circle fa-stack-2x white"></i>

                                <i class="fa fa-check fa-stack-1x fa-inverse green"></i>
                            </span>
                        </div>

                        <div class="dz-error-mark">
                            <span class="fa-stack fa-lg bigger-150">
                                <i class="fa fa-circle fa-stack-2x white"></i>

                                <i class="fa fa-remove fa-stack-1x fa-inverse red"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->

@endsection

@section("style")
    <link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
    <link rel="stylesheet" href="assets/css/chosen.min.css" />
    <link rel="stylesheet" href="assets/css/dropzone.min.css" />
@endsection

@section("script")
    <script src="assets/js/jquery-ui.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="assets/js/chosen.jquery.min.js"></script>
    <script src="assets/js/bootstrap-tag.min.js"></script>
    <script src="assets/js/dropzone.min.js"></script>

    <!-- ace scripts -->

    <script type="text/javascript">
        jQuery(function($) {
            $('#id-disable-check').on('click', function() {
                var inp = $('#form-input-readonly').get(0);
                if(inp.hasAttribute('disabled')) {
                    inp.setAttribute('readonly' , 'true');
                    inp.removeAttribute('disabled');
                    inp.value="This text field is readonly!";
                }
                else {
                    inp.setAttribute('disabled' , 'disabled');
                    inp.removeAttribute('readonly');
                    inp.value="This text field is disabled!";
                }
            });


            if(!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect:true});
                //resize the chosen on window resize

                $(window)
                    .off('resize.chosen')
                    .on('resize.chosen', function() {
                        $('.chosen-select').each(function() {
                            var $this = $(this);
                            $this.next().css({'width': $this.parent().width()});
                        })
                    }).trigger('resize.chosen');
                //resize chosen on sidebar collapse/expand
                $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                    if(event_name != 'sidebar_collapsed') return;
                    $('.chosen-select').each(function() {
                        var $this = $(this);
                        $this.next().css({'width': $this.parent().width()});
                    })
                });


                $('#chosen-multiple-style .btn').on('click', function(e){
                    var target = $(this).find('input[type=radio]');
                    var which = parseInt(target.val());
                    if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
                    else $('#form-field-select-4').removeClass('tag-input-style');
                });
            }



            $(document).one('ajaxloadstart.page', function(e) {
                autosize.destroy('textarea[class*=autosize]')

                $('.limiterBox,.autosizejs').remove();
                $('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
            });

        });
    </script>
@endsection
