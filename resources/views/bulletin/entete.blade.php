<table width="100%" align="center">
    <tr>
        <th width="45%">
            <table border="box" rules="all"  width="100%"  align="center">
                <tr>
                    <td>ANNEE ACADEMIQUE</td>
                    <td>: {{ $et->year }}</td>
                </tr>
                <tr>
                    <td>CYCLE</td>
                    <td>: {{ $et->cycle }}</td>
                </tr>
                <tr>
                    <td>FILIERE</td>
                    <td>: {{ $et->libelleFiliere }}</td>
                </tr>
                <tr>
                    <td>SPECIALITE</td>
                    <td>: {{ $et->libelleSpecialite }}</td>
                </tr>
                <tr>
                    <td>NIVEAU</td>
                    <td>: {{ $et->level }}</td>
                </tr>
            </table>
        </th>
        <th width="10%">
            <img src="assets/images/logo/issat.png" alt="" height="100">
        </th>
        <th width="45%">
            <table  border="box" rules="all" width="100%" align="center">
                <tr>
                    <td>NOM</td>
                    <td>: {{ $et->lastname }}</td>
                </tr>
                <tr>
                    <td>PRENOM</td>
                    <td>: {{ $et->firstname }}</td>
                </tr>
                <tr>
                    <td>SEXE</td>
                    <td>: {{ $et->sexe }}</td>
                </tr>
                <tr>
                    <td>DATE DE NAISSANCE</td>
                    <td>: {{ $et->birthday }}</td>
                </tr>
                <tr>
                    <td>MATRICULE</td>
                    <td>: {{ $et->matricule }}</td>
                </tr>
            </table>
        </th>
    </tr>
</table>