<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ ($data['by']=='all')? "Liste des etudiants" : "Liste des etudiants par ".$data['by'] }}</title>
</head>
<body>

<style>
    .page-break {
        page-break-after: auto;
    }

    section{
        margin-top: 80px;
    }

    header{
        position: relative;
        height: 80px;
    }
    header img{
        height: 80px;
        display: block;
        /*margin-left: 300px;*/
    }
    header h2{
        font-weight: bold;
        font-family: "Arial Black";
        text-align: center;
        margin-top: -10px;
    }
    header h4{
        font-weight: bold;
        font-family: "Arial Black";
        text-align: center;
        text-transform: uppercase;
    }

    .table{
        border:1px solid #000000;
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .table h3{
        text-align: center;
    }

    .table h4{
        margin-top: 5px;
        margin-bottom: 5px;
        /*border:1px solid #000000;*/
    }

    .tr-title{
        background: #ffda3a;
        text-align: center;
        font-weight: bold;
        font-size: 14px;
    }

    tr{
        height:200px;
    }
    th, td{
        padding-top: 0px;
        padding-bottom: 0px;
        border:1px solid #000000;
    }


</style>

<header>
    <h2><img src="assets/images/logo/issat.png" alt=""></h2>
    <h2 class="text-center text-uppercase" style="font-weight: bold; font-family: Arial">
        {{ ($data['by']=='all')? "Liste des etudiants" : "Liste des etudiants par ".$data['by'] }}
        <div style="width: 200px; height: 5px; background: rgb(88,86,91); margin:5px auto"></div>
    </h2>
</header>


<section class="">
    <table class="table table-bordered">
        @if($data['by']=="all")

            <tr class="tr-title">
                <td>N°</td>
                <td>Matricule</td>
                <td>Nom(s) et Prénom</td>
                <td>Sexe</td>
                <td>Spécialité</td>
                <td>Email</td>
                <td>Téléphone</td>
            </tr>
            @foreach($data['data1'] as $i=>$et)
                <tr>
                    <td>{{ $data['count']++ }}</td>
                    <td>{{ $et->inscriptions[0]->matricule }}</td>
                    <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                    <td>{{ $et->sexe }}</td>
                    <td>
                        @foreach($et->inscriptions[0]->choice as $ch)
                            @if($ch->etat == 1)
                                {{ $ch->specialite->libelleSpecialite }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $et->email }}</td>
                    <td>{{ $et->phonenumber }}</td>
                </tr>
            @endforeach
        @endif

        @if($data['by']=="cycle")
            @foreach($data['data3'] as $key=>$d3)
                <tr class="tr-title">
                    <td colspan="7"><h3 class="text-uppercase">Cycle {{ $key }}</h3></td>
                </tr>
                <tr class="tr-title">
                    <td>N°</td>
                    <td>Matricule</td>
                    <td>Nom(s) et Prénom</td>
                    <td>Sexe</td>
                    <td>Spécialité</td>
                    <td>Email</td>
                    <td>Téléphone</td>
                </tr>
                @foreach($d3 as $i=>$d)
                    @if($d->choice[0]->etat==1 || $d->choice[1]->etat==1 || $d->choice[2]->etat==1)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $d->matricule }}</td>
                        <td>{{ $d->etudiant->lastname }} {{ $d->etudiant->firstname }}</td>
                        <td>{{ $d->etudiant->sexe }}</td>
                        <td>
                            {{
                            ($d->choice[0]->etat==1)?
                                $d->choice[0]->specialite->libelleSpecialite :
                                    (($d->choice[1]->etat==1)?
                                        $d->choice[1]->specialite->libelleSpecialite :
                                        (($d->choice[2]->etat==1)? $d->choice[2]->specialite->libelleSpecialite : "inconnu"))
                                       }}
                        </td>
                        <td>{{ $d->etudiant->email }}</td>
                        <td>{{ $d->etudiant->phonenumber }}</td>
                    </tr>
                    @endif
                @endforeach

            @endforeach
        @endif

        @if($data['by']=="filiere")
            @foreach($data['data2'] as $key=>$d3)
                <tr class="tr-title">
                    <td colspan="7"><h3 class="text-uppercase">Filière: {{ $d3->libelleFiliere }}</h3></td>
                </tr>
                <tr class="tr-title">
                    <td>N°</td>
                    <td>Matricule</td>
                    <td>Nom(s) et Prénom</td>
                    <td>Sexe</td>
                    <td>Spécialité</td>
                    <td>Email</td>
                    <td>Téléphone</td>
                </tr>
                @foreach($d3->specialites as $sp)
                    @foreach($sp->choice as $ch)
                        @if($ch->etat == 1)
                            @foreach($data['data1'] as $i=>$et)
                                @if($et->inscriptions[0]->id == $ch->inscription_id)
                                    <tr>
                                    <td>{{ $data['count']++ }}</td>
                                    <td>{{ $et->inscriptions[0]->matricule }}</td>
                                    <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                                    <td>{{ $et->sexe }}</td>
                                    <td>{{ $sp->libelleSpecialite }}</td>
                                    <td>{{ $et->email }}</td>
                                    <td>{{ $et->phonenumber }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endforeach

            @endforeach
        @endif

        @if($data['by']=="sexe")
            @foreach(["FEMININ","MASCULIN"] as $key=>$d3)
                <tr class="tr-title">
                    <td colspan="7"><h3 class="text-uppercase">Sexe: {{ $d3 }}</h3></td>
                </tr>
                <tr class="tr-title">
                    <td>N°</td>
                    <td>Matricule</td>
                    <td>Nom(s) et Prénom</td>
                    <td>Sexe</td>
                    <td>Spécialité</td>
                    <td>Email</td>
                    <td>Téléphone</td>
                </tr>
                @foreach($data['data1'] as $i=>$et)
                    @if($d3===$et->sexe)
                        <tr>
                            <td>{{ $data['count']++ }}</td>
                            <td>{{ $et->inscriptions[0]->matricule }}</td>
                            <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                            <td>{{ $et->sexe }}</td>
                            <td>
                                @foreach($et->inscriptions[0]->choice as $ch)
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
        @endif

        @if($data['by']=="nationalite")
            @foreach($data['data4'] as $key=>$d3)
                <tr class="tr-title">
                    <td colspan="7"><h3 class="text-uppercase">NATIONALITE: {{ $d3->nationality }}</h3></td>
                </tr>
                <tr class="tr-title">
                    <td>N°</td>
                    <td>Matricule</td>
                    <td>Nom(s) et Prénom</td>
                    <td>Sexe</td>
                    <td>Spécialité</td>
                    <td>Email</td>
                    <td>Téléphone</td>
                </tr>
                @foreach($data['data1'] as $i=>$et)
                    @if($d3->nationality===$et->nationality)
                        <tr>
                            <td>{{ $data['count']++ }}</td>
                            <td>{{ $et->inscriptions[0]->matricule }}</td>
                            <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                            <td>{{ $et->sexe }}</td>
                            <td>
                                @foreach($et->inscriptions[0]->choice as $ch)
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
        @endif


        @if($data['by']=="langue")
            @foreach($data['data5'] as $key=>$d3)
                <tr class="tr-title">
                    <td colspan="7"><h3 class="text-uppercase">LANGUE: {{ $d3->language }}</h3></td>
                </tr>
                <tr class="tr-title">
                    <td>N°</td>
                    <td>Matricule</td>
                    <td>Nom(s) et Prénom</td>
                    <td>Sexe</td>
                    <td>Spécialité</td>
                    <td>Email</td>
                    <td>Téléphone</td>
                </tr>
                @foreach($data['data1'] as $i=>$et)
                    @if($d3->language===$et->language)
                        <tr>
                            <td>{{ $data['count']++ }}</td>
                            <td>{{ $et->inscriptions[0]->matricule }}</td>
                            <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                            <td>{{ $et->sexe }}</td>
                            <td>
                                @foreach($et->inscriptions[0]->choice as $ch)
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
        @endif

        <tr class="text-left">
            <td colspan="7" class="text-right " style="padding:50px; border: 1px solid #ffffff"><span style="float:right ; border-bottom: 1px dotted #000000">Date et visa du responssable</span></td>
        </tr>
    </table>

</section>

</body>
</html>