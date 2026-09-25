<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset("") }}assets/css/bootstrap.min.css" />
    <title>{{ $data->matricule }}_{{ date("hisYmd") }}</title>
</head>
<body>
    <div class="container text-center" style="background:linear-gradient(rgba(255,255,255,0.9),rgba(255,255,255,0.9)), url({{ asset("") }}assets/images/logo/issat.png) no-repeat center center">
        <h2 class="text-center"><img src="{{ asset("") }}assets/images/logo/issat.png" width="150" alt=""></h2>
        <h2 class="text-center text-uppercase" style="font-weight: bold; font-family: Arial">
            FICHE DE PREINSCRIPTION /  REGISTRATION’S FILE
            <div style="width: 200px; height: 5px; background: rgb(88,86,91); margin:5px auto"></div>
        </h2>
        <h3 class="text-center" style="font-weight: bold">Cycle: {{ $data->dossier->cycle->codeCycle }}</h3>
        <table class="table table-bordered">
            <tr class="bg-warning">
                <td colspan="5"><h4>IDENTIFICATION DU CANDIDAT/ CANDIDAT’S IDENTIFICATION</h4></td>
            </tr>
            <tr>
                <td rowspan="6">
                    <div style="width: 200px">
                        <img src="{{ (isset($data) && !empty($data->dossier->etudiant->photo))? $data->dossier->etudiant->photo : "assets/images/avatars/avatar.png" }}" style="width: 100%" alt="">
                    </div>
                </td>
            </tr>
            <tr class="text-left">
                <td colspan="2" width="50%"><label>Nom et Prenoms / First name and surname</label></td>
                <td colspan="3" width="50%"><label>{{ $data->dossier->etudiant->lastname }} {{ $data->dossier->etudiant->firstname }}</label></td>
            </tr>
            <tr class="text-left">
                <td colspan="1"><label>Né (e) le / Born on the: </label></td>
                <td colspan="1"><label>{{ date('d/m/Y', strtotime($data->dossier->etudiant->birthday)) }}</label></td>
                <td colspan="1"><label>A/ at:</label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->birthplace }}</label></td>
            </tr>
            <tr class="text-left">
                <td colspan="1"><label>Nationalité/ Nationality : </label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->nationality }}</label></td>
                <td colspan="1"><label>Region:</label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->region }}</label></td>
            </tr>
            <tr class="text-left">
                <td colspan="1"><label>Télephone/ Phone number : </label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->phonenumber }}</label></td>
                <td colspan="1"><label>e-mail: </label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->email }}</label></td>
            </tr>
            <tr class="text-left">
                <td colspan="1"><label>Langues officielles/ Officials languages : </label></td>
                <td colspan="3"><label>{{ $data->dossier->etudiant->language }}</label></td>
            </tr>
            <tr class="bg-warning">
                <td colspan="5"><h4>PROFIL SCOLAIRE/ ACADEMIC PROFIL</h4></td>
            </tr>
            <tr class="text-left">
                <td colspan="2"><label>Choix de formation : </label></td>
                <td colspan="1"><label>{{ $data->choice[0]->specialite->libelleSpecialite }}</label></td>
                <td colspan="1"><label>{{ $data->choice[1]->specialite->libelleSpecialite }}</label></td>
                <td colspan="1"><label>{{ $data->choice[2]->specialite->libelleSpecialite }}</label></td>
            </tr>
            <tr>
                <td colspan="5">
                    <table width="100%">
                        <thead>
                            <th><label>Diplôme d’admission/ Admission’s diploma  </label></th>
                            <th><label>Serie/ option </label></th>
                            <th><label>Année d’obtention/ School year </label></th>
                            <th><label>Pays d’obtention/ Diploma’s country</label></th>
                            <th><label>Etablissement/ School attended  </label></th>
                        </thead>
                        <tbody>
                            @foreach($data->dossier->parcours as $p)
                                <tr class="text-left">
                                    <td colspan="3"><label>{{ $p->admissiondiploma }}</label></td>
                                    <td colspan="1"><label>{{ $p->option }}</label></td>
                                    <td colspan="1"><label>{{ $p->schoolyear }}</label></td>
                                    <td colspan="3"><label>{{ $p->diplomacountry }}</label></td>
                                    <td colspan="3"><label>{{ $p->schoolattended }}</label></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr class="bg-warning">
                <td colspan="5"><h4>INFORMATIONS COMPLEMENTAIRES/ FURTHER INFORMATION</h4></td>
            </tr>

            <tr class="text-left">
                <td colspan="2"><label>Noms du père/ Name of father  : </label></td>
                <td colspan="3"><label>{{ $data->dossier->etudiant->parent->fathername }}</label></td>
            </tr>

            <tr class="text-left">
                <td colspan="2"><label>Profession : </label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->parent->fatherprofession }}</label></td>
                <td colspan="1"><label>Contact:</label></td>
                <td colspan="1"><label>{{ $data->etudiant->parent->fathercontact }}</label></td>
            </tr>
            <tr class="text-left">
                <td colspan="2"><label>Noms de la mère/ Name of mother  : </label></td>
                <td colspan="3"><label>{{ $data->dossier->etudiant->parent->mothername }}</label></td>
            </tr>
            <tr class="text-left">
                <td colspan="2"><label>Profession : </label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->parent->motherprofession }}</label></td>
                <td colspan="1"><label>Contact :</label></td>
                <td colspan="1"><label>{{ $data->etudiant->parent->mothercontact }}</label></td>
            </tr>
            <tr class="text-left">
                <td colspan="2"><label>Personne à contacter en cas d’urgence : </label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->parent->emergencyname }}</label></td>
                <td colspan="1"><label>Contact :</label></td>
                <td colspan="1"><label>{{ $data->etudiant->parent->emergencycontact }}</label></td>
            </tr>
            <tr class="text-left">
                <td colspan="2"><label>Sport préfére : </label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->sport }}</label></td>
                <td colspan="1"><label>Loisir :</label></td>
                <td colspan="1"><label>{{ $data->dossier->etudiant->leisure }}</label></td>
            </tr>




            <tr class="bg-warning">
                <td colspan="5"><h4>ANTECEDANT MEDICAUX/ MEDICAL HISTORY</h4></td>
            </tr>

            <tr class="text-left">
                <td colspan="2"><label>Pathologie /Pathology  : </label></td>
                <td colspan="2"><label>Date de la derniere consultation / Date of last consultation</label></td>
                <td colspan="1"><label>Observation / Observation</label></td>
            </tr>
            @foreach($data->dossier->etudiant->antecedants as $a)
                <tr class="text-left">
                    <td colspan="2"><label>{{ $a->maladie }}</label></td>
                    <td colspan="2"><label>{{ $a->dateconsultation }}</label></td>
                    <td colspan="1"><label>{{ $a->etat }}</label></td>
                </tr>
            @endforeach
            <tr class="text-left">
                <td colspan="6" class="text-right " style="padding:10px 50px 50px 0;"><label style="text-decoration: underline dotted #000000">Date et visa de l’étudiant</label></td>
            </tr>
        </table>
        <br>
        <table class="table table-bordered">
            <tr class="bg-warning">
                <td colspan="4"><h4 class="text-uppercase">Cadre réservé à l’administration</h4></td>
            </tr>
            <tr>
                <td colspan="1"><label for="">N° Matricule :</label></td>
                <td colspan="1">{{ $data->dossier->matriculeDossier }}</td>
                <td colspan="1"><label for="">Année :</label></td>
                <td colspan="1">{{ $data->dossier->anneeacademique->numeroAnnee }}</td>
            </tr>
            <tr>
                <td colspan="1"><label for="">N° Dossier :</label></td>
                <td colspan="1">{{ $data->dossier->numeroDossier }}</td>
                <td colspan="1">{{ $data->dossier->level->numeroLevel }}</td>
                <td colspan="1"><label for="">Date de dépôt de Dossier</label></td>
                <td colspan="1">{{ date('d/m/Y', strtotime($data->dateInscription)) }}</td>
            </tr>
        </table>

    </div>

    <script src="assets/js/jquery-2.1.4.min.js"></script>

    <script src="assets/js/bootstrap.min.js"></script>

    <script src="assets/js/jquery-ui.custom.min.js"></script>
    <script>
        $(document).ready(function(){

                pdfdoc.fromHTML($("#PDFcontent").html(), 10, 10, {

                    "width": 110,

                    "elementHandlers": specialElementHandlers

                });

                pdfdoc.save("First.pdf");

        });
    </script>
</body>
</html>