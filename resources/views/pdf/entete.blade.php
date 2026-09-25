<table width="100%" align="center" boder="box" rules="none" style="text-align: center">
    <tr>
        <th width="25%">
            <img src="{{ asset("") }}assets/images/logo/issat.png" alt="" height="100">
        </th>
        <th width="75%">
            <table  border="box" rules="none" width="100%" align="center"  style="text-align: center">
                <tr>
                    <td style="padding-left: 10px">
                        <h2 style="text-align:left; padding-right: 30px">{{ $data["school"]->scoolname }}</h2>
                        <p style="text-align: left; margin-bottom: -50px; padding-top: 0px;"">ARRETE N° 000618/MINFOP/SG/DFOP/SDGSF/CSACD/CBAC</p>&nbsp;
                        <h4 style="text-align:left; ">
                            <span>B.P: {{ $data["school"]->schoolPobox }}</span>&nbsp;
                            <span>Contact: {{ $data["school"]->schoolPhone }}</span>&nbsp;
                            <span>Email: {{ $data["school"]->schoolEmail }}</span>&nbsp;
                        </h4>
                    </td>
                </tr>
            </table>
        </th>
    </tr>
</table>
<hr>