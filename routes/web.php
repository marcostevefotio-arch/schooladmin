<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::get('/maintenance', [App\Http\Controllers\HomeController::class, 'maintenance'])->name('maintenance');





Route::group(['menu'], function($routes){
    $routes->get("list-menu", [\App\Http\Controllers\UserController::class, 'index'])->name("menu");
    $routes->get("read-menu{slug}", [\App\Http\Controllers\UserController::class, 'edit'])->name("menuEdit");
    $routes->get("delete-menu{slug}", [\App\Http\Controllers\UserController::class, 'destroy'])->name("menuDelete");
    $routes->get("read-menu{slug}", [\App\Http\Controllers\UserController::class, 'show'])->name("menuShow");
    $routes->get("create-menu", [\App\Http\Controllers\UserController::class, 'create'])->name("menuCreate");
    $routes->post("store-menu", [\App\Http\Controllers\UserController::class, 'store'])->name("menuStore");
    $routes->post("update-menu{slug}", [\App\Http\Controllers\UserController::class, 'update'])->name("menuUpdate");
});


//GRH
Route::group(['personnel'], function($routes){
    $routes->get("list-personnel", [\App\Http\Controllers\PersonnelController::class, 'index'])->name("personnel");
    $routes->get("read-personnel{slug}", [\App\Http\Controllers\PersonnelController::class, 'edit'])->name("personnelEdit");
    $routes->get("delete-personnel{slug}", [\App\Http\Controllers\PersonnelController::class, 'destroy'])->name("personnelDelete");
    $routes->get("read-personnel{slug}", [\App\Http\Controllers\PersonnelController::class, 'show'])->name("personnelShow");
    $routes->get("create-personnel", [\App\Http\Controllers\PersonnelController::class, 'create'])->name("personnelCreate");
    $routes->post("store-personnel", [\App\Http\Controllers\PersonnelController::class, 'store'])->name("personnelStore");
    $routes->post("update-personnel{slug}", [\App\Http\Controllers\PersonnelController::class, 'update'])->name("personnelUpdate");
});

Route::group(['logs'], function($routes){
    $routes->get("list-logs", [\App\Http\Controllers\HistoriqueController::class, 'index'])->name("logs");
    $routes->get("list-logs{slug}", [\App\Http\Controllers\HistoriqueController::class, 'index'])->name("logsList");
    $routes->get("show-logs{slug}", [\App\Http\Controllers\HistoriqueController::class, 'show'])->name("logsShow");
});

Route::group(['etablissement'], function ($routes){
    $routes->get("etablissement", [\App\Http\Controllers\EtablissementController::class, 'index'])->name("etablissement");
    $routes->get("etablissement-edit{slug}", [\App\Http\Controllers\EtablissementController::class, 'edit'])->name("etablissementEdit");
    $routes->post("etablissement-update{slug}", [\App\Http\Controllers\EtablissementController::class, 'update'])->name("etablissementUpdate");
    $routes->get("parametre-edit{slug}", [\App\Http\Controllers\EtablissementController::class, 'paramEdit'])->name("parametreEdit");
    $routes->post("parametre-update{slug}", [\App\Http\Controllers\EtablissementController::class, 'paramUpdate'])->name("parametreUpdate");
    $routes->post("logo", [\App\Http\Controllers\EtablissementController::class, 'logochange'])->name("logoChange");
});



Route::group(['classe'], function ($routes){
    $routes->get("classe", [\App\Http\Controllers\ClasseController::class, 'index'])->name("classe");
    $routes->get("classe-form", [\App\Http\Controllers\ClasseController::class, 'create'])->name("classeForm");
    $routes->get("classe-edit{slug}", [\App\Http\Controllers\ClasseController::class, 'edit'])->name("classeEdit");
    $routes->get("classe-delete{slug}", [\App\Http\Controllers\ClasseController::class, 'destroy'])->name("classeDelete");
    $routes->post("classe-store", [\App\Http\Controllers\ClasseController::class, 'store'])->name("classeStore");
    $routes->post("classe-update{slug}", [\App\Http\Controllers\ClasseController::class, 'update'])->name("classeUpdate");
});


Route::group(['bulletins'], function ($routes){
    $routes->get("bulletins-all", [\App\Http\Controllers\BulletinController::class, 'viewAll'])->name("allBulletin");
    $routes->get("bulletins-view{slug}", [\App\Http\Controllers\BulletinController::class, 'viewAonce'])->name("bulletin");
    $routes->get("bulletins-model", [\App\Http\Controllers\BulletinController::class, 'viewModel'])->name("bulletinModel");

});




//myspace
Route::group(["myspace"], function($routes){
    $routes->get("mon-espace", [\App\Http\Controllers\WorkspaceController::class, "index"])->name("myspace");
    //etudiants
    $routes->get("mon-emploie-de-temps{slug}", [\App\Http\Controllers\WorkspaceController::class, "planing"])->name("mplaning");
    $routes->get("ma-discipline{slug}", [\App\Http\Controllers\WorkspaceController::class, "discipline"])->name("mdiscipline");
    $routes->get("mes-evaluations{slug}", [\App\Http\Controllers\WorkspaceController::class, "evaluation"])->name("mevaluation");
    $routes->get("mes-notes{slug}", [\App\Http\Controllers\WorkspaceController::class, "note"])->name("mnote");
    //enseignants
    $routes->get("emploie-de-temps{slug}", [\App\Http\Controllers\WorkspaceController::class, "tplaning"])->name("tplaning");
    $routes->get("evaluations{slug}", [\App\Http\Controllers\WorkspaceController::class, "tevaluation"])->name("tevaluation");
    $routes->get("make-evaluations", [\App\Http\Controllers\WorkspaceController::class, "makeEvaluation"])->name("makeEvaluation");
    $routes->post("store-evaluations", [\App\Http\Controllers\WorkspaceController::class, "storeEvaluation"])->name("storeEvaluation");
    $routes->get("make-epreuve", [\App\Http\Controllers\WorkspaceController::class, "epreuve"])->name("epreuve");
    $routes->post("store-epreuve", [\App\Http\Controllers\WorkspaceController::class, "storeEpeuvre"])->name("storeEpreuve");
    $routes->get("run-evaluations{slug}", [\App\Http\Controllers\WorkspaceController::class, "runEvaluation"])->name("runEvaluation");
});



Route::get("/print-sort/{item}", [App\Http\Controllers\EtudiantController::class, "listOfStudent"])->name("printSort");
Route::get("/print-sort-enseignants/{item}", [App\Http\Controllers\EnseignantController::class, "listOfTeacher"])->name("printSortTeacher");





//Modules
Route::group(["gestion"], function($routes){
    $routes->get("gestion-inscription", [\App\Http\Controllers\NavigationController::class, "inscription"])->name("homeinscription");
    $routes->get("gestion-etudiant", [\App\Http\Controllers\NavigationController::class, "etudiants"])->name("homeetudiant");
    $routes->get("gestion-filiere", [\App\Http\Controllers\NavigationController::class, "filiere"])->name("homefiliere");
    $routes->get("gestion-scolarite", [\App\Http\Controllers\NavigationController::class, "scolarite"])->name("homescolarite");
    $routes->get("gestion-notes", [\App\Http\Controllers\NavigationController::class, "notes"])->name("homenote");
    $routes->get("gestion-planings", [\App\Http\Controllers\NavigationController::class, "planing"])->name("homeplaning");
    $routes->get("gestion-enseignant", [\App\Http\Controllers\NavigationController::class, "enseignant"])->name("homeenseignant");
    $routes->get("gestion-organisation", [\App\Http\Controllers\NavigationController::class, "organisation"])->name("homeorganisation");
    $routes->get("gestion-securite", [\App\Http\Controllers\NavigationController::class, "securite"])->name("homesecurite");
    $routes->get("gestion-parametres", [\App\Http\Controllers\NavigationController::class, "settings"])->name("homesettings");
});



//Inscriptions
Route::group(["g-inscription"], function($routes){
    $routes->get("inscriptions-list{slug?}", [\App\Http\Controllers\InscriptionController::class, 'index'])->name("inscriptions-list");
    $routes->get("inscriptions-list-online{slug?}", [\App\Http\Controllers\InscriptionController::class, 'index'])->name("preinscription");
    $routes->get("annee-list", [\App\Http\Controllers\AnneeacademiqueController::class, 'index'])->name("inscriptions-annee");
    $routes->get("annee-close{slug}", [\App\Http\Controllers\AnneeacademiqueController::class, 'cloturer'])->name("close-annee");
    $routes->post("annee-start", [\App\Http\Controllers\AnneeacademiqueController::class, 'store'])->name("start-annee");
    $routes->get("inscriptions-fiche", [\App\Http\Controllers\InscriptionController::class, 'printFile'])->name("inscription-fiche");
    
    $routes->get("inscriptions-certificat", [\App\Http\Controllers\InscriptionController::class, 'CertificatPrintFile'])->name("inscription-certificat");
    
    $routes->get("inscriptions-etat", [\App\Http\Controllers\InscriptionController::class, 'states'])->name("inscription-etat");
//    $routes->get("inscriptions-etat", [\App\Http\Controllers\InscriptionController::class, 'states'])->name("inscription-etat");
});

Route::group(['inscriptions'], function ($routes){
    $routes->get("inscriptions", [\App\Http\Controllers\InscriptionController::class, 'index'])->name("inscription");
    $routes->get("inscriptions-form", [\App\Http\Controllers\InscriptionController::class, 'create'])->name("inscriptionForm");
    $routes->post("inscriptions-store", [\App\Http\Controllers\InscriptionController::class, 'store'])->name("inscriptionStore");
    $routes->get("inscriptions-show{slug}", [\App\Http\Controllers\InscriptionController::class, 'show'])->name("inscriptionShow");
    $routes->get("inscriptions-delete{slug}", [\App\Http\Controllers\InscriptionController::class, 'destroy'])->name("inscriptionDelete");
    $routes->get("inscriptions-edit/{slug}", [\App\Http\Controllers\InscriptionController::class, 'edit'])->name("inscriptionEdit");
    $routes->post("inscriptions-update/{slug}", [\App\Http\Controllers\InscriptionController::class, 'update'])->name("inscriptionUpdate");
    $routes->get("inscriptions-print/{slug?}", [\App\Http\Controllers\InscriptionController::class, 'printFile'])->name("inscriptionPrint");
    
    $routes->get("print-certificat/{slug?}", [\App\Http\Controllers\InscriptionController::class, 'CertificatPrintFile'])->name("inscriptionPrintCertificat");
    
    $routes->get("inscriptions-choix{choix}", [\App\Http\Controllers\InscriptionController::class, 'validerChoix'])->name("inscriptionChoix");
    $routes->get("inscriptions-frais{slug}", [\App\Http\Controllers\InscriptionController::class, 'updateFrais'])->name("inscriptionFrais");
    $routes->post("inscriptions-effectifs-general", [\App\Http\Controllers\InscriptionController::class, 'allEffectifFilieres'])->name("inscriptionEffectifGeneral");
    $routes->post("inscriptions-effectifs", [\App\Http\Controllers\InscriptionController::class, 'effectifs'])->name("inscriptionEffectif");
    $routes->post("inscriptions-new", [\App\Http\Controllers\InscriptionController::class, 'newInscription'])->name("inscriptionNewInscription");
    $routes->post("inscriptions-new-store", [\App\Http\Controllers\InscriptionController::class, 'newInscriptionStore'])->name("inscriptionNewInscriptionStore");
    $routes->get("inscriptions-only-delete{slug}", [\App\Http\Controllers\InscriptionController::class, 'destroyInscription'])->name("inscriptionOnlyDelete");


    $routes->get("etudiant-cartes-{slug}", [\App\Http\Controllers\EtudiantController::class, "imprimerCarte"])->name("carte");
    $routes->get("etudiant-biblio-{slug}", [\App\Http\Controllers\EtudiantController::class, 'imprimerBibliotheque'])->name("carte2");
});





//Etudiants
Route::group(["g-etudiants"], function($routes){
    $routes->get("etudiant", [\App\Http\Controllers\EtudiantController::class, 'index'])->name("etudiant-effectifs");
    $routes->get("etudiant-discipline", [\App\Http\Controllers\DisciplineetudiantController::class, 'index'])->name("etudiant-discipline");
    $routes->get("etudiant-demission", [\App\Http\Controllers\EtudiantController::class, 'demission'])->name("etudiant-demissions");
    $routes->get("etudiant-notes", [\App\Http\Controllers\EtudiantController::class, 'notes'])->name("etudiant-notes");
    $routes->get("etudiant-releve", [\App\Http\Controllers\EtudiantController::class, 'releve'])->name("etudiant-releve");
    $routes->post("etudiant-avatar", [\App\Http\Controllers\EtudiantController::class, 'avatarChange'])->name("etudiantAvatar");
    $routes->get("etudiant-carte", [\App\Http\Controllers\EtudiantController::class, 'carte'])->name("etudiant-carte");
    $routes->post("etudiant-carte-print", [\App\Http\Controllers\EtudiantController::class, 'cartePrint'])->name("etudiant-carte-print");
});

Route::group(['etudiants'], function ($routes){
    $routes->get("etudiant-list", [\App\Http\Controllers\EtudiantController::class, 'index'])->name("etudiant");
    $routes->get("etudiant-filter{slug}", [\App\Http\Controllers\EtudiantController::class, 'index'])->name("etudiantFilter");
    $routes->get("etudiant-form", [\App\Http\Controllers\EtudiantController::class, 'create'])->name("etudiantForm");
    $routes->get("etudiant-show{slug}", [\App\Http\Controllers\EtudiantController::class, 'show'])->name("etudiantShow");
    $routes->get("etudiant-show-online{slug}", [\App\Http\Controllers\EtudiantController::class, 'showOnline'])->name("etudiantShowOnline");
    $routes->get("etudiant-edit{slug}", [\App\Http\Controllers\EtudiantController::class, 'edit'])->name("etudiantEdit");
    $routes->get("etudiant-delete{slug}", [\App\Http\Controllers\EtudiantController::class, 'destroy'])->name("etudiantDelete");
    $routes->post("etudiant-store", [\App\Http\Controllers\EtudiantController::class, 'store'])->name("etudiantStore");
    $routes->post("etudiant-update{slug}", [\App\Http\Controllers\EtudiantController::class, 'update'])->name("etudiantUpdate");
    $routes->post("etudiant-ajax-list", [\App\Http\Controllers\EtudiantController::class, 'AjaxStudentList'])->name("etudiantAjaxList");
    $routes->post("etudiant-ajax-list-get", [\App\Http\Controllers\EtudiantController::class, 'AjaxStudentList2'])->name("etudiantAjaxList2");
});

Route::group(['discipline'], function ($routes){
    $routes->get("discipline-etudiant", [\App\Http\Controllers\DisciplineetudiantController::class, 'index'])->name("disciplineetudiant");
    $routes->get("discipline-etudiant-read-{slug}", [\App\Http\Controllers\DisciplineetudiantController::class, 'show'])->name("disciplineETShow");
    $routes->get("discipline-etudiant-edit-{slug}", [\App\Http\Controllers\DisciplineetudiantController::class, 'edit'])->name("disciplineETEdit");
    $routes->get("discipline-etudiant-delete-{slug}", [\App\Http\Controllers\DisciplineetudiantController::class, 'destroy'])->name("disciplineETDelete");
    $routes->get("discipline-etudiant-create", [\App\Http\Controllers\DisciplineetudiantController::class, 'create'])->name("disciplineETCreate");
    $routes->post("discipline-etudiant-store", [\App\Http\Controllers\DisciplineetudiantController::class, 'store'])->name("disciplineETStore");
});

Route::group(['demande'], function ($routes){
    $routes->get("demande", [\App\Http\Controllers\DisciplineetudiantController::class, 'demande'])->name("demande");
    $routes->get("demande-create", [\App\Http\Controllers\DisciplineetudiantController::class, 'demande_create'])->name("demandeCreate");
    $routes->get("demande-print{slug}", [\App\Http\Controllers\DisciplineetudiantController::class, 'demande_print'])->name("demandePrint");
    $routes->get("demande-read{slug}", [\App\Http\Controllers\DisciplineetudiantController::class, 'demande_show'])->name("demandeShow");
    $routes->get("demande-delete{slug}", [\App\Http\Controllers\DisciplineetudiantController::class, 'demande_delete'])->name("demandeDelete");
    $routes->post("demande-store", [\App\Http\Controllers\DisciplineetudiantController::class, 'demande_store'])->name("demandeStore");
});





//Scolarite
Route::group(["g-scolarite"], function($routes){
    $routes->get("verssement", [\App\Http\Controllers\VerssementController::class, 'index'])->name("scolarite-versement");
    $routes->get("solvabilite", [\App\Http\Controllers\VerssementController::class, 'solvabilite'])->name("scolarite-solvabilite");
    $routes->get("configuration", [\App\Http\Controllers\ScolariteController::class, 'index'])->name("scolarite-configuration");
    $routes->get("compte", [\App\Http\Controllers\CompteController::class, 'index'])->name("scolarite-compte");
});

Route::group(['verssement'], function ($routes){
    $routes->get("verssement-list/{slug?}", [\App\Http\Controllers\VerssementController::class, 'index'])->name("verssement");
    $routes->get("verssement-create", [\App\Http\Controllers\VerssementController::class, 'create'])->name("verssementCreate");
    $routes->get("verssement-print", [\App\Http\Controllers\VerssementController::class, 'printEtat'])->name("verssementPrint");
    $routes->get("verssement-read{slug}", [\App\Http\Controllers\VerssementController::class, 'show'])->name("verssementShow");
    $routes->get("verssement-print/{slug}", [\App\Http\Controllers\VerssementController::class, 'receipt'])->name("verssementReceipt");
    $routes->get("verssement-edit{slug}", [\App\Http\Controllers\VerssementController::class, 'edit'])->name("verssementEdit");
    $routes->get("verssement-delete{slug}", [\App\Http\Controllers\VerssementController::class, 'delete'])->name("verssementDelete");
    $routes->post("verssement-store", [\App\Http\Controllers\VerssementController::class, 'store'])->name("verssementStore");
    $routes->post("verssement-update{slug}", [\App\Http\Controllers\VerssementController::class, 'update'])->name("verssementUpdate");
    $routes->post("solvabilite-print", [\App\Http\Controllers\VerssementController::class, 'solvabilitePrint'])->name("solvabilitePrint");
    $routes->post("verssement-print-pdf", [\App\Http\Controllers\VerssementController::class, 'etatVerssements'])->name("verssementPrintPDF");
});

Route::group(['scolarite'], function ($routes){
    $routes->get("scolarite-list", [\App\Http\Controllers\ScolariteController::class, 'index'])->name("scolarite");
    $routes->get("scolarite-list-ajax", [\App\Http\Controllers\ScolariteController::class, 'listAjax'])->name("scolariteAjax");
    $routes->get("scolarite-create", [\App\Http\Controllers\ScolariteController::class, 'create'])->name("scolariteCreate");
    $routes->get("scolarite-print", [\App\Http\Controllers\ScolariteController::class, 'ficheScolarite'])->name("scolaritePrint");
    $routes->get("scolarite-read{slug}", [\App\Http\Controllers\ScolariteController::class, 'show'])->name("scolariteShow");
    $routes->get("scolarite-edit{slug}", [\App\Http\Controllers\ScolariteController::class, 'edit'])->name("scolariteEdit");
    $routes->get("scolarite-delete{slug}", [\App\Http\Controllers\ScolariteController::class, 'destroy'])->name("scolariteDelete");
    $routes->post("scolarite-store", [\App\Http\Controllers\ScolariteController::class, 'store'])->name("scolariteStore");
    $routes->post("scolarite-update{slug}", [\App\Http\Controllers\ScolariteController::class, 'update'])->name("scolariteUpdate");
    $routes->post("scolarite-print-action", [\App\Http\Controllers\ScolariteController::class, 'printFicheScolarite'])->name("scolaritePrintAction");
});

Route::group(['compte'], function ($routes){
    $routes->get("compte-list", [\App\Http\Controllers\CompteController::class, 'index'])->name("compte");
    $routes->get("compte-create", [\App\Http\Controllers\CompteController::class, 'create'])->name("compteCreate");
    $routes->get("compte-print{slug}", [\App\Http\Controllers\CompteController::class, 'print'])->name("comptePrint");
    $routes->get("compte-read{slug}", [\App\Http\Controllers\CompteController::class, 'show'])->name("compteShow");
    $routes->get("compte-edit{slug}", [\App\Http\Controllers\CompteController::class, 'edit'])->name("compteEdit");
    $routes->get("compte-delete{slug}", [\App\Http\Controllers\CompteController::class, 'delete'])->name("compteDelete");
    $routes->post("compte-store", [\App\Http\Controllers\CompteController::class, 'store'])->name("compteStore");
    $routes->post("compte-update{slug}", [\App\Http\Controllers\CompteController::class, 'update'])->name("compteUpdate");
});


//Notes
Route::group(["g-notes"], function($routes){
    $routes->get("notes-list", [\App\Http\Controllers\NoteController::class, 'index'])->name("note-list");
    $routes->get("evaluation", [\App\Http\Controllers\NoteController::class, 'index'])->name("note-evaluation");
    $routes->get("pv-semestre", [\App\Http\Controllers\NoteController::class, 'pvSemestre'])->name("note-pv");
    $routes->get("genpdf-pv", [\App\Http\Controllers\NoteController::class, 'pv'])->name("note-pv-gen");
    $routes->get("notes-releve", [\App\Http\Controllers\NoteController::class, 'releveSemestre'])->name("note-releve");
    $routes->get("genpdf-releve", [\App\Http\Controllers\NoteController::class, 'releve'])->name("note-releve-gen");
});

Route::group(['noteevaluation'], function ($routes){
    $routes->get("notes", [\App\Http\Controllers\NoteController::class, 'index'])->name("notes");
    $routes->get("notes-form", [\App\Http\Controllers\NoteController::class, 'create'])->name("notesForm");
    $routes->get("notes-show{slug}", [\App\Http\Controllers\NoteController::class, 'show'])->name("notesShow");
    $routes->get("notes-edit{slug}", [\App\Http\Controllers\NoteController::class, 'edit'])->name("notesEdit");
    $routes->get("notes-delete{slug}", [\App\Http\Controllers\NoteController::class, 'destroy'])->name("notesDelete");
    $routes->post("notes-store", [\App\Http\Controllers\NoteController::class, 'store'])->name("notesStore");
    $routes->post("notes-update{slug}", [\App\Http\Controllers\NoteController::class, 'update'])->name("notesUpdate");
    $routes->get("notes-options", [\App\Http\Controllers\NoteController::class, 'notesOptions'])->name("notesOptions");
    $routes->get("notes-bulletin", [\App\Http\Controllers\NoteController::class, 'bulletin'])->name("notesBulletin");
    $routes->post("getMatieres", [\App\Http\Controllers\NoteController::class, 'getMatieres'])->name("getMatieres");
});







Route::group(["g-planings"], function($routes){
    $routes->get("programmes", [\App\Http\Controllers\TimelineController::class, 'index'])->name("planing-programme");
    $routes->get("planing-cours", [\App\Http\Controllers\TimelineController::class, 'index'])->name("planing-cours");
    $routes->get("evolution", [\App\Http\Controllers\TimelineController::class, 'index'])->name("planing-etat");
    $routes->get("salles", [\App\Http\Controllers\TimelineController::class, 'index'])->name("salle-list");
});

Route::group(["g-annee"], function($routes){
    $routes->get("annee-academique", [\App\Http\Controllers\AnneeacademiqueController::class, 'create'])->name("annee-academique");
});



//securite
Route::group(["g-securite"], function($routes){
    $routes->get("groupes", [\App\Http\Controllers\GroupeController::class, 'index'])->name("securite-groupe");
    $routes->get("utilisateurs", [\App\Http\Controllers\UserController::class, 'index'])->name("securite-user");
    $routes->get("historiques", [\App\Http\Controllers\HistoriqueController::class, 'index'])->name("securite-historique");
});

Route::group(['groupe'], function($routes){
    $routes->get("list-groupe", [\App\Http\Controllers\GroupeController::class, 'index'])->name("groupe");
    $routes->get("read-groupe{slug}", [\App\Http\Controllers\GroupeController::class, 'edit'])->name("groupeEdit");
    $routes->get("delete-groupe{slug}", [\App\Http\Controllers\GroupeController::class, 'destroy'])->name("groupeDelete");
    $routes->get("show-groupe{slug}", [\App\Http\Controllers\GroupeController::class, 'show'])->name("groupeShow");
    $routes->get("create-groupe", [\App\Http\Controllers\GroupeController::class, 'create'])->name("groupeCreate");
    $routes->post("store-groupe", [\App\Http\Controllers\GroupeController::class, 'store'])->name("groupeStore");
    $routes->post("update-groupe{slug}", [\App\Http\Controllers\GroupeController::class, 'update'])->name("groupeUpdate");
});


Route::group(['user'], function($routes){
    $routes->get("list-user", [\App\Http\Controllers\UserController::class, 'index'])->name("user");
    $routes->get("read-user{slug}", [\App\Http\Controllers\UserController::class, 'show'])->name("userShow");
    $routes->get("edit-user{slug}", [\App\Http\Controllers\UserController::class, 'edit'])->name("userEdit");
    $routes->get("delete-user{slug}", [\App\Http\Controllers\UserController::class, 'destroy'])->name("userDelete");
    $routes->get("create-user", [\App\Http\Controllers\UserController::class, 'create'])->name("userCreate");
    $routes->post("store-user", [\App\Http\Controllers\UserController::class, 'store'])->name("userStore");
    $routes->post("update-user{slug}", [\App\Http\Controllers\UserController::class, 'update'])->name("userUpdate");
    $routes->get("reset-user{slug}", [\App\Http\Controllers\UserController::class, 'resetAccountPassword'])->name("userReset");
    $routes->get("active-user{slug}", [\App\Http\Controllers\UserController::class, 'activeAccount'])->name("userActive");
    $routes->get("profile-user{slug}", [\App\Http\Controllers\UserController::class, 'profile'])->name("userProfile");
    $routes->post("avatar-user", [\App\Http\Controllers\UserController::class, 'avatar'])->name("userAvatar");
    $routes->get("password-edit-{slug}", [\App\Http\Controllers\UserController::class, 'changePassword'])->name("passwordEdit");
    $routes->post("password-update-{slug}", [\App\Http\Controllers\UserController::class, 'changePasswordUpdate'])->name("passwordUpdate");
});







//Organisation
Route::group(["g-organisation"], function($routes){
    $routes->get("organisations", [\App\Http\Controllers\OrganigrammeController::class, 'index'])->name("organisation-list");
});

Route::group(['organigramme'], function($routes){
    $routes->get("organigramme-list", [App\Http\Controllers\OrganigrammeController::class, 'index'])->name('organigramme');
    $routes->get("organigramme-view/{slug}", [App\Http\Controllers\OrganigrammeController::class, 'show'])->name('organisationshow');
    $routes->get("organigramme-edit/{slug}", [App\Http\Controllers\OrganigrammeController::class, 'edit'])->name('organisationEdit');
    $routes->get("organigramme-delete/{slug}", [App\Http\Controllers\OrganigrammeController::class, 'destroy'])->name('organisationDelete');
    $routes->get("organisationcreate", [App\Http\Controllers\OrganigrammeController::class, 'create'])->name('organisationcreate');
    $routes->post("organisationstore", [App\Http\Controllers\OrganigrammeController::class, 'store'])->name('organisationstore');
    $routes->post("organisation-update/{slug}", [App\Http\Controllers\OrganigrammeController::class, 'update'])->name('organisationUpdate');
    $routes->get("ajaxorganisation", [App\Http\Controllers\OrganigrammeController::class, 'organisationList'])->name('ajaxorganisation');
});





//Filieres et spécialités
Route::group(["g-filiere"], function($routes){
    $routes->get("filiere", [\App\Http\Controllers\FiliereController::class, 'index'])->name("filiere-list");
    $routes->get("filiere-specialite", [\App\Http\Controllers\SpecialiteController::class, 'index'])->name("filiere-specialite");
    $routes->get("filiere-ue", [\App\Http\Controllers\UeController::class, 'index'])->name("filiere-ue");
    $routes->get("filiere-ec", [\App\Http\Controllers\MatiereController::class, 'index'])->name("filiere-ec");
    $routes->get("filiere-cours", [\App\Http\Controllers\CourController::class, 'index'])->name("filiere-cours");
    $routes->get("filiere-syllabus", [\App\Http\Controllers\SyllabusController::class, 'index'])->name("filiere-syllabus");
});

Route::group(['filiere'], function ($routes){
    $routes->get("filiere-list", [\App\Http\Controllers\FiliereController::class, 'index'])->name("filiere");
    $routes->get("filiere-json", [\App\Http\Controllers\FiliereController::class, 'getSpecialite'])->name("filiereJson");
    $routes->get("filiere-form", [\App\Http\Controllers\FiliereController::class, 'create'])->name("filiereForm");
    $routes->get("filiere-edit{slug}", [\App\Http\Controllers\FiliereController::class, 'edit'])->name("filiereEdit");
    $routes->get("filiere-delete{slug}", [\App\Http\Controllers\FiliereController::class, 'destroy'])->name("filiereDelete");
    $routes->post("filiere-store", [\App\Http\Controllers\FiliereController::class, 'store'])->name("filiereStore");
    $routes->post("filiere-update{slug}", [\App\Http\Controllers\FiliereController::class, 'update'])->name("filiereUpdate");
});

Route::group(['specialite'], function ($routes){
    $routes->get("specialite", [\App\Http\Controllers\SpecialiteController::class, 'index'])->name("specialite");
    $routes->get("specialite-form", [\App\Http\Controllers\SpecialiteController::class, 'create'])->name("specialiteForm");
    $routes->get("specialite-edit{slug}", [\App\Http\Controllers\SpecialiteController::class, 'edit'])->name("specialiteEdit");
    $routes->get("specialite-delete{slug}", [\App\Http\Controllers\SpecialiteController::class, 'destroy'])->name("specialiteDelete");
    $routes->post("specialite-store", [\App\Http\Controllers\SpecialiteController::class, 'store'])->name("specialiteStore");
    $routes->post("specialite-update{slug}", [\App\Http\Controllers\SpecialiteController::class, 'update'])->name("specialiteUpdate");
});

Route::group(['ue'], function ($routes){
    $routes->get("ue", [\App\Http\Controllers\UeController::class, 'index'])->name("ue");
    $routes->get("ue-form", [\App\Http\Controllers\UeController::class, 'create'])->name("ueForm");
    $routes->get("ue-edit{slug}", [\App\Http\Controllers\UeController::class, 'edit'])->name("ueEdit");
    $routes->get("ue-delete{slug}", [\App\Http\Controllers\UeController::class, 'destroy'])->name("ueDelete");
    $routes->post("ue-store", [\App\Http\Controllers\UeController::class, 'store'])->name("ueStore");
    $routes->post("ue-update{slug}", [\App\Http\Controllers\UeController::class, 'update'])->name("ueUpdate");
});

Route::group(['matiere'], function ($routes){
    $routes->get("matiere", [\App\Http\Controllers\MatiereController::class, 'index'])->name("matiere");
    $routes->get("matiere-form", [\App\Http\Controllers\MatiereController::class, 'create'])->name("matiereForm");
    $routes->get("matiere-show{slug}", [\App\Http\Controllers\MatiereController::class, 'show'])->name("matiereShow");
    $routes->get("matiere-edit{slug}", [\App\Http\Controllers\MatiereController::class, 'edit'])->name("matiereEdit");
    $routes->get("matiere-delete{slug}", [\App\Http\Controllers\MatiereController::class, 'destroy'])->name("matiereDelete");
    $routes->post("matiere-store", [\App\Http\Controllers\MatiereController::class, 'store'])->name("matiereStore");
    $routes->post("matiere-update{slug}", [\App\Http\Controllers\MatiereController::class, 'update'])->name("matiereUpdate");
    $routes->post("matiere-ajax", [\App\Http\Controllers\MatiereController::class, 'ajaxJsonMatieres'])->name("matiereAjax");
});

Route::group(['syllabus'], function ($routes){
    $routes->get("syllabus", [\App\Http\Controllers\SyllabusController::class, 'index'])->name("syllabus");
    $routes->get("syllabus-form", [\App\Http\Controllers\SyllabusController::class, 'create'])->name("syllabusForm");
    $routes->get("syllabus-show{slug}", [\App\Http\Controllers\SyllabusController::class, 'show'])->name("syllabusShow");
    $routes->get("syllabus-edit{slug}", [\App\Http\Controllers\SyllabusController::class, 'edit'])->name("syllabusEdit");
    $routes->get("syllabus-delete{slug}", [\App\Http\Controllers\SyllabusController::class, 'destroy'])->name("syllabusDelete");
    $routes->get("syllabus-delete-once{slug}", [\App\Http\Controllers\SyllabusController::class, 'destroyOnce'])->name("syllabusDeleteOnce");
    $routes->post("syllabus-store", [\App\Http\Controllers\SyllabusController::class, 'store'])->name("syllabusStore");
    $routes->post("syllabus-update{slug}", [\App\Http\Controllers\SyllabusController::class, 'update'])->name("syllabusUpdate");
    $routes->post("syllabus-ajax", [\App\Http\Controllers\SyllabusController::class, 'ajaxJsonSyllabus'])->name("syllabusAjax");
});






//Enseignants
Route::group(["g-enseignant"], function($routes){
    $routes->get("enseignants-list", [\App\Http\Controllers\EnseignantController::class, 'index'])->name("enseignant-list");
    $routes->get("enseignants-matieres", [\App\Http\Controllers\EnseignantmatiereController::class, 'index'])->name("enseignant-matiere");
    $routes->get("enseignants-discipline", [\App\Http\Controllers\DisciplineenseignantController::class, 'index'])->name("enseignant-discipline");
    $routes->get("enseignants-cours", [\App\Http\Controllers\CourController::class, 'index'])->name("enseignant-cours");
});

Route::group(['enseignant'], function ($routes){
    $routes->get("enseignant", [\App\Http\Controllers\EnseignantController::class, 'index'])->name("enseignant");
    $routes->get("enseignant-form", [\App\Http\Controllers\EnseignantController::class, 'create'])->name("enseignantForm");
    $routes->get("enseignant-show{slug}", [\App\Http\Controllers\EnseignantController::class, 'show'])->name("enseignantShow");
    $routes->get("enseignant-edit{slug}", [\App\Http\Controllers\EnseignantController::class, 'edit'])->name("enseignantEdit");
    $routes->get("enseignant-delete{slug}", [\App\Http\Controllers\EnseignantController::class, 'destroy'])->name("enseignantDelete");
    $routes->post("enseignant-store", [\App\Http\Controllers\EnseignantController::class, 'store'])->name("enseignantStore");
    $routes->post("enseignant-update{slug}", [\App\Http\Controllers\EnseignantController::class, 'update'])->name("enseignantUpdate");
    $routes->post("disponibilite-update", [\App\Http\Controllers\EnseignantController::class, 'disponibilite'])->name("enseignantDisponibilite");
});

Route::group(['enseignant-matieres'], function ($routes){
    $routes->get("enseignant-matiere", [\App\Http\Controllers\EnseignantmatiereController::class, 'index'])->name("em");
    $routes->get("enseignant-matiere-create", [\App\Http\Controllers\EnseignantmatiereController::class, 'create'])->name("emForm");
    $routes->get("enseignant-matiere-show{slug}", [\App\Http\Controllers\EnseignantmatiereController::class, 'show'])->name("emShow");
    $routes->get("enseignant-matiere-edit{slug}", [\App\Http\Controllers\EnseignantmatiereController::class, 'edit'])->name("emEdit");
    $routes->get("enseignant-matiere-delete{slug}", [\App\Http\Controllers\EnseignantmatiereController::class, 'destroy'])->name("emDelete");
    $routes->post("enseignant-matiere-store", [\App\Http\Controllers\EnseignantmatiereController::class, 'store'])->name("emStore");
    $routes->post("enseignant-matiere-update{slug}", [\App\Http\Controllers\EnseignantmatiereController::class, 'update'])->name("emUpdate");
});

Route::group(['enseignant-discipline'], function ($routes){
    $routes->get("enseignant-discipline", [\App\Http\Controllers\DisciplineenseignantController::class, 'index'])->name("enseignantDiscipline");
    $routes->get("enseignant-discipline-create", [\App\Http\Controllers\DisciplineenseignantController::class, 'create'])->name("enseignantDisciplineForm");
    $routes->get("enseignant-discipline-show{slug}", [\App\Http\Controllers\DisciplineenseignantController::class, 'show'])->name("enseignantDisciplineShow");
    $routes->get("enseignant-discipline-edit{slug}", [\App\Http\Controllers\DisciplineenseignantController::class, 'edit'])->name("enseignantDisciplineEdit");
    $routes->get("enseignant-discipline-delete{slug}", [\App\Http\Controllers\DisciplineenseignantController::class, 'destroy'])->name("enseignantDisciplineDelete");
    $routes->post("enseignant-discipline-store", [\App\Http\Controllers\DisciplineenseignantController::class, 'store'])->name("enseignantDisciplineStore");
    $routes->post("enseignant-discipline-update{slug}", [\App\Http\Controllers\DisciplineenseignantController::class, 'update'])->name("enseignantDisciplineUpdate");
});

Route::group(["cours"], function($routes){
    $routes->get("cours", [App\Http\Controllers\CourController::class, "index"])->name("cours");
    $routes->get("cours-show/{slug}", [App\Http\Controllers\CourController::class, "show"])->name("programmeShow");
    $routes->get("cours-create", [App\Http\Controllers\CourController::class, "create"])->name("newCours");
    $routes->post("cours-store", [App\Http\Controllers\CourController::class, "store"])->name("coursStore");
    $routes->get("cours-edit/{slug}/{cours}", [App\Http\Controllers\CourController::class, "edit"])->name("coursEdit");
    $routes->post("cours-update/{slug}", [App\Http\Controllers\CourController::class, "update"])->name("coursUpdate");
    $routes->get("cours-delete/{slug}", [App\Http\Controllers\CourController::class, "destroy"])->name("coursDelete");
});

Route::group(["programme"], function($routes){
    $routes->get("programme", [App\Http\Controllers\TimelineController::class, "index"])->name("programme");
    $routes->get("programme-show{slug}", [App\Http\Controllers\TimelineController::class, "show"])->name("programmeShow2");
    $routes->get("cours{slug}", [App\Http\Controllers\CourController::class, "create"])->name("newCours2");
    $routes->post("cours-store", [App\Http\Controllers\CourController::class, "store"])->name("coursStore2");
    $routes->get("cours-edit/{spe}/{slug}", [App\Http\Controllers\CourController::class, "edit"])->name("coursEdit2");
    $routes->post("cours-update{slug}", [App\Http\Controllers\CourController::class, "update"])->name("coursUpdate2");
    $routes->get("cours-delete{slug}", [App\Http\Controllers\CourController::class, "destroy"])->name("coursDelete2");
});

//Application
Route::group(["application"], function($routes){
    $routes->get("parametres", [\App\Http\Controllers\EtablissementController::class, 'index'])->name("organisation-parametre");
});



//Pays
Route::group(["pays"], function($routes){
    $routes->get("pays-liste", [\App\Http\Controllers\PaysController::class, 'index'])->name("pays-list");
    $routes->get("pays-create", [\App\Http\Controllers\PaysController::class, 'create'])->name("paysCreate");
    $routes->get("pays-read/{slug}", [\App\Http\Controllers\PaysController::class, 'read'])->name("paysRead");
    $routes->get("pays-edit/{slug}", [\App\Http\Controllers\PaysController::class, 'edit'])->name("paysEdit");
    $routes->get("pays-delete/{slug}", [\App\Http\Controllers\PaysController::class, 'destroy'])->name("paysDelete");
    $routes->post("pays-store", [\App\Http\Controllers\PaysController::class, 'store'])->name("paysStore");
    $routes->post("pays-store/{slug}", [\App\Http\Controllers\PaysController::class, 'update'])->name("paysUpdate");
});


//Region
Route::group(["region"], function($routes){
    $routes->get("region-liste", [\App\Http\Controllers\RegionController::class, 'index'])->name("region-list");
    $routes->get("region-create", [\App\Http\Controllers\RegionController::class, 'create'])->name("regionCreate");
    $routes->get("region-read/{slug}", [\App\Http\Controllers\RegionController::class, 'read'])->name("regionRead");
    $routes->get("region-edit/{slug}", [\App\Http\Controllers\RegionController::class, 'edit'])->name("regionEdit");
    $routes->get("region-delete/{slug}", [\App\Http\Controllers\RegionController::class, 'destroy'])->name("regionDelete");
    $routes->post("region-store", [\App\Http\Controllers\RegionController::class, 'store'])->name("regionStore");
    $routes->post("region-store/{slug}", [\App\Http\Controllers\RegionController::class, 'update'])->name("regionUpdate");
});


//Grade
Route::group(["grade"], function($routes){
    $routes->get("grade-liste", [\App\Http\Controllers\GradeController::class, 'index'])->name("grade-list");
    $routes->get("grade-create", [\App\Http\Controllers\GradeController::class, 'create'])->name("gradeCreate");
    $routes->get("grade-read/{slug}", [\App\Http\Controllers\GradeController::class, 'read'])->name("gradeRead");
    $routes->get("grade-edit/{slug}", [\App\Http\Controllers\GradeController::class, 'edit'])->name("gradeEdit");
    $routes->get("grade-delete/{slug}", [\App\Http\Controllers\GradeController::class, 'destroy'])->name("gradeDelete");
    $routes->post("grade-store", [\App\Http\Controllers\GradeController::class, 'store'])->name("gradeStore");
    $routes->post("grade-store/{slug}", [\App\Http\Controllers\GradeController::class, 'update'])->name("gradeUpdate");
});


//Diplome
Route::group(["diplome"], function($routes){
    $routes->get("diplome-liste", [\App\Http\Controllers\DiplomeController::class, 'index'])->name("diplome-list");
    $routes->get("diplome-create", [\App\Http\Controllers\DiplomeController::class, 'create'])->name("diplomeCreate");
    $routes->get("diplome-read/{slug}", [\App\Http\Controllers\DiplomeController::class, 'read'])->name("diplomeRead");
    $routes->get("diplome-edit/{slug}", [\App\Http\Controllers\DiplomeController::class, 'edit'])->name("diplomeEdit");
    $routes->get("diplome-delete/{slug}", [\App\Http\Controllers\DiplomeController::class, 'destroy'])->name("diplomeDelete");
    $routes->post("diplome-store", [\App\Http\Controllers\DiplomeController::class, 'store'])->name("diplomeStore");
    $routes->post("diplome-store/{slug}", [\App\Http\Controllers\DiplomeController::class, 'update'])->name("diplomeUpdate");
});


//Ecole
Route::group(["ecole"], function($routes){
    $routes->get("ecole-liste", [\App\Http\Controllers\EcoleController::class, 'index'])->name("ecole-list");
    $routes->get("ecole-create", [\App\Http\Controllers\EcoleController::class, 'create'])->name("ecoleCreate");
    $routes->get("ecole-read/{slug}", [\App\Http\Controllers\EcoleController::class, 'read'])->name("ecoleRead");
    $routes->get("ecole-edit/{slug}", [\App\Http\Controllers\EcoleController::class, 'edit'])->name("ecoleEdit");
    $routes->get("ecole-delete/{slug}", [\App\Http\Controllers\EcoleController::class, 'destroy'])->name("ecoleDelete");
    $routes->post("ecole-store", [\App\Http\Controllers\EcoleController::class, 'store'])->name("ecoleStore");
    $routes->post("ecole-store/{slug}", [\App\Http\Controllers\EcoleController::class, 'update'])->name("ecoleUpdate");
});


//Cycle
Route::group(["cycle"], function($routes){
    $routes->get("cycle-liste", [\App\Http\Controllers\CycleController::class, 'index'])->name("cycle-list");
    $routes->get("cycle-create", [\App\Http\Controllers\CycleController::class, 'create'])->name("cycleCreate");
    $routes->get("cycle-read/{slug}", [\App\Http\Controllers\CycleController::class, 'read'])->name("cycleRead");
    $routes->get("cycle-edit/{slug}", [\App\Http\Controllers\CycleController::class, 'edit'])->name("cycleEdit");
    $routes->get("cycle-delete/{slug}", [\App\Http\Controllers\CycleController::class, 'destroy'])->name("cycleDelete");
    $routes->post("cycle-store", [\App\Http\Controllers\CycleController::class, 'store'])->name("cycleStore");
    $routes->post("cycle-update/{slug}", [\App\Http\Controllers\CycleController::class, 'update'])->name("cycleUpdate");
});


//Level
Route::group(["level"], function($routes){
    $routes->get("level-liste", [\App\Http\Controllers\LevelController::class, 'index'])->name("level-list");
    $routes->get("level-create", [\App\Http\Controllers\LevelController::class, 'create'])->name("levelCreate");
    $routes->get("level-read/{slug}", [\App\Http\Controllers\LevelController::class, 'read'])->name("levelRead");
    $routes->get("level-edit/{slug}", [\App\Http\Controllers\LevelController::class, 'edit'])->name("levelEdit");
    $routes->get("level-delete/{slug}", [\App\Http\Controllers\LevelController::class, 'destroy'])->name("levelDelete");
    $routes->post("level-store", [\App\Http\Controllers\LevelController::class, 'store'])->name("levelStore");
    $routes->post("level-store/{slug}", [\App\Http\Controllers\LevelController::class, 'update'])->name("levelUpdate");
});

