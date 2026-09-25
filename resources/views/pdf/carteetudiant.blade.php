<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>{{ $data->dossier[0]->matriculeDossier }}_{{ date("hisYmd") }}</title>
    <style>
        .cadre{
            background: url({{ asset("") }}assets/images/logo/issat.png) no-repeat center center;
            background-size: contain;
            background-position: center;
            border: 5px double #999999;
            border-radius: 10px;
            padding: 10px 0px;
            height: 210px;
            width: 380px;
            margin: auto;
        }

        .superieur{
            height: 70px;
            background: #ffffff;
            opacity: 0.8;
            /*overflow: hidden;*/
        }

        .superieur h5{
            margin-top:-5px;
            text-align: center;
        }

        .inferieur{
            margin-top: -45px;
            background: #ffffff;
            z-index: 100;
            height: 160px;
            opacity: 0.8;
        }

        .inf-elem{
            display: block;
            float: left;
        }
        #avatar{
            width: 35%;
            height: 100%;
        }

        label{
            font-weight: bold;
        }
        label, i{
            font-size: 10px;
            line-height: 5px;
        }

        #infos{
            width: 60%;
            height: 100%;
            text-align: left;
        }

    </style>
</head>
<body>

<div class="container text-center" style="margin-top: -40px; margin-left: -20px; transform: scale(0.2); transform: translate(-20px)">
    <div class="cadre">
        <div class="superieur" style="text-align: center">
            <img src="{{ asset("") }}assets/images/logo/issat.png" width="20" alt="" >
            <h6 style="margin-top: -5px; font-weight: bold">INSTITUT DE FOMATION PROFESSIONNELLE SMMA &TECH ACADEMY</h6>
            <p style="text-align: left">ARRETE N° 000618/MINFOP/SG/DFOP/SDGSF/CSACD/CBAC</p>&nbsp;
            <h6 style="margin-top: -20px">CARTE D'ETUDIANT (ANNEE ACADEMIQUE {{  $data->dossier[0]->inscriptions[0]->anneacademique->numeroAnnee }}-{{  intval($data->dossier[0]->inscriptions[0]->anneacademique->numeroAnnee)+1 }})</h6>
            <hr style="margin-top: -20px">
        </div>
        <br>
        <div class="inferieur">
            <div id="avatar" class="inf-elem">
                {{--<img src="{{ (isset($data) && !empty($data->avatar))? asset("").$data->avatar : asset("")."assets/images/avatars/avatar.png" }}"   style="width: 140px" alt="">--}}
                <img src="{{ !empty($data->avatar)? asset("").$data->avatar : 'assets/images/avatars/avatar.png' }}" alt="" class="img-fluid" style="width: 120px; padding: 5pxs">

            </div>
            <div id="infos" class="inf-elem">
                <label for="">Matricule:&nbsp;</label><i>{{ $data->dossier[0]->matriculeDossier }}</i><br>
                <label for="">Filière:&nbsp;</label>
                @foreach($data->dossier[0]->inscriptions[0]->choice as $ch)
                    @if($ch->etat == 1)
                        <i>{{  $ch->specialite->filiere->codeFiliere }}</i> / <i>{{ $ch->specialite->libelleSpecialite }}</i>

                    @endif
                @endforeach<br>
                <label for="">Niveau / Level:&nbsp;</label><i>{{ $data->dossier[0]->inscriptions[0]->level->numeroLevel }} </i><br>
                <label for="">Nom et Prenoms :&nbsp;</label><i>{{ $data->lastname }} {{ $data->firstname }}</i><br>

                <label for="">Né (e) le / Born on the:&nbsp;</label><i>{{ date('d/m/Y', strtotime($data->birthday)) }}</i>
                <label for="">A / at:</label><i>{{ $data->birthplace }}</i><br>

                <label for="">Nationalité/ Nationality:&nbsp;</label><i>{{ $data->nationality }}</i><br>
                <label for="">Téléphone/ Phone number:&nbsp;</label><i>{{ $data->phonenumber }}</i><br>
                <label for="">E-mail/ Email:&nbsp;</label><i>{{ $data->email }}</i><br>
                <label for="" style="float: right; margin-right: 10px; margin-top: 0px"><u type="dotted">LE DIRECTEUR</u></label>
            </div>
        </div>
    </div>

</div>

</body>
</html>