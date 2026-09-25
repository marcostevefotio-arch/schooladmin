<table border="box" rules="all" width="100%">
    <thead style="background: rgb(255,226,0)">
    <th>UE</th>
    <th>INTITULE</th>
    <th>CC</th>
    <th>NORMALE</th>
    <th>CREDITS</th>
    <th>NOTE FINALE</th>
    <th>APPRECIATION</th>
    </thead>
    <body>
    @php
        $totalnotes = 0;
        $totalcc = 0;
        $totalnormal = 0;
        $totalcredit = 0;
        $totalcreditEu = 0;
    @endphp
    @foreach($typeue as $tu)
        <tr>
            <td colspan="7" style="font-weight: bold; font-size: 12px; background: rgba(255,226,0,0.67)">{{ $tu->libelletypeue }}</td>
        </tr>
        @foreach($ue as $k=>$matieres)
                @if($tu->id==$matieres[0]["typeue_id"])
                    @foreach($matieres as $l=>$m)
                        {{--@foreach($notes as $n)--}}
                            <tr>
                                @if($l==0)
                                    <td rowspan="{{ count($matieres)>0? count($matieres) : 1 }}">{{ $k }}</td>
                                @endif
                                <td>{{ $m["libelleMatiere"] }}</td>
                                <td>
                                    @php
                                        $cc = \Illuminate\Support\Facades\DB::table("notes")->select("moyenne")
                                            ->where("etudiant_id", $et->etID)
                                            ->where("matiere_id", $m["idm"])
                                            ->where("year", date("Y"))
                                            ->where("typeevaluation", "cc")
                                            ->first();

                                        echo !empty($cc)? $cc->moyenne : 0;

                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $normal = \Illuminate\Support\Facades\DB::table("notes")->select("moyenne")
                                            ->where("etudiant_id", $et->etID)
                                            ->where("matiere_id", $m["idm"])
                                            ->where("year", date("Y"))
                                            ->where("typeevaluation", "normal")
                                            ->first();
                                        $ratrapage = \Illuminate\Support\Facades\DB::table("notes")->selectRaw("moyenne")
                                            ->where("etudiant_id", $et->etID)
                                            ->where("matiere_id", $m["idm"])
                                            ->where("year", date("Y"))
                                            ->where("typeevaluation", "recove")
                                            ->first();

                                        if(empty($ratrapage)){
                                            echo !empty($normal)? $normal->moyenne : 0;
                                        }else{
                                            echo !empty($ratrapage)? $ratrapage->moyenne : 0;
                                        }
                                    @endphp
                                </td>
                                <td>{{ $m["credit"] }}</td>
                                <td>
                                    @php
                                        $cc = \Illuminate\Support\Facades\DB::table("notes")->select("moyenne")
                                            ->where("etudiant_id", $et->etID)
                                            ->where("matiere_id", $m["idm"])
                                            ->where("year", date("Y"))
                                            ->where("typeevaluation", "cc")
                                            ->first();
                                        $normal = \Illuminate\Support\Facades\DB::table("notes")->select("moyenne")
                                            ->where("etudiant_id", $et->etID)
                                            ->where("matiere_id", $m["idm"])
                                            ->where("year", date("Y"))
                                            ->where("typeevaluation", "normal")
                                            ->first();
                                        $ratrapage = \Illuminate\Support\Facades\DB::table("notes")->selectRaw("moyenne")
                                            ->where("etudiant_id", $et->etID)
                                            ->where("matiere_id", $m["idm"])
                                            ->where("year", date("Y"))
                                            ->where("typeevaluation", "recove")
                                            ->first();

                                        $notecc = !empty($cc)? $cc->moyenne*0.3 : 0;
                                        $notenormal = !empty($normal)? $normal->moyenne*0.7 : 0;
                                        $noteratrap = !empty($ratrapage)? $ratrapage->moyenne*0.7 : 0;
                                        $notematiere = 0;

                                        if(empty($ratrapage)){
                                            $notematiere =  $notenormal+$notecc;;
                                            echo $notematiere;
                                            $totalnotes += $notematiere;
                                            $totalcredit += $m["credit"];
                                            $totalcc +=$notecc;
                                            $totalnormal += $notenormal;

                                            if($notematiere>=10){
                                                $totalcreditEu += $m["credit"];
                                            }
                                        }else{
                                            $notematiere = $noteratrap+$notecc;
                                            echo $notematiere;
                                            $totalnotes += $notematiere;
                                            $totalcredit += $m["credit"];
                                            $totalcc +=$notecc;
                                            $totalnormal += $notenormal;

                                            if($notematiere>=10){
                                                $totalcreditEu += $m["credit"];
                                            }
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        if ($notematiere>=16){
                                            echo "A";
                                        }

                                        if ($notematiere>=14 && $notematiere<16){
                                            echo "B";
                                        }

                                        if ($notematiere>=12 && $notematiere<14){
                                            echo "C";
                                        }

                                        if ($notematiere>=10 && $notematiere<12){
                                            echo "D";
                                        }

                                        if ($notematiere>=8 && $notematiere<10){
                                            echo "E";
                                        }

                                        if ($notematiere<8){
                                            echo "F";
                                        }
                                    @endphp
                                </td>
                            </tr>

                            {{--@endif--}}
                        {{--@endforeach--}}
                    @endforeach
                @endif
        @endforeach
    @endforeach

    <tr style="font-weight: bold; font-size: 12px; background: rgba(255,226,0,0.67)">
        <td COLSPAN="2">TOTAL GENERAL</td>
        <td>{{ $totalcc }}</td>
        <td>{{ $totalnormal }}</td>
        <td>{{ $totalcredit }}</td>
        <td>{{ $totalnotes }}</td>
        <td></td>
    </tr>
    <tr style="font-weight: bold; font-size: 12px; background: rgba(255,226,0,0.67)">
        <td colspan="7"><br/></td>
    </tr>
    <tr style="font-weight: bold; font-size: 12px; background: rgba(255,226,0,0.67)">
        <td>MOYENNE ANNUELLE</td>
        <td>{{ count($matieres)>0? $totalnotes/count($matieres) : 0 }}</td>
        <td>TOTAL CREDITS</td>
        <td>{{ $totalcreditEu }}/{{ $totalcredit }}</td>
        <td>DECISION FINALE</td>

        @if($totalnotes>=10 && $totalcreditEu==$totalcredit)
            <td colspan="2" style="background: rgb(1,168,95)">
                ADMIS(E)
            </td>
        @else
            <td colspan="2" style="background: rgb(246,137,134)">
                REFUSE(E)
            </td>
        @endif
    </tr>
    </body>
</table>
