<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Cartes d'étudiants{{ date("hisYmd") }}</title>
    <style>
        @page {
            margin: 10px 10px;
        }
        .cadre{
            background: url({{ asset("") }}assets/images/logo/issat.png) no-repeat center center;
            background-size: 60%;
            background-position: center;
            border: 5px double #999999;
            border-radius: 10px;
            padding: 10px 0px;
            height: 210px;
            width: 96%;
            margin: 2px;
        }

        .superieur{
            height: 70px;
            background: #ffffff;
            opacity: 0.8;
            /*overflow: hidden;*/
        }
        
        .logo img{
            width: 75px;
            padding: 0px 5px;
        }
        
        .school{
            margin-top: -75px;
            padding: 5px;
            margin-left: 80px;
        }

        .superieur h6{
            margin-top:-5px;
            font-family: arial;
            font-size: 14px!important;
            padding: 5px;
        }
        
        .superieur *{
            text-align: center!important;
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
        label, i{
            font-size: 10px;
            color: #000000!important;
        }

        label{
            font-weight: bold;
            color: #555555!important;
            font-size: 8px;
        }

        #infos{
            width: 60%;
            height: 100%;
            text-align: left;
        }

    </style>
</head>
<body>
    @if($etudiants["collection"]->count()>0)
    <table border="box" width="{{($etudiants["collection"]->count()==1)? "50%" : "100%" }}" rules="none">
        @php
            $conteur = 1;
        @endphp
        @foreach($etudiants["collection"] as $i=>$etd)
            @if($conteur==1)
                <tr>
            @endif
            <td>
                <div class="cadre">
                    <div class="superieur">
                        <h6 style="margin-top: -8px; font-weight: bold; font-size: 12px">INSTITUT DE FOMATION PROFESSIONNELLE SMMA &TECH ACADEMY</h6>
                        <p style=" font-weight: bold; text-align: left; margin-top: -38px; font-style: italic; font-size: 8px;">ARRETE N° 000618/MINFOP/SG/DFOP/SDGSF/CSACD/CBAC</p>&nbsp;
                        <hr style="margin-top: -1px">
                    </div>
                    <br>
                    <h5 style="margin-top: -45px; text-align: center; color: #010c52">CARTE D'ETUDIANT</h6>
                    <div class="inferieur">
                        
                        <div id="avatar" class="inf-elem">
                            <img src="{{ !empty($etd->avatar)? asset("").$etd->avatar : 'assets/images/avatars/avatar.png' }}" alt="" class="img-fluid" style="width: 100px; padding: 5px">
                        </div>
                        <div id="infos" class="inf-elem">
                            <label for="">Matricule:&nbsp;</label><i style="font-size: 8px;">{{ $etd->matriculeDossier }}</i><br>
                            <label for="">Filière:&nbsp;</label><i style="font-size: 8px;">{{  $etd->libelleSpecialite }}</i><br>
                            <label for="">Nom et Prenoms :&nbsp;</label><i style="font-size: 8px;">{{ $etd->lastname }} {{ $etd->firstname }}</i><br>
                            <label for="">Né (e) le / Born on the:&nbsp;</label><i style="font-size: 8px;">{{ date('d/m/Y', strtotime($etd->birthday)) }}</i>
                            <label for="">A / at: </label><i>{{ $etd->birthplace }}</i><br>
                            <label for="">Nationalité/ Nationality:&nbsp;</label><i style="font-size: 8px;">{{ $etd->nationality }}</i><br>
                            <label for="">Téléphone/ Phone number:&nbsp;</label><i style="font-size: 8px;">{{ $etd->phonenumber }}</i><br>
                            <label for="">E-mail/ Email:&nbsp;</label><i style="font-size: 8px;">{{ $etd->email }}</i><br><br>
                            <label for="" style="float: right; margin-right: 10px; margin-top: 0px"><u type="dotted">LE DIRECTEUR</u></label>
                        </div>
                    </div>
                </div>
            </td>
            @php
                $conteur++;
            @endphp
            @if($conteur==3)
                </tr>
                @php
                    $conteur=1;
                @endphp
            @endif
        @endforeach
    </table>
    @endif
</body>
</html>