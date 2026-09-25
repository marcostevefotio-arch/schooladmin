<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ ($data['by']=='all')? "Liste des etudiants" : "Liste des etudiants par ".$data['by'] }}</title>
    <style>
        @page {
            margin: 5px 5px;
        }
        .page-break {
            page-break-after: always;
        }

        h4{
            padding: 0px;
            margin: 0px;
        }

        h6{
            margin: 2px;
            padding: 2px;
        }

        h6 span{
            font-size: 14px;
            color: #ffaa04;
        }

        #body td{
            font-size: 12px;
            text-align:center;
        }

        .tr-title{
            padding: 10px;
            background: ##e1e3e1;
            text-align: center;
            color: #000000;
        }

        .td-result{
            background: rgb(254, 255, 248);
            text-align: center;
        }

        input[type=checkbox] { display: inline; }
        input[type=checkbox]:before { font-family: DejaVu Sans; }
        #watermark {
            position: fixed;
            z-index:  -1000;
            opacity: 0.2;
            left: 14%;
        }

        #body td, #body th{
            font-size: 12px;
            text-align: center;
            height: 30px;
            font-weight: bold;
            text-transform: uppercase;
        }

        #entete td, #entete th{
            font-size: 14px;
            text-align: center;
        }

        tbody td{
            font-size: 12px !important;
        }


    </style>
</head>
<body>
{{--<div id="watermark">--}}
    {{--<img src="{{ asset("") }}assets/images/logo/issat.png" height="100%" width="100%" />--}}
{{--</div>--}}
<header>
    @include("pdf.entete-pv")
</header>
<hr style="border:1px dashed #999999">
<main class="">
    <h2 style="text-align: center;">{{ ($data['by']=='all')? "Liste des etudiants" : "Liste des etudiants par ".$data['by'] }}</h2>

    @if($data['by']=="all")
        <table class="table table-bordered" width="100%" border="box" rules="all">

            <thead class="tr-title">
                <th>N°</th>
                <th>Matricule</th>
                <th>Nom(s) et Prénom</th>
                <th>Sexe</th>
                <th>Spécialité</th>
                <th>Email</th>
                <th>Téléphone</th>
            </thead>
            <tbody>
            @foreach($data['data1'] as $i=>$et)
                @foreach($et->dossier as $dossier)
                    @foreach($dossier->inscriptions as $insc)
                        @if($data["annee"]->id==$insc->anneeacademique_id)
                            <tr class="td-result">
                                <td>{{ $data['count']++ }}</td>
                                <td>{{ $dossier->matriculeDossier }}</td>
                                <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                                <td>{{ $et->sexe }}</td>
                                <td>
                                    @foreach($insc->choice as $ch)
                                        @if($ch->etat == 1)
                                            {{ $ch->specialite->libelleSpecialite }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $et->email }}</td>
                                <td>{{ $et->phonenumber }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
            </tbody>

        </table>
    @endif

    @if($data['by']=="cycle")
        <table class="table table-bordered" width="100%" border="box" rules="all">
            @foreach($data['data3'] as $c)
                @if(count($c->dossier)>0 )
                <tr class="tr-title">
                    <th colspan="7">Cycle {{ $c->titreCycle }}</th>
                </tr>
                <tr class="tr-title">
                    <th>N°</th>
                    <th>Matricule</th>
                    <th>Nom(s) et Prénom</th>
                    <th>Sexe</th>
                    <th>Spécialité</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                </tr>
                @foreach($c->dossier as $i=>$d)
                    @foreach($d->inscriptions as $inscription)
                        @if($data["annee"]->id==$inscription->anneeacademique_id)
                            <tr class="td-result">
                                <td>{{ ++$i }}</td>
                                <td>{{ $d->matriculeDossier }}</td>
                                <td>{{ $d->etudiant->lastname }} {{ $d->etudiant->firstname }}</td>
                                <td>{{ $d->etudiant->sexe }}</td>
                                <td>
                                    @foreach($inscription->choice as $ch)
                                        @if($ch->etat == 1)
                                            {{ $ch->specialite->libelleSpecialite }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $d->etudiant->email }}</td>
                                <td>{{ $d->etudiant->phonenumber }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
                @endif
            @endforeach
        </table>
    @endif

    @if($data['by']=="filiere")
        <table class="table table-bordered" width="100%" border="box" rules="all">
            @foreach($data['data2'] as $f)
                <tr class="tr-title">
                    <th colspan="7">Filière {{ $f->libelleFiliere }}</th>
                </tr>
                <tr class="tr-title">
                    <th>N°</th>
                    <th>Matricule</th>
                    <th>Nom(s) et Prénom</th>
                    <th>Sexe</th>
                    <th>Spécialité</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                </tr>
                @foreach($f->specialites as $s)
                    @foreach($s->choice as $i=>$c)
                        @if($c->etat == 1 && $data["annee"]->id==$c->inscription->anneeacademique_id)
                            <tr class="td-result">
                                <td>{{ ++$i }}</td>
                                <td>{{ $c->inscription->dossier->matriculeDossier }}</td>
                                <td>{{ $c->inscription->dossier->etudiant->lastname }} {{ $c->inscription->dossier->etudiant->firstname }}</td>
                                <td>{{ $c->inscription->dossier->etudiant->sexe }}</td>
                                <td>{{ $s->libelleSpecialite }}</td>
                                <td>{{ $c->inscription->dossier->etudiant->email }}</td>
                                <td>{{ $c->inscription->dossier->etudiant->phonenumber }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </table>
    @endif

    @if($data['by']=="specialite")
        <table class="table table-bordered" width="100%" border="box" rules="all">
            @foreach($data['data2'] as $f)
                @foreach($f->specialites as $s)
                    @if(count($s->choice)>0)
                        <tr class="tr-title">
                            <th colspan="7">Specialite {{ $s->libelleSpecialite }}</th>
                        </tr>
                        <tr class="tr-title">
                            <th>N°</th>
                            <th>Matricule</th>
                            <th>Nom(s) et Prénom</th>
                            <th>Sexe</th>
                            <th>Spécialité</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                        </tr>
                    @endif
                    @foreach($s->choice as $i=>$c)
                        @if($c->etat == 1 && $data["annee"]->id==$c->inscription->anneeacademique_id)
                            <tr class="td-result">
                                <td>{{ ++$i }}</td>
                                <td>{{ $c->inscription->dossier->matriculeDossier }}</td>
                                <td>{{ $c->inscription->dossier->etudiant->lastname }} {{ $c->inscription->dossier->etudiant->firstname }}</td>
                                <td>{{ $c->inscription->dossier->etudiant->sexe }}</td>
                                <td>{{ $s->libelleSpecialite }}</td>
                                <td>{{ $c->inscription->dossier->etudiant->email }}</td>
                                <td>{{ $c->inscription->dossier->etudiant->phonenumber }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </table>
    @endif


    @if($data['by']=="sexe")
        <table class="table table-bordered" width="100%" border="box" rules="all">
            @foreach(["FEMININ","MASCULIN"] as $key=>$d3)
                <tr class="tr-title">
                    <th colspan="7">Sexe {{ $d3 }}</th>
                </tr>
                <tr class="tr-title">
                    <th>N°</th>
                    <th>Matricule</th>
                    <th>Nom(s) et Prénom</th>
                    <th>Sexe</th>
                    <th>Spécialité</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                </tr>
                @foreach($data['data2'] as $f)
                    @foreach($f->specialites as $s)
                        @foreach($s->choice as $i=>$c)
                            @if($c->etat == 1 && $c->inscription->dossier->etudiant->sexe == $d3  && $data["annee"]->id==$c->inscription->anneeacademique_id)
                                <tr class="td-result">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $c->inscription->dossier->matriculeDossier }}</td>
                                    <td>{{ $c->inscription->dossier->etudiant->lastname }} {{ $c->inscription->dossier->etudiant->firstname }}</td>
                                    <td>{{ $c->inscription->dossier->etudiant->sexe }}</td>
                                    <td>{{ $s->libelleSpecialite }}</td>
                                    <td>{{ $c->inscription->dossier->etudiant->email }}</td>
                                    <td>{{ $c->inscription->dossier->etudiant->phonenumber }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </table>
    @endif


    <table class="table" border="box" rules="none" width="100%">
        <tr class="text-left">
            <td colspan="7" class="text-right " style="padding:50px; border: 1px solid #ffffff"><span style="float:right ; border-bottom: 1px dotted #000000">Date et visa du responssable</span></td>
        </tr>
    </table>

</main>

</body>
</html>