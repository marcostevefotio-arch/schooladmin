<?php
$modules = \App\Models\Menu::whereNull("menu_id")->where("is_link",'=',true)->get();
?>

<div id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try{ace.settings.loadState('sidebar')}catch(e){}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <a href="{{ route("inscription-etat") }}" class="btn btn-success" title="etat des inscriptions">
                <i class="ace-icon fa fa-signal"></i>
            </a>

            <a href="{{ route("inscriptions-list") }}" class="btn btn-info" title="Liste des inscriptions">
                <i class="ace-icon fa fa-pencil"></i>
            </a>

            <a href="{{ route("etudiant-effectifs") }}" class="btn btn-warning" title="Effectif des etudiants">
                <i class="ace-icon fa fa-users"></i>
            </a>

            <a href="{{ route("organisation-parametre") }}" class="btn btn-danger" title="Parametres d'application">
                <i class="ace-icon fa fa-cogs"></i>
            </a>
        </div>
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <h4><span>Année active</span>: {{ !empty($anneeActive)? $anneeActive->numeroAnnee."-".(intval($anneeActive->numeroAnnee)+1) : "Aucune" }}</h4>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        {{--@if(isset(auth()->user()->etudiant))--}}
            {{--@php--}}
                {{--$menus = array();--}}
            {{--@endphp--}}
            {{--@foreach(auth()->user()->etudiant->groupe->permission as $p)--}}
                {{--@if(!in_array($p->menu_id, $menus))--}}
                    {{--@php--}}
                        {{--array_push($menus, $p->menu_id);--}}
                        {{--$m = $p->menu;--}}
                    {{--@endphp--}}
                    {{--@if($m->menu_id=== null && count($m->menu_enfants)>0)--}}
                        {{--<li class="">--}}
                            {{--<a href="" class="dropdown-toggle">--}}
                            {{--<i class="menu-icon fa {{ $m->icon_menu }}"></i>--}}
                            {{--<span class="menu-text">{{ $m->libelle_menu }}</span>--}}
                            {{--<b class="arrow fa fa-angle-down"></b>--}}
                            {{--</a>--}}

                            {{--<b class="arrow"></b>--}}
                            {{--<ul class="submenu">--}}
                            {{--@foreach($m->menu_enfants as $sm)--}}
                                {{--<li class="">--}}
                                {{--<a href="{{ Route::has($sm->code_menu)? route($sm->code_menu) :  "" }}">--}}
                                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                                {{--{{ $sm->libelle_menu }}--}}
                                {{--</a>--}}
                                {{--<b class="arrow"></b>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    {{--@elseif($m->menu_id=== null)--}}
                        {{--<li class="">--}}
                            {{--<a href="{{ Route::has($m->code_menu)? route($m->code_menu) :  "" }}">--}}
                            {{--<i class="menu-icon fa {{ $m->icon_menu }}"></i>--}}
                            {{--{{ $m->libelle_menu }}--}}
                            {{--</a>--}}
                            {{--<b class="arrow"></b>--}}
                        {{--</li>--}}
                    {{--@endif--}}

                {{--@endif--}}
            {{--@endforeach--}}
        {{--@elseif(auth()->user()->personnel)--}}
            {{--@php--}}
                {{--$menus = array();--}}
            {{--@endphp--}}
            {{--@foreach(auth()->user()->personnel->groupe->permission as $p)--}}
                {{--@if(!in_array($p->menu_id, $menus) && $p->menu->menu_id==null)--}}
                    {{--@php--}}
                        {{--array_push($menus, $p->menu_id);--}}
                        {{--$m = $p->menu;--}}
                    {{--@endphp--}}

                    {{--<li class="{{ $m->code_menu==$active? "active" : "" }}" >--}}
                        {{--<a href="{{ Route::has($m->code_menu)? route($m->code_menu) :  "" }}">--}}
                            {{--<i class="menu-icon fa {{ $m->icon_menu }} "></i>--}}
                            {{--{{ $m->libelle_menu }}--}}
                        {{--</a>--}}
                        {{--<b class="arrow"></b>--}}
                    {{--</li>--}}

                {{--@endif--}}
            {{--@endforeach--}}
        {{--@endif--}}


        @foreach($menu as $m)
            @php
                $menus = array();
            @endphp
            @foreach(auth()->user()->personnel->groupe->permission as $p)
                @if(!in_array($m, $menus) && $p->menu_id==$m->id)
                    @php
                        array_push($menus, $m);
                    @endphp
                    <li class="{{ $m->code_menu==$active? "active" : "" }}" >
                        <a href="{{ Route::has($m->code_menu)? route($m->code_menu) :  "" }}">
                        <i class="menu-icon fa {{ $m->icon_menu }} "></i>
                        {{ $m->libelle_menu }}
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endif
            @endforeach
        @endforeach

    </ul><!-- /.nav-list -->

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>