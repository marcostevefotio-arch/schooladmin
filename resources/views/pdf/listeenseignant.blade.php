<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset("") }}assets/css/bootstrap.min.css" />
    <title>{{ ($by=='all')? "Liste des enseignants" : "Liste des enseignants par ".$by }}</title>
</head>
<body>
<div class="container text-center" style="background:linear-gradient(rgba(255,255,255,0.9),rgba(255,255,255,0.9)), url({{ asset("") }}assets/images/logo/issat.png) no-repeat center center">
    <h2 class="text-center"><img src="{{ asset("") }}assets/images/logo/issat.png" width="100" alt=""></h2>
    <h2 class="text-center text-uppercase" style="font-weight: bold; font-family: Arial">
        {{ ($by=='all')? "Liste des enseignants" : "Liste des enseignants par ".$by }}
        <div style="width: 200px; height: 5px; background: rgb(88,86,91); margin:5px auto"></div>
    </h2>
    <table class="table table-bordered">
        @if($by=="all")

            <tr class="bg-warning">
                <td>N°</td>
                <td>Nom(s) et Prénom</td>
                <td>Diplome de référence</td>
                <td>Grade</td>
                <td>Spécialité</td>
                <td>Email</td>
                <td>Téléphone</td>
            </tr>
            @foreach($data as $i=>$et)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                    <td>{{ $et->diplome }}</td>
                    <td>{{ $et->grade }}</td>
                    <td>{{ $et->specialite }}</td>
                    <td>{{ $et->email }}</td>
                    <td>{{ $et->phonenumber }}</td>
                </tr>
            @endforeach
        @endif

        @if($by=="grade")
            @foreach($data2 as $key=>$d3)
                <tr class="bg-warning">
                    <td colspan="7"><h4 class="text-uppercase">Grade {{ $key }}</h4></td>
                </tr>

                <tr class="bg-warning">
                    <td>N°</td>
                    <td>Nom(s) et Prénom</td>
                    <td>Diplome de référence</td>
                    <td>Grade</td>
                    <td>Spécialité</td>
                    <td>Email</td>
                    <td>Téléphone</td>
                </tr>
                @foreach($d3 as $i=>$et)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                        <td>{{ $et->diplome }}</td>
                        <td>{{ $et->grade }}</td>
                        <td>{{ $et->specialite }}</td>
                        <td>{{ $et->email }}</td>
                        <td>{{ $et->phonenumber }}</td>
                    </tr>
                @endforeach

            @endforeach
        @endif

        @if($by=="specialite")
            @foreach($data3 as $key=>$d3)
                <tr class="bg-warning">
                    <td colspan="7"><h4 class="text-uppercase">Spécialité {{ $key }}</h4></td>
                </tr>

                <tr class="bg-warning">
                    <td>N°</td>
                    <td>Nom(s) et Prénom</td>
                    <td>Diplome de référence</td>
                    <td>Grade</td>
                    <td>Spécialité</td>
                    <td>Email</td>
                    <td>Téléphone</td>
                </tr>
                @foreach($d3 as $i=>$et)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                        <td>{{ $et->diplome }}</td>
                        <td>{{ $et->grade }}</td>
                        <td>{{ $et->specialite }}</td>
                        <td>{{ $et->email }}</td>
                        <td>{{ $et->phonenumber }}</td>
                    </tr>
                @endforeach

            @endforeach
        @endif

        @if($by=="nationalite")
                @foreach($data5 as $key=>$d3)
                    <tr class="bg-warning">
                        <td colspan="7"><h4 class="text-uppercase">Nationalité {{ $key }}</h4></td>
                    </tr>

                    <tr class="bg-warning">
                        <td>N°</td>
                        <td>Nom(s) et Prénom</td>
                        <td>Diplome de référence</td>
                        <td>Grade</td>
                        <td>Spécialité</td>
                        <td>Email</td>
                        <td>Téléphone</td>
                    </tr>
                    @foreach($d3 as $i=>$et)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $et->lastname }} {{ $et->firstname }}</td>
                            <td>{{ $et->diplome }}</td>
                            <td>{{ $et->grade }}</td>
                            <td>{{ $et->specialite }}</td>
                            <td>{{ $et->email }}</td>
                            <td>{{ $et->phonenumber }}</td>
                        </tr>
                    @endforeach

                @endforeach
        @endif


        <tr class="text-left">
            <td colspan="7" class="text-right " style="padding:10px 50px 50px 0;"><label style="text-decoration: underline dotted #000000">Date et visa du responssable</label></td>
        </tr>
    </table>

</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/jquery-ui.custom.min.js"></script>
<script>

</script>
</body>
</html>