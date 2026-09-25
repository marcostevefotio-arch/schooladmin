<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>{{ $data->dossier[0]->matriculeDossier }}_{{ date("hisYmd") }}</title>
</head>
<body>

<style>
    .cadre{
        background: url({{ asset("") }}assets/images/logo/issat.png) no-repeat center center;
        background-size: contain;
        background-position: center;
        border: 5px double #999999;
        border-radius: 10px;
        padding: 10px 0px;
        height: 240px;
        width: 500px;
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
        margin-top: -32px;
        background: #ffffff;
        z-index: 100;
        height: 200px;
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
        text-align: left;
    }

</style>
<div class="container text-center" style="margin: -30px">
    <div class="cadre">
        <div class="superieur">
            <img src="{{ asset("") }}assets/images/logo/issat.png" width="20" alt="" style="margin-left: 240px; border-radius:30%;">
            <h5 style="font-weight: bold">INSTITUT DE FOMATION PROFESSIONNELLE SMMA &TECH ACADEMY</h5>
            <p style="text-align: left">ARRETE N° 000618/MINFOP/SG/DFOP/SDGSF/CSACD/CBAC</p>&nbsp;
            <h5 style="margin-top: -10px">CARTE DE BIBLIOTHEQUE</h5>
            <hr style="margin-top: -20px">
        </div>
        <br>
        <div class="inferieur">
            <div id="avatar" class="inf-elem">
                <img src="{{ !empty($data->avatar)? asset("").$data->avatar : asset("").'assets/images/avatars/avatar.png' }}" alt="" class="img-fluid" style="width: 140px; height: 150px;padding: 5px">
            </div>
            <div id="infos" class="inf-elem">
                <label for="">Matricule:&nbsp;</label><i>{{ $data->dossier[0]->matriculeDossier }}</i><br>
                <label for="">Filière:&nbsp;</label>
                @foreach($data->dossier[0]->inscriptions[0]->choice as $ch)
                    @if($ch->etat == 1)
                        <i>{{  $ch->specialite->filiere->codeFiliere }}</i> / <i>{{ $ch->specialite->libelleSpecialite }}</i>
                    @endif
                @endforeach
                <br>
                <label for="">Nom et Prenoms / First name and surname:&nbsp;</label><i>{{ $data->lastname }} {{ $data->firstname }}</i><br>

                <label for="">Né (e) le / Born on the:&nbsp;</label><i>{{ date('d/m/Y', strtotime($data->birthday)) }}</i>
                <label for="">A / at:</label><i>{{ $data->birthplace }}</i><br>

                <label for="">Nationalité/ Nationality:&nbsp;</label><i>{{ $data->nationality }}</i><br>
                <label for="">Téléphone/ Phone number:&nbsp;</label><i>{{ $data->phonenumber }}</i><br>
                <label for="">E-mail/ Email:&nbsp;</label><i>{{ $data->email }}</i><br>
            </div>
            <div style="width: 100%">
                <u type="dotted" style=" margin-left: 10px;">L'ETUDIANT</u>
                <u type="dotted" style="float: right; margin-right: 10px;">LE DIRECTEUR</u>
            </div>
        </div>
    </div>

</div>

</body>
</html>