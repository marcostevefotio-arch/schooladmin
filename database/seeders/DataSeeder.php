<?php

namespace Database\Seeders;

use App\Models\Anneeacademique;
use App\Models\Antecedant;
use App\Models\Caisse;
use App\Models\Categorie;
use App\Models\Choice;
use App\Models\Cycle;
use App\Models\Dossieretudiant;
use App\Models\Espace;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Inscription;
use App\Models\Level;
use App\Models\Menu;
use App\Models\Parcour;
use App\Models\Perent;
use App\Models\Permission;
use App\Models\Specialite;

use App\Models\Etablissement;
use App\Models\Matiere;
use App\Models\Parametre;
use App\Models\Semestre;
use App\Models\Typeue;

use App\Models\Ue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("classements")->truncate();
        DB::table("classes")->truncate();
        DB::table("cours")->truncate();
        DB::table("documents")->truncate();
        DB::table("enseignants")->truncate();
        DB::table("etablissements")->truncate();
        DB::table("evaluations")->truncate();
        DB::table("evenements")->truncate();
        DB::table("filieres")->truncate();
        DB::table("historiques")->truncate();
        DB::table("semestres")->truncate();
        DB::table("specialites")->truncate();
        DB::table("typedocuments")->truncate();
        DB::table("users")->truncate();

        $this->menus();
        $this->permissions();
        $this->groupes();
        $this->personnel();
        $this->user();
        $this->cycle();
        $this->levels();
        $this->etudiants();


        $this->parametres();
        $this->etablissement();
        $this->semestre();

        $this->filiere();
        $this->specialite();
        $this->typeue();
        $this->ue();
        $this->matieres();


    }

    public function menus(){
        DB::table("menus")->truncate();

        $data = array(
            array("code_menu"=>Str::lower("home"), "libelle_menu"=>"Tableau de bord", "icon_menu"=>"fa-home", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homeinscription"), "libelle_menu"=>"Gestion des inscriptions", "icon_menu"=>"fa-edit",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homeetudiant"), "libelle_menu"=>"Gestion des étudiants", "icon_menu"=>"fa-certificate",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homefiliere"), "libelle_menu"=>"Gestion des filières", "icon_menu"=>"fa-graduation-cap",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homescolarite"), "libelle_menu"=>"Gestion de la scolarite", "icon_menu"=>"fa-book",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homenote"), "libelle_menu"=>"Gestion des notes", "icon_menu"=>"fa-file-text",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homeplaning"), "libelle_menu"=>"Gestion des planings", "icon_menu"=>"fa-calendar",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homeenseignant"), "libelle_menu"=>"Gestion des enseignants", "icon_menu"=>"fa-briefcase",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homeorganisation"), "libelle_menu"=>"Gestion de l'organisation", "icon_menu"=>"fa-building",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homesecurite"), "libelle_menu"=>"Gestion de la sécurité", "icon_menu"=>"fa-shield",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            array("code_menu"=>Str::lower("homesettings"), "libelle_menu"=>"Parametres", "icon_menu"=>"fa-cogs",  "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true)
        );

        $data_sub = array(
            array(
                array("code_menu"=>Str::lower("inscriptions-annee"), "menu_id"=>2, "libelle_menu"=>"Annees académique", "icon_menu"=>"fa-calendar", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("inscriptions-list"), "menu_id"=>2, "libelle_menu"=>"Liste des inscriptions", "icon_menu"=>"fa-edit", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("inscription-fiche"), "menu_id"=>2, "libelle_menu"=>"Fiches d'inscription", "icon_menu"=>"fa-folder-o", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("inscription-etat"), "menu_id"=>2, "libelle_menu"=>"Etats", "icon_menu"=>"fa-bar-chart-o", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true)
            ),
            array(
                array("code_menu"=>Str::lower("etudiant-effectifs"), "menu_id"=>3, "libelle_menu"=>"Effectifs des étudiants", "icon_menu"=>"fa-edit", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("etudiant-discipline"), "menu_id"=>3, "libelle_menu"=>"Discipline des etudiants", "icon_menu"=>"fa-circle", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("etudiant-demissions"), "menu_id"=>3, "libelle_menu"=>"Demisions des etudiants", "icon_menu"=>"fa-external-link", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("etudiant-notes"), "menu_id"=>3, "libelle_menu"=>"Notes examens", "icon_menu"=>"fa-arrow-down", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("etudiant-releve"), "menu_id"=>3, "libelle_menu"=>"Relevés de notes", "icon_menu"=>"fa-arrow-down", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true)
            ),
            array(
                array("code_menu"=>Str::lower("filiere-list"), "menu_id"=>4, "libelle_menu"=>"Filières", "icon_menu"=>"fa-graduation-cap", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("filiere-specialite"), "menu_id"=>4, "libelle_menu"=>"Spécialités", "icon_menu"=>"fa-certificate", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("filiere-ue"), "menu_id"=>4, "libelle_menu"=>"Unites d'enseignements", "icon_menu"=>"fa-cubes", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("filiere-ec"), "menu_id"=>4, "libelle_menu"=>"Elements Constitutifs", "icon_menu"=>"fa-cube", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("filiere-syllabus"), "menu_id"=>4, "libelle_menu"=>"Syllabus", "icon_menu"=>"fa-list-alt", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true)
            ),
            array(
                array("code_menu"=>Str::lower("scolarite-versement"), "menu_id"=>5, "libelle_menu"=>"Versements", "icon_menu"=>"fa-money", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("scolarite-solvabilite"), "menu_id"=>5, "libelle_menu"=>"Solvabilité", "icon_menu"=>"fa-file-text", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("scolarite-configuration"), "menu_id"=>5, "libelle_menu"=>"Scolarite", "icon_menu"=>"fa-cog", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("scolarite-compte"), "menu_id"=>5, "libelle_menu"=>"Comtes", "icon_menu"=>"fa-shield", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true)
            ),
            array(
                array("code_menu"=>Str::lower("note-list"), "menu_id"=>6, "libelle_menu"=>"Notes", "icon_menu"=>"fa-file-text", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("note-evaluation"), "menu_id"=>6, "libelle_menu"=>"Fiches", "icon_menu"=>"fa-pencil", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("note-pv"), "menu_id"=>6, "libelle_menu"=>"Procès verbal", "icon_menu"=>"fa-files-o", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("note-releve"), "menu_id"=>6, "libelle_menu"=>"Relévés", "icon_menu"=>"fa-clipboard", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true)
            ),
            array(
                array("code_menu"=>Str::lower("planing-programme"), "menu_id"=>7, "libelle_menu"=>"Emploi de temps", "icon_menu"=>"fa-calendar", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("planing-cours"), "menu_id"=>7, "libelle_menu"=>"Cours planifié", "icon_menu"=>"fa-bookmark", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("planing-etat"), "menu_id"=>7, "libelle_menu"=>"Etats des cours", "icon_menu"=>"fa-bar-chart-o", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true)
            ),
            array(
                array("code_menu"=>Str::lower("securite-groupe"), "menu_id"=>10, "libelle_menu"=>"Groupe d'utilisateurs", "icon_menu"=>"fa-users", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("securite-user"), "menu_id"=>10, "libelle_menu"=>"Utilisateurs", "icon_menu"=>"fa-user", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("securite-historique"), "menu_id"=>10, "libelle_menu"=>"Historique d'activités", "icon_menu"=>"fa-exchange", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            ),
            array(
                array("code_menu"=>Str::lower("organisation-list"), "menu_id"=>9, "libelle_menu"=>"Organigram", "icon_menu"=>"fa-building", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            ),
            array(
                array("code_menu"=>Str::lower("enseignant-list"), "menu_id"=>8, "libelle_menu"=>"Effectfs des enseignants", "icon_menu"=>"fa-briefcase", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("enseignant-matiere"), "menu_id"=>8, "libelle_menu"=>"Repartition des UE", "icon_menu"=>"fa-book", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("enseignant-discipline"), "menu_id"=>8, "libelle_menu"=>"Discipline des enseignants", "icon_menu"=>"fa-circle", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("enseignant-cours"), "menu_id"=>8, "libelle_menu"=>"Cours", "icon_menu"=>"fa-bookmark", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true)
            ),
            
            array(
                array("code_menu"=>Str::lower("organisation-parametre"), "menu_id"=>11, "libelle_menu"=>"Parametres d'application", "icon_menu"=>"fa-cogs", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("cycle-list"), "menu_id"=>11, "libelle_menu"=>"Cycles", "icon_menu"=>"fa-briefcase", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("level-list"), "menu_id"=>11, "libelle_menu"=>"Niveaux", "icon_menu"=>"fa-book", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("pays-list"), "menu_id"=>11, "libelle_menu"=>"Pays", "icon_menu"=>"fa-circle", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("region-list"), "menu_id"=>11, "libelle_menu"=>"Regions", "icon_menu"=>"fa-bookmark", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("grade-list"), "menu_id"=>11, "libelle_menu"=>"Grades", "icon_menu"=>"fa-star", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("diplome-list"), "menu_id"=>11, "libelle_menu"=>"Diplomes", "icon_menu"=>"fa-bookmark", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
                array("code_menu"=>Str::lower("ecole-list"), "menu_id"=>11, "libelle_menu"=>"Ecoles", "icon_menu"=>"fa-bookmark", "slug"=>Str::slug(date("sihdmYmdhisu").Str::random(10)), "is_link"=>true),
            )
        );

        foreach ($data as $d){
            Menu::create($d);
        }

        foreach ($data_sub as $sd){
            foreach ($sd as $d){
                Menu::create($d);
            }
        }
    }

    public function permissions(){
        DB::table("permissions")->truncate();
        $modules = Menu::all();

        foreach ($modules as $m) {
            $data = array(
                array("codePermissions"=>Str::random(20), "menu_id"=> $m->id, "code_permission"=> $m->slug."_create", "icon"=>"fa-plus", "titre_permission"=> "create", "action"=> ""),
                array("codePermissions"=>Str::random(20), "menu_id"=> $m->id, "code_permission"=> $m->slug."_read", "icon"=>"fa-eye", "titre_permission"=> "read", "action"=> ""),
                array("codePermissions"=>Str::random(20), "menu_id"=> $m->id, "code_permission"=> $m->slug."_update", "icon"=>"fa-save", "titre_permission"=> "update", "action"=> ""),
                array("codePermissions"=>Str::random(20), "menu_id"=> $m->id, "code_permission"=> $m->slug."_delete", "icon"=>"fa-trash", "titre_permission"=> "delete", "action"=> ""),
                array("codePermissions"=>Str::random(20), "menu_id"=> $m->id, "code_permission"=> $m->slug."_print", "icon"=>"fa-print", "titre_permission"=> "print", "action"=> ""),
            );

            foreach ($data as $d){
                Permission::create($d);
            }
        }


    }

    public function groupes(){
        DB::table("groupes")->truncate();

        $groupes = array(
            ["codeGroupe"=>Str::random(20), "titre_groupe"=>"Super administrateur","description_groupe"=>"","editing"=>false],
        );


        foreach ($groupes as $data){
            $roles = Groupe::create($data);

            $permission = Permission::select("id")->get();
            {
                $roles->permission()->attach($permission);
            }
        }
    }

    public function personnel(){
        DB::table("personnels")->truncate();

        $data = [
            [
                "groupe_id"=>1,
                "code"=>"Superadmin",
                "cni"=>Str::random(9),
            ],
        ];

        foreach ($data as $d){
            DB::table('personnels')->insert($d);
        }
    }

    public function user(){
        DB::table("users")->truncate();

        $data = [
            [
                "codeUser"=>Str::random(20),
                "personnel_id" => 1,
                "email"=>"admin@schooladmin.cm",
                "active"=>1,
                "email_verified_at"=>date("Y-m-d h:i:s"),
                "password"=>Hash::make("superadmin")
            ],
        ];

        foreach ($data as $d){
            DB::table('users')->insert($d);
        }
    }

    public function filiere(){
        DB::table("filieres")->truncate();

        $data = [
            ["codeFiliere"=>"ASA","libelleFiliere"=>"AGRONOMIE ET SCIENCES AGRICOLES","descriptionFiliere"=>"AGRICULTURE ET ELEVAGE"],
            ["codeFiliere"=>"ESGA","libelleFiliere"=>"ECONOMIE ET SCIENCES DE GESTION APPLIQUEE","descriptionFiliere"=>"COMMERCE-VENTE"],
        ];

        foreach ($data as $d){
            Filiere::create($d);
        }
    }

    public function specialite(){
        DB::table("specialites")->truncate();

        $data = [
            ["filiere_id"=>1,"codeSpecialite"=>"AQC","libelleSpecialite"=>"AQUACULTURE","descriptionSpecialite"=>"AGRICULTURE ET ELEVAGE"],
            ["filiere_id"=>1,"codeSpecialite"=>"EAP","libelleSpecialite"=>"ENTREPRENARIAT AGROPASTORAL","descriptionSpecialite"=>"ENTREPRENARIAT AGROPASTORAL"],
            ["filiere_id"=>1,"codeSpecialite"=>"PAN","libelleSpecialite"=>"PRODUCTION ANIMALE","descriptionSpecialite"=>"PRODUCTION ANIMALE"],
            ["filiere_id"=>1,"codeSpecialite"=>"PEV","libelleSpecialite"=>"PRODUCTION VEGETALE","descriptionSpecialite"=>"PRODUCTION VEGETALE"],
            ["filiere_id"=>1,"codeSpecialite"=>"TCA","libelleSpecialite"=>"TECHNIQUES COMMERCIALES AGRICOLES","descriptionSpecialite"=>"TECHNIQUES COMMERCIALES AGRICOLES"],

            ["filiere_id"=>2,"codeSpecialite"=>"BF","libelleSpecialite"=>"BANQUE ET FINANCE","descriptionSpecialite"=>"BANQUE ET FINANCE"],
            ["filiere_id"=>2,"codeSpecialite"=>"GPR","libelleSpecialite"=>"GESTION DES PROJETS","descriptionSpecialite"=>"GESTION DES PROJETS"],
            ["filiere_id"=>2,"codeSpecialite"=>"ASS","libelleSpecialite"=>"ASSURANCE","descriptionSpecialite"=>"ASSURANCE"],
            ["filiere_id"=>2,"codeSpecialite"=>"AMA","libelleSpecialite"=>"ASSISTANT MANAGER","descriptionSpecialite"=>"ASSISTANT MANAGER"],
            ["filiere_id"=>2,"codeSpecialite"=>"STAT","libelleSpecialite"=>"STATISTIQUES","descriptionSpecialite"=>"STATISTIQUES"],
            ["filiere_id"=>2,"codeSpecialite"=>"CGE","libelleSpecialite"=>"COMPTABILITE ET GESTION DES ENTREPRISES","descriptionSpecialite"=>"COMPTABILITE ET GESTION DES ENTREPRISES"],
            ["filiere_id"=>2,"codeSpecialite"=>"GLT","libelleSpecialite"=>"GESTION LOGISTIQUE ET TRANSPORT","descriptionSpecialite"=>"GESTION LOGISTIQUE ET TRANSPORT"],
            ["filiere_id"=>2,"codeSpecialite"=>"GRH","libelleSpecialite"=>"GESTION DES RESSOURCES HUMAINES","descriptionSpecialite"=>"GESTION DES RESSOURCES HUMAINES"],
            ["filiere_id"=>2,"codeSpecialite"=>"GSI","libelleSpecialite"=>"GESTION DES SYSTEMES D'INFORMATION","descriptionSpecialite"=>"GESTION DES SYSTEMES D'INFORMATION"],

            ["filiere_id"=>2,"codeSpecialite"=>"CI","libelleSpecialite"=>"COMMERCE INTERNATIONAL","descriptionSpecialite"=>"COMMERCE INTERNATIONAL"],
            ["filiere_id"=>2,"codeSpecialite"=>"MCV","libelleSpecialite"=>"MARKETING, COMMERCE, VENTE","descriptionSpecialite"=>"MARKETING, COMMERCE, VENTE"],
            ["filiere_id"=>2,"codeSpecialite"=>"DOT","libelleSpecialite"=>"DOUANE ET TRANSIT","descriptionSpecialite"=>"DOUANE ET TRANSIT"],

            ["filiere_id"=>2,"codeSpecialite"=>"CTD","libelleSpecialite"=>"COLLECTIVITE TERRITORIALE ET DESCENTRALISEE","descriptionSpecialite"=>"COLLECTIVITE TERRITORIAL ET DESCENTRALISE"],
            ["filiere_id"=>2,"codeSpecialite"=>"DA","libelleSpecialite"=>"DROIT DES AFFAIRES","descriptionSpecialite"=>"DROIT DES AFFAIRES"],
            ["filiere_id"=>2,"codeSpecialite"=>"CO","libelleSpecialite"=>"COMMUNICATION DES ORGANISATIONS","descriptionSpecialite"=>"COMMUNICATION DES ORGANISATIONS"],
        ];

        foreach ($data as $d){
            Specialite::create($d);
        }
    }

    public function etablissement(){
        DB::table("etablissements")->truncate();

        $data = [
            [
                "codeSchool"=>Str::random(20),
                "scoolname"=>"Institut Supérieur Catholique Saint TARCISIUS d'EDEA",
                "schoolAdresse"=>"Edéa",
                "schoolPhone"=>"(+237) 699 41 08 16 / 677 02 25 06",
                "schoolPobox"=>"244 Edéa",
                "schoolEmail"=>"isainttarcisius@gmail.com",
                "schoolSite"=>"",
                "schoolLogo"=>"",
                "schoolHead"=>"",
            ]
        ];

        foreach ($data as $d){
            Etablissement::create($d);
        }
    }

    public function parametres(){
        DB::table("parametres")->truncate();

        $data = [
            ["codeParametre"=>Str::random(20), "option"=>"Mot de passe", "description"=>"Le mot de passe par defaut des utilisateurs", "valeur"=>"issat", "typevaleur"=>"password", "valeurspossible"=>""],
            ["codeParametre"=>Str::random(20), "option"=>"Papier entete", "description"=>"Le template du papier entete des documents", "valeur"=>"template1", "typevaleur"=>"liste", "valeurspossible"=>"template1,template2,tamplate3"],
            ["codeParametre"=>Str::random(20), "option"=>"Matricule", "description"=>"Parametre de saisie de matricules", "valeur"=>"automatique", "typevaleur"=>"matricule", "valeurspossible"=>"3,.,2-4-4"],
            ["codeParametre"=>Str::random(20), "option"=>"Dossier", "description"=>"Parametre de saisie de numero de dossiers", "valeur"=>"automatique", "typevaleur"=>"dossier", "valeurspossible"=>"0-9999999999"],
        ];

        foreach ($data as $d){
            Parametre::create($d);
        }
    }

    public function typeue(){
        DB::table("typeues")->truncate();

        $data = [
            ["codeTypeue"=>Str::random(20), "libelletypeue"=>"Fondamentales","descriptiontypeue"=>"Fondamentales"],
            ["codeTypeue"=>Str::random(20), "libelletypeue"=>"Professionnelles","descriptiontypeue"=>"Professionnelles"],
            ["codeTypeue"=>Str::random(20), "libelletypeue"=>"Transversales ","descriptiontypeue"=>"Transversales"],
        ];

        foreach ($data as $d){
            Typeue::create($d);
        }
    }



    public function semestre(){
        DB::table("semestres")->truncate();
        $data = array(
            array("codeSemestre"=>Str::random(20), "libelleSemestre"=> "1", "descriptionSemestre"=>"Semestre 1"),
            array("codeSemestre"=>Str::random(20), "libelleSemestre"=> "2", "descriptionSemestre"=>"Semestre 2")
        );

        foreach ($data as $s){
            Semestre::create($s);
        }
    }

    public function ue(){
        DB::table("ues")->truncate();
        $data = array(
            array("specialite_id"=> 1,"typeue_id"=>2,"semestre_id"=> 1,"codeUE"=> "AQC111","libelleUe"=>"Biologie","total"=>80,"credit"=>4,"cm"=>40,"td"=>20,"tp"=>10,"tpe"=>10),
            array("specialite_id"=> 1,"typeue_id"=>1,"semestre_id"=> 1,"codeUE"=> "AQC112","libelleUe"=>"Informatique","total"=>90,"credit"=>5,"cm"=>50,"td"=>20,"tp"=>10,"tpe"=>10),
            array("specialite_id"=> 1,"typeue_id"=>1,"semestre_id"=> 2,"codeUE"=> "AQC113","libelleUe"=>"Langue et expression francaise","total"=>60,"credit"=>3,"cm"=>40,"td"=>10,"tp"=>10,"tpe"=>10),
            array("specialite_id"=> 1,"typeue_id"=>2,"semestre_id"=> 2,"codeUE"=> "AQC114","libelleUe"=>"Eaux et environnement","total"=>120,"credit"=>6,"cm"=>70,"td"=>30,"tp"=>10,"tpe"=>10),
        );

        foreach($data as $d){
            Ue::create($d);
        }
    }

    public function matieres(){
        DB::table("matieres")->truncate();

        $data = [
            ["ue_id"=>1,"codeMatiere"=>"AQC111-1","libelleMatiere"=>"Biologie 1","descriptionMatiere"=>"Techniques de reporductions"],
            ["ue_id"=>1,"codeMatiere"=>"AQC111-2","libelleMatiere"=>"Eléments de zootechnie","descriptionMatiere"=>"Eléments de zootechnie"],
            ["ue_id"=>1,"codeMatiere"=>"AQC111-3","libelleMatiere"=>"Anatomie et physiologie animales","descriptionMatiere"=>"Anatomie et physiologie animales"],
            ["ue_id"=>2,"codeMatiere"=>"AQC112-1","libelleMatiere"=>"Informatique générale","descriptionMatiere"=>"Informatique générale"],
            ["ue_id"=>2,"codeMatiere"=>"AQC112-2","libelleMatiere"=>"Algorithmique","descriptionMatiere"=>"Algorithmique"],
            ["ue_id"=>3,"codeMatiere"=>"AQC113-1","libelleMatiere"=>"Expression française I","descriptionMatiere"=>"Expression française I"],
            ["ue_id"=>3,"codeMatiere"=>"AQC113-2","libelleMatiere"=>"Art oral","descriptionMatiere"=>"Art oral"],
            ["ue_id"=>4,"codeMatiere"=>"AQC114-1","libelleMatiere"=>"Traitement des eaux","descriptionMatiere"=>"Traitement des eaux"],
            ["ue_id"=>4,"codeMatiere"=>"AQC114-2","libelleMatiere"=>"Environement de production","descriptionMatiere"=>"Environement de production"],
        ];

        foreach ($data as $d){
            Matiere::create($d);
        }
    }

    public function cycle(){
        $data = array(
            array("codeCycle"=> "BTS", "titreCycle"=>Str::upper("Brevet de Technicien Supérieur")),
            array("codeCycle"=> "HND", "titreCycle"=>Str::upper("Higher National Diploma"))
        );

        foreach ($data as $d){
            Cycle::create($d);
        }
    }

    public function levels(){
        $data = array(
            array("codeLevel"=> Str::random(20), "numeroLevel"=>1),
            array("codeLevel"=> Str::random(20), "numeroLevel"=>2),
            array("codeLevel"=> Str::random(20), "numeroLevel"=>3),
            array("codeLevel"=> Str::random(20), "numeroLevel"=>4),
            array("codeLevel"=> Str::random(20), "numeroLevel"=>5),
        );

        foreach ($data as $d){
            Level::create($d);
        }
    }

    public function etudiants(){
        DB::table("anneeacademiques")->truncate();
        DB::table("parents")->truncate();
        DB::table("etudiants")->truncate();
        DB::table("dossieretudiants")->truncate();
        DB::table("inscriptions")->truncate();
        DB::table("parcours")->truncate();
        DB::table("choices")->truncate();
        DB::table("antecedants")->truncate();


        $anneeacademique = array(
            "codeAnnee" => Str::random(20),
            "numeroAnnee" => date("Y"),
            "active" => true,
        );

        $parents = array(
            "codeParent"=>Str::random(20),
            "fathername"=>"TETE",
            "fatherprofession"=>"Biologiste",
            "fathercontact"=>"000000001",
            "mothername"=>"TITI",
            "motherprofession"=>"Chimiste",
            "mothercontact"=>"000000002",
            "emergencyname"=>"TROTRO",
            "emergencycontact"=>"000000003",
        );

        $etudiant = array(
            "codeEtudiant"=>Str::random(20),
            "parent_id"=>1,
            "lastname"=>"TOTO",
            "firstname"=>"TATO",
            "sexe"=>"Masculin",
            "birthday"=>"2000-06-01",
            "birthplace"=>"Edea",
            "nationality"=>"Camerounaise",
            "region"=>"Littoral",
            "phonenumber"=>"000000005",
            "email"=>"demo@issat-cm.com",
            "language"=>"Français",
            "sport"=> "Basketball",
            "leisure"=> "Lecture, musique et jeux vidéos",
        );

        $dossier = array(
            "anneeacademique_id" => 1,
            "cycle_id" => 1,
            "etudiant_id" => 1,
            "codeDossier" => Str::random(20),
            "numeroDossier" => "0001/22",
            "matriculeDossier" => "2022ISSAT0001",
        );

        $inscription = array(
            "anneeacademique_id"=>1,
            "dossieretudiant_id"=>1,
            "level_id"=>1,
            "codeInscription"=>Str::random(20),
            "dateInscription"=>date("Y-m-d"),
            "divers"=>"ras",
        );

        $parcours = array(
            "dossieretudiant_id"=>1,
            "codeParcours"=>Str::random(20),
            "admissiondiploma"=>"Baccalaureat",
            "option"=> "TI",
            "schoolyear"=>"2021",
            "diplomacountry"=>"Cameroun",
            "schoolattended"=>"Lycée classique d'Edea",
        );

        $antecedents = array(
            "codeAntecedants"=>Str::random(20),
            "etudiant_id"=>1,
            "maladie"=>"Myopie",
            "dateconsultation"=>date("Y-m-d"),
            "etat"=>"ras",
        );

        $choix = array(
            array(
                "specialite_id"=>1,
                "inscription_id"=>1,
                "etat"=>0
            ),
            array(
                "specialite_id"=>2,
                "inscription_id"=>1,
                "etat"=>0
            ),
            array(
                "specialite_id"=>3,
                "inscription_id"=>1,
                "etat"=>0
            )
        );

        Anneeacademique::create($anneeacademique);
        Perent::create($parents);
        Etudiant::create($etudiant);
        Dossieretudiant::create($dossier);
        Inscription::create($inscription);
        Parcour::create($parcours);
        Antecedant::create($antecedents);

        foreach ($choix as $ch){
            Choice::create($ch);
        }
    }


}
