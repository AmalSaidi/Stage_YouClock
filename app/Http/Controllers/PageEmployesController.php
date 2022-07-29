<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\employes;
use App\Models\ventilation;
use App\Models\ventilationfiche;
use App\Models\fichehor;
use App\Models\horairesemaine;
use App\Models\semainetype;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PageEmployesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user=Auth::user();
        $session_str = $user->structure;
        $employes = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $structures = DB::select('select * from structures');
        $employees = DB::select('select * from employes');
        if(Gate::allows('access-admin')){
            return view('ADMIN/PageEmployes',[
                'employes' =>$employes,'structures'=>$structures,
            ]);
        }
        if(Gate::allows('access-direction')){
            return view('DIRECTION/PageEmployes',[
                'employees' =>$employees,'structures'=>$structures,
            ]);
        }
    }


    public function store(){

        $employes = new employes();

        $employes->nom = request('nom');
        $employes->prenom = request('prenom');
        $employes->identifiant = request('identifiant');
        $employes->structure = request('structure');
        $employes->intitule = request('intitule');
        $employes->dateEmbauche = request('dateEmbauche');
        $employes->Datefin = request('Datefin');
        $employes->TypeContrat = request('TypeContrat');
        $employes->mail = request('mail');

        $employes->save();

        return redirect('/employes');
    }

    public function ventila(Request $request)
    {
        $st = ventilation::updateOrCreate(
            ['idUser' =>  request('idUser')],
            ['ventilation' => $request->input('ventilation'),'idUser' => $request->input('idUser')]
        );
        return redirect()->back()->with('status', 'Les modifications ont été bien enregistrés');
    }

    public function show($id) {
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        return view('ADMIN/infoperso',['employes'=>$employes,'employees'=>$employees,'fiche'=>$fiche]);
        }

    public function showRH($id) {
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        $Lun= DB::select('select * from semainetypes where jour="Lundi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Mar= DB::select('select * from semainetypes where jour="Mardi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Mer= DB::select('select * from semainetypes where jour="Mercredi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Jeu= DB::select('select * from semainetypes where jour="Jeudi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Ven= DB::select('select * from semainetypes where jour="Vendredi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Sam= DB::select('select * from semainetypes where jour="Samedi" and idUser=(select identifiant from employes where id=?)',[$id]);
        $Dim= DB::select('select * from semainetypes where jour="Dimanche" and idUser=(select identifiant from employes where id=?)',[$id]);
        return view('ADMIN/RH',['employes'=>$employes,'employees'=>$employees,'Lun'=>$Lun,'Mar'=>$Mar,'Mer'=>$Mer
        ,'Jeu'=>$Jeu,'Ven'=>$Ven,'Sam'=>$Sam,'Dim'=>$Dim,'fiche'=>$fiche]);
        }

    public function showFiche($id) {
        $user=Auth::user();
        $session_str = $user->structure;
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        $fiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?)',[$id]);
        return view('ADMIN/ficheHoraire',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche]);
        }

        public function showVenti($id) {
            $user=Auth::user();
            $session_str = $user->structure;
            $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
            $employes = DB::select('select * from employes where id = ?',[$id]);
            $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
            $fiche = DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?) and idfiche=(select idfiche from
            fichehors ORDER BY id DESC LIMIT 1 )',[$id]);
            $FRASAD=0;
            $Entraide=0;	
            $Fédération=0;
            $Prestataire=0;
            $Voisineurs	=0;
            $ADU=0;
            $Mandataires=0;	
            $SOS=0;	
            $ADVM=0;	
            $Délégation=0;
            $poids=0;
            foreach ($fiche as $fi) {
                $Délégation=$fi->DELEGATION+$Délégation;
                $FRASAD=$fi->FRASAD+$FRASAD;
                $Entraide=$fi->EntraideFamiliale+$Entraide;
                $Fédération=$fi->Federation+$Fédération;
                $Prestataire=$fi->Prestataire+$Prestataire;
                $Voisineurs=$fi->Voisineurs+$Voisineurs;
                $ADU=$fi->ADUservices+$ADU;
                $Mandataires=$fi->Mandataires+$Mandataires;
                $SOS=$fi->SOSgarde+$SOS;
                $ADVM=$fi->ADVM+$ADVM;
                $poids=$fi->Poids+$poids;
            }
            $totalVentil=$Délégation+ $FRASAD+$Entraide+$Fédération+$Prestataire+$Voisineurs+$ADU+$Mandataires+$SOS+$ADVM;
            $diff=$poids-$totalVentil;
            return view('ADMIN/ventilationfiche',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
            'FRASAD'=>$FRASAD,'Entraide'=>$Entraide,'Fédération'=>$Fédération,'Prestataire'=>$Prestataire,'Voisineurs'=>$Voisineurs,
            'ADU'=>$ADU,'Mandataires'=>$Mandataires,'SOS'=>$SOS,'ADVM'=>$ADVM,'totalVentil'=>$totalVentil,'poids'=>$poids,'diff'=>$diff]);
            }
            

            public function showStat($id) {
                $user=Auth::user();
                $session_str = $user->structure;
                $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
                $employes = DB::select('select * from employes where id = ?',[$id]);
                $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
                $fiche = DB::select('select * from fichehors where idUser = (select identifiant from employes where id = ?)',[$id]);
                $date = date('Y-m-01', strtotime("first day of this month"));
                $year = date('Y', strtotime($date));
                $depassementJan =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Janvier%"',[$id]);
                $depassementFev =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Février%"',[$id]);
                $depassementMar =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Mars%"',[$id]);
                $depassementAvr =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Avril%"',[$id]);
                $depassementMai =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Mai%"',[$id]);
                $depassementJuin =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Juin%"',[$id]);
                $depassementJuillet =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Juillet%"',[$id]);
                $depassementAout =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Août%"',[$id]);
                $depassementSept =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Septembre%"',[$id]);
                $depassementOct =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Octobre%"',[$id]);
                $depassementNov =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Novembre%"',[$id]);
                $depassementDec =  DB::select('select * from depassements where identifiant = (select identifiant from employes where id = ?) and
                idFiche LIKE "%Décembre%"',[$id]);
                $DJan=0;
                $DFev=0;
                $DMar=0;
                $DAvr=0;
                $DMai=0;
                $DJuin=0;
                $DJuil=0;
                $DAout=0;
                $DSept=0;
                $DOct=0;
                $DNov=0;
                $DDec=0;
                foreach($depassementJan as $depJan)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DJan=$DJan+$depJan->nombreH;
                    }
                }
                foreach($depassementFev as $depFev)
                {
                    if(str_contains($depFev->idFiche, $year)){
                        $DFev=$DFev+$depFev->nombreH;
                    }
                }
                foreach($depassementFev as $depMar)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DMar=$DMar+$depMar->nombreH;
                    }
                }
                foreach($depassementFev as $depAvr)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DAvr=$DAvr+$depAvr->nombreH;
                    }
                }
                foreach($depassementFev as $depMai)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DMai=$DMai+$depMai->nombreH;
                    }
                }
                foreach($depassementFev as $depJuin)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DJuin=$DJuin+$depJuin->nombreH;
                    }
                }
                foreach($depassementFev as $depJuil)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DJuil=$DJuil+$depJuil->nombreH;
                    }
                }
                foreach($depassementFev as $depAou)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DAout=$DAout+$depAou->nombreH;
                    }
                }
                foreach($depassementFev as $depSept)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DSept=$DSept+$depSept->nombreH;
                    }
                }
                foreach($depassementFev as $depOct)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DJan=$DJan+$depOct->nombreH;
                    }
                }
                foreach($depassementFev as $depNov)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DNov=$DNov+$depNov->nombreH;
                    }
                }
                foreach($depassementFev as $depDec)
                {
                    if(str_contains($depJan->idFiche, $year)){
                        $DDec=$DDec+$depDec->nombreH;
                    }
                }
                $FRASAD=0;
                $Entraide=0;	
                $Fédération=0;
                $Prestataire=0;
                $Voisineurs	=0;
                $ADU=0;
                $Mandataires=0;	
                $SOS=0;	
                $ADVM=0;	
                $Délégation=0;
                $poids=0;
                $ferie=0;
                $TR=0;
                $CP=0;
                $RTT=0;
                $HRTT=0;
                $RCR=0;
                $FOR=0;
                $MAL=0;
                $CF=0;
                $SS=0;
                $JS=0;
                foreach ($fiche as $fi) {
                    if(str_contains($fi->idfiche, $year)){
                    $Délégation=$fi->DELEGATION+$Délégation;
                    $FRASAD=$fi->FRASAD+$FRASAD;
                    $Entraide=$fi->EntraideFamiliale+$Entraide;
                    $Fédération=$fi->Federation+$Fédération;
                    $Prestataire=$fi->Prestataire+$Prestataire;
                    $Voisineurs=$fi->Voisineurs+$Voisineurs;
                    $ADU=$fi->ADUservices+$ADU;
                    $Mandataires=$fi->Mandataires+$Mandataires;
                    $SOS=$fi->SOSgarde+$SOS;
                    $ADVM=$fi->ADVM+$ADVM;
                    $poids=$fi->Poids+$poids;
                    }
                }
                foreach ($fiche as $fi) {
                    if(str_contains($fi->idfiche, $year)){
                        if($fi->typeJour=="Férié"){
                            $ferie=$ferie+1;
                        }
                        else if($fi->typeJour=="Travaillé"){
                            $TR=$TR+1;
                        }
                        else if($fi->typeJour=="CP"){
                            $CP=$CP+1;
                        }
                        else if($fi->typeJour=="RTT"){
                            $RTT=$RTT+1;
                        }

                        else if($fi->typeJour=="1/2 RTT"){
                            $HRTT=$HRTT+1;
                        }

                        else if($fi->typeJour=="RCR"){
                            $RCR=$RCR+1;
                        }

                        else if($fi->typeJour=="Formation"){
                            $FOR=$FOR+1;
                        }
                        else if($fi->typeJour=="Maladie"){
                            $MAL=$MAL+1;
                        }
                        else if($fi->typeJour=="Congés familiaux"){
                            $CF=$CF+1;
                        }
                        else if($fi->typeJour=="Sans soldes"){
                            $SS=$SS+1;
                        }
                        else if($fi->typeJour=="Jour solidarité"){
                            $JS=$JS+1;
                        }


                    }
                }
                $FerieJan=0;
                $TRJan=0;
                $CPJan=0;
                $RTTJan=0;
                $HRTTJan=0;
                $RCRJan=0;
                $FORJan=0;
                $MALJan=0;
                $CFJan=0;
                $SSJan=0;
                $JSJan=0;
                $FerieFev=0;
                $TRFev=0;
                $CPFev=0;
                $RTTFev=0;
                $HRTTFev=0;
                $RCRFev=0;
                $FORFev=0;
                $MALFev=0;
                $CFFev=0;
                $SSFev=0;
                $JSFev=0;
                $FerieMar=0;
                $TRMar=0;
                $CPMar=0;
                $RTTMar=0;
                $HRTTMar=0;
                $RCRMar=0;
                $FORMar=0;
                $MALMar=0;
                $CFMar=0;
                $SSMar=0;
                $JSMar=0;
                $FerieAvr=0;
                $TRAvr=0;
                $CPAvr=0;
                $RTTAvr=0;
                $HRTTAvr=0;
                $RCRAvr=0;
                $FORAvr=0;
                $MALAvr=0;
                $CFAvr=0;
                $SSAvr=0;
                $JSAvr=0;
                $FerieMai=0;
                $TRMai=0;
                $CPMai=0;
                $RTTMai=0;
                $HRTTMai=0;
                $RCRMai=0;
                $FORMai=0;
                $MALMai=0;
                $CFMai=0;
                $SSMai=0;
                $JSMai=0;
                $FerieJuin=0;
                $TRJuin=0;
                $CPJuin=0;
                $RTTJuin=0;
                $HRTTJuin=0;
                $RCRJuin=0;
                $FORJuin=0;
                $MALJuin=0;
                $CFJuin=0;
                $SSJuin=0;
                $JSJuin=0;
                $FerieJuillet=0;
                $TRJuillet=0;
                $CPJuillet=0;
                $RTTJuillet=0;
                $HRTTJuillet=0;
                $RCRJuillet=0;
                $FORJuillet=0;
                $MALJuillet=0;
                $CFJuillet=0;
                $SSJuillet=0;
                $JSJuillet=0;
                $FerieAout=0;
                $TRAout=0;
                $CPAout=0;
                $RTTAout=0;
                $HRTTAout=0;
                $RCRAout=0;
                $FORAout=0;
                $MALAout=0;
                $CFAout=0;
                $SSAout=0;
                $JSAout=0;
                $FerieSeptembre=0;
                $TRSeptembre=0;
                $CPSeptembre=0;
                $RTTSeptembre=0;
                $HRTTSeptembre=0;
                $RCRSeptembre=0;
                $FORSeptembre=0;
                $MALSeptembre=0;
                $CFSeptembre=0;
                $SSSeptembre=0;
                $JSSeptembre=0;
                $FerieOctobre=0;
                $TROctobre=0;
                $CPOctobre=0;
                $RTTOctobre=0;
                $HRTTOctobre=0;
                $RCROctobre=0;
                $FOROctobre=0;
                $MALOctobre=0;
                $CFOctobre=0;
                $SSOctobre=0;
                $JSOctobre=0;
                $FerieNovembre=0;
                $TRNovembre=0;
                $CPNovembre=0;
                $RTTNovembre=0;
                $HRTTNovembre=0;
                $RCRNovembre=0;
                $FORNovembre=0;
                $MALNovembre=0;
                $CFNovembre=0;
                $SSNovembre=0;
                $JSNovembre=0;
                $FerieDecembre=0;
                $TRDecembre=0;
                $CPDecembre=0;
                $RTTDecembre=0;
                $HRTTDecembre=0;
                $RCRDecembre=0;
                $FORDecembre=0;
                $MALDecembre=0;
                $CFDecembre=0;
                $SSDecembre=0;
                $JSDecembre=0;
                foreach ($fiche as $fi) {
                    if(str_contains($fi->idfiche, $year)){
                        if(str_contains($fi->idfiche, "Janvier")){
                            if($fi->typeJour=="Férié"){
                            $FerieJan=$FerieJan+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRJan=$TRJan+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPJan=$CPJan+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTJan=$RTTJan+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTJan=$HRTTJan+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRJan=$RCRJan+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORJan=$FORJan+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALJan=$MALJan+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFJan=$CFJan+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSJan=$SSJan+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSJan=$JSJan+1;
                            }
                        }
                        else if(str_contains($fi->idfiche, "Février")){
                            if($fi->typeJour=="Férié"){
                            $FerieFev=$FerieFev+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRFev=$TRFev+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPFev=$CPFev+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTFev=$RTTFev+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTFev=$HRTTFev+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRFev=$RCRFev+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORFev=$FORFev+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALFev=$MALFev+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFFev=$CFFev+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSFev=$SSFev+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSFev=$JSFev+1;
                            }
                        }else if(str_contains($fi->idfiche, "Mars")){
                            if($fi->typeJour=="Férié"){
                            $FerieMar=$FerieMar+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRMar=$TRMar+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPMar=$CPMar+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTMar=$RTTMar+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTMar=$HRTTMar+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRMar=$RCRMar+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORMar=$FORMar+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALMar=$MALMar+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFMar=$CFMar+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSMar=$SSMar+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSMar=$JSMar+1;
                            }
                        }else if(str_contains($fi->idfiche, "Avril")){
                            if($fi->typeJour=="Férié"){
                            $FerieAvr=$FerieAvr+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRAvr=$TRAvr+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPAvr=$CPAvr+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTAvr=$RTTAvr+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTAvr=$HRTTAvr+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRAvr=$RCRAvr+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORAvr=$FORAvr+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALAvr=$MALAvr+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFAvr=$CFAvr+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSAvr=$SSAvr+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSAvr=$JSAvr+1;
                            }
                        }else if(str_contains($fi->idfiche, "Mai")){
                            if($fi->typeJour=="Férié"){
                            $FerieMai=$FerieMai+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRMai=$TRMai+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPMai=$CPMai+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTMai=$RTTMai+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTMai=$HRTTMai+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRMai=$RCRMai+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORMai=$FORMai+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALMai=$MALMai+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFMai=$CFMai+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSMai=$SSMai+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSMai=$JSMai+1;
                            }
                        }
                        else if(str_contains($fi->idfiche, "Juin")){
                            if($fi->typeJour=="Férié"){
                            $FerieJuin=$FerieJuin+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRJuin=$TRJuin+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPJuin=$CPJuin+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTJuin=$RTTJuin+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTJuin=$HRTTJuin+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRJuin=$RCRJuin+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORJuin=$FORJuin+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALJuin=$MALJuin+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFJuin=$CFJuin+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSJuin=$SSJuin+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSJuin=$JSJuin+1;
                            }
                        }
                        else if(str_contains($fi->idfiche, "Juillet")){
                            if($fi->typeJour=="Férié"){
                            $FerieJuillet=$FerieJuillet+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRJuillet=$TRJuillet+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPJuillet=$CPJuillet+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTJuillet=$RTTJuillet+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTJuillet=$HRTTJuillet+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRJuillet=$RCRJuillet+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORJuillet=$FORJuillet+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALJuillet=$MALJuillet+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFJuillet=$CFJuillet+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSJuillet=$SSJuillet+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSJuillet=$JSJuillet+1;
                            }
                        }
                        else if(str_contains($fi->idfiche, "Août")){
                            if($fi->typeJour=="Férié"){
                            $FerieAout=$FerieAout+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRAout=$TRAout+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPAout=$CPAout+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTAout=$RTTAout+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTAout=$HRTTAout+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRAout=$RCRAout+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORAout=$FORAout+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALAout=$MALAout+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFAout=$CFAout+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSAout=$SSAout+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSAout=$JSAout+1;
                            }
                        }
                        else if(str_contains($fi->idfiche, "Septembre")){
                            if($fi->typeJour=="Férié"){
                            $FerieSeptembre=$FerieSeptembre+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRSeptembre=$TRSeptembre+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPSeptembre=$CPSeptembre+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTSeptembre=$RTTSeptembre+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTSeptembre=$HRTTSeptembre+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRSeptembre=$RCRSeptembre+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORSeptembre=$FORSeptembre+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALSeptembre=$MALSeptembre+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFSeptembre=$CFSeptembre+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSSeptembre=$SSSeptembre+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSSeptembre=$JSSeptembre+1;
                            }
                        }
                        else if(str_contains($fi->idfiche, "Octobre")){
                            if($fi->typeJour=="Férié"){
                            $FerieOctobre=$FerieOctobre+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TROctobre=$TROctobre+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPOctobre=$CPSOctobre+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTOctobre=$RTTOctobre+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTOctobre=$HRTTOctobre+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCROctobre=$RCROctobre+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FOROctobre=$FOROctobre+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALOctobre=$MALOctobre+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFOctobre=$CFOctobre+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSOctobre=$SSOctobre+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSOctobre=$JSOctobre+1;
                            }
                        }
                        else if(str_contains($fi->idfiche, "Novembre")){
                            if($fi->typeJour=="Férié"){
                            $FerieNovembre=$FerieNovembre+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRNovembre=$TRNovembre+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPNovembre=$CPNovembre+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTNovembre=$RTTNovembre+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTNovembre=$HRTTNovembre+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRNovembre=$RCRNovembre+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORNovembre=$FORNovembre+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALNovembre=$MALNovembre+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFNovembre=$CFNovembre+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSNovembre=$SSNovembre+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSNovembre=$JSNovembre+1;
                            }
                        }
                        else if(str_contains($fi->idfiche, "Décembre")){
                            if($fi->typeJour=="Férié"){
                            $FerieDecembre=$FerieDecembre+1;
                            }
                            else if($fi->typeJour=="Travaillé"){
                            $TRDecembre=$TRDecembre+1;
                            }
                            else if($fi->typeJour=="CP"){
                            $CPDecembre=$CPDecembre+1;
                            }
                            else if($fi->typeJour=="RTT"){
                            $RTTDecembre=$RTTDecembre+1;
                            }
                             else if($fi->typeJour=="1/2 RTT"){
                            $HRTTDecembre=$HRTTDecembre+1;
                            }
                             else if($fi->typeJour=="RCR"){
                            $RCRDecembre=$RCRDecembre+1;
                            }
                             else if($fi->typeJour=="Formation"){
                            $FORDecembre=$FORDecembre+1;
                            }
                             else if($fi->typeJour=="Maladie"){
                            $MALDecembre=$MALDecembre+1;
                            }
                             else if($fi->typeJour=="Congés familiaux"){
                            $CFDecembre=$CFDecembre+1;
                            }
                             else if($fi->typeJour=="Sans soldes"){
                            $SSDecembre=$SSDecembre+1;
                            }
                             else if($fi->typeJour=="Jour solidarité"){
                            $JSDecembre=$JSDecembre+1;
                            }
                        }
                        
                }
            }
                $totalVentil=$Délégation+ $FRASAD+$Entraide+$Fédération+$Prestataire+$Voisineurs+$ADU+$Mandataires+$SOS+$ADVM;
                $diff=$poids-$totalVentil;
                return view('ADMIN/stat',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees,'fiiche'=>$fiiche,'Délégation'=>$Délégation,
                'FRASAD'=>$FRASAD,'Entraide'=>$Entraide,'Fédération'=>$Fédération,'Prestataire'=>$Prestataire,'Voisineurs'=>$Voisineurs,
                'ADU'=>$ADU,'Mandataires'=>$Mandataires,'SOS'=>$SOS,'ADVM'=>$ADVM,'totalVentil'=>$totalVentil,'poids'=>$poids,'diff'=>$diff,'year'=>$year
                ,'ferie'=>$ferie,'TR'=>$TR,'CP'=>$CP,'RTT'=>$RTT,'HRTT'=>$HRTT,'RCR'=>$RCR,'FOR'=>$FOR,'MAL'=>$MAL,'CF'=>$CF,'SS'=>$SS,'JS'=>$JS,
                'FerieJan'=>$FerieJan,'TRJan'=>$TRJan,'CPJan'=>$CPJan,'RTTJan'=>$RTTJan,'HRTTJan'=>$HRTTJan,'RCRJan'=>$RCRJan,'FORJan'=>$FORJan,
                'MALJan'=>$MALJan,'CFJan'=>$CFJan,'SSJan'=>$SSJan,'JSJan'=>$JSJan,
                'FerieFev'=>$FerieFev,'TRFev'=>$TRFev,'CPFev'=>$CPFev,'RTTFev'=>$RTTFev,'HRTTFev'=>$HRTTFev,'RCRFev'=>$RCRFev,'FORFev'=>$FORFev,
                'MALFev'=>$MALFev,'CFFev'=>$CFFev,'SSFev'=>$SSFev,'JSFev'=>$JSFev,
                'FerieMar'=>$FerieMar,'TRMar'=>$TRMar,'CPMar'=>$CPMar,'RTTMar'=>$RTTMar,'HRTTMar'=>$HRTTMar,'RCRMar'=>$RCRMar,'FORMar'=>$FORMar,
                'MALMar'=>$MALMar,'CFMar'=>$CFMar,'SSMar'=>$SSMar,'JSMar'=>$JSMar,
                'FerieAvr'=>$FerieAvr,'TRAvr'=>$TRAvr,'CPAvr'=>$CPAvr,'RTTAvr'=>$RTTAvr,'HRTTAvr'=>$HRTTAvr,'RCRAvr'=>$RCRAvr,'FORAvr'=>$FORAvr,
                'MALAvr'=>$MALAvr,'CFAvr'=>$CFAvr,'SSAvr'=>$SSAvr,'JSAvr'=>$JSAvr,
                'FerieMai'=>$FerieMai,'TRMai'=>$TRMai,'CPMai'=>$CPMai,'RTTMai'=>$RTTMai,'HRTTMai'=>$HRTTMai,'RCRMai'=>$RCRMai,'FORMai'=>$FORMai,
                'MALMai'=>$MALMai,'CFMai'=>$CFMai,'SSMai'=>$SSMai,'JSMai'=>$JSMai,
                'FerieJuin'=>$FerieJuin,'TRJuin'=>$TRJuin,'CPJuin'=>$CPJuin,'RTTJuin'=>$RTTJuin,'HRTTJuin'=>$HRTTJuin,'RCRJuin'=>$RCRJuin,'FORJuin'=>$FORJuin,
                'MALJuin'=>$MALJuin,'CFJuin'=>$CFJuin,'SSJuin'=>$SSJuin,'JSJuin'=>$JSJuin,
                'FerieJuillet'=>$FerieJuillet,'TRJuillet'=>$TRJuillet,'CPJuillet'=>$CPJuillet,'RTTJuillet'=>$RTTJuillet,'HRTTJuillet'=>$HRTTJuillet,'RCRJuillet'=>$RCRJuillet,'FORJuillet'=>$FORJuillet,
                'MALJuillet'=>$MALJuillet,'CFJuillet'=>$CFJuillet,'SSJuillet'=>$SSJuillet,'JSJuillet'=>$JSJuillet,
                'FerieAout'=>$FerieAout,'TRAout'=>$TRAout,'CPAout'=>$CPAout,'RTTAout'=>$RTTAout,'HRTTAout'=>$HRTTAout,'RCRAout'=>$RCRAout,'FORAout'=>$FORAout,
                'MALAout'=>$MALAout,'CFAout'=>$CFAout,'SSAout'=>$SSAout,'JSAout'=>$JSAout,
                'FerieSeptembre'=>$FerieSeptembre,'TRSeptembre'=>$TRSeptembre,'CPSeptembre'=>$CPSeptembre,'RTTSeptembre'=>$RTTSeptembre,'HRTTSeptembre'=>$HRTTSeptembre,'RCRSeptembre'=>$RCRSeptembre,'FORSeptembre'=>$FORSeptembre,
                'MALSeptembre'=>$MALSeptembre,'CFSeptembre'=>$CFSeptembre,'SSSeptembre'=>$SSSeptembre,'JSSeptembre'=>$JSSeptembre,
                'FerieOctobre'=>$FerieOctobre,'TROctobre'=>$TROctobre,'CPOctobre'=>$CPOctobre,'RTTOctobre'=>$RTTOctobre,'HRTTOctobre'=>$HRTTOctobre,'RCROctobre'=>$RCROctobre,'FOROctobre'=>$FOROctobre,
                'MALOctobre'=>$MALOctobre,'CFOctobre'=>$CFOctobre,'SSOctobre'=>$SSOctobre,'JSOctobre'=>$JSOctobre,
                'FerieNovembre'=>$FerieNovembre,'TRNovembre'=>$TRNovembre,'CPNovembre'=>$CPNovembre,'RTTNovembre'=>$RTTNovembre,'HRTTNovembre'=>$HRTTNovembre,'RCRNovembre'=>$RCRNovembre,'FORNovembre'=>$FORNovembre,
                'MALNovembre'=>$MALNovembre,'CFNovembre'=>$CFNovembre,'SSNovembre'=>$SSNovembre,'JSNovembre'=>$JSNovembre,
                'FerieDecembre'=>$FerieDecembre,'TRDecembre'=>$TRDecembre,'CPDecembre'=>$CPDecembre,'RTTDecembre'=>$RTTDecembre,'HRTTDecembre'=>$HRTTDecembre,'RCRDecembre'=>$RCRDecembre,'FORDecembre'=>$FORDecembre,
                'MALDecembre'=>$MALDecembre,'CFDecembre'=>$CFDecembre,'SSDecembre'=>$SSDecembre,'JSDecembre'=>$JSDecembre,'DJan'=>$DJan,'DFev'=>$DFev,'DMar'=>$DMar,'DAvr'=>$DAvr,'DMai'=>$DMai,'DJuin'=>$DJuin,
                'DJuil'=>$DJuil,'DAout'=>$DAout,'DSept'=>$DSept,'DOct'=>$DOct,'DNov'=>$DNov,'DDec'=>$DDec,
            ]);
                }
        


    public function showFicheComplete($id,$idfiche) {
        $user=Auth::user();
        $session_str = $user->structure;
        $fiiche = DB::select('select DISTINCT idfiche,statutF from fichehors where idUser = (select identifiant from employes where id = ?) ORDER BY id DESC LIMIT 1',[$id]);
        $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
        $employes = DB::select('select * from employes where id = ?',[$id]);
        $poidsJour = DB::select('select * from ventilationfinals where idUser = (select identifiant from employes where id=?)',[$id]);
        $depassement = DB::select('select * from depassements where idfiche =? AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $fiche = DB::select('select * from fichehors where idfiche =? AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem1 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 1" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem2 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 2" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem3 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 3" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem4 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 4" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $sem5 = DB::select('select * from depassements where idfiche =? AND semaine="semaine 5" AND identifiant = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $NR = DB::select('select * from fichehors where idfiche =? AND state="NR" AND idUser = (select identifiant from employes where id = ?)',[$idfiche,$id]);
        $countNR=0;
        if(Gate::allows('access-admin')){
            return view('ADMIN/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees
            ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'NR'=>$NR,'fiiche'=>$fiiche]);
            }
            if(Gate::allows('access-direction')){
                return view('DIRECTION/FicheHoraireDetails',['employes'=>$employes,'fiche'=>$fiche,'employees'=>$employees
                ,'depassement'=>$depassement,'sem1'=>$sem1,'sem2'=>$sem2,'sem3'=>$sem3,'sem4'=>$sem4,'sem5'=>$sem5,'NR'=>$NR,'fiiche'=>$fiiche]);
                }
        }

        public function validerFicheRS(Request $request) {
            $idU = $request->input('idUser');
            $idF = $request->input('idfiche');
            $fiche = DB::select('select * from fichehors where idfiche =? AND idUser = ?',[$idF,$idU]);
            $countNR=0;
            foreach ($fiche as $fi) {
                if($fi->state=="NR"){
                    $countNR=$countNR+1;
                }
                else{
                    $countNR=0;
                }
            }
            if($countNR==0)
            {
                DB::update('update fichehors set statutF="valideRS" where idfiche = ? and idUser = ?',[$idF,$idU]);
                return redirect()->back();
            }
            else{
                return redirect()->back()->with('status', 'vous devez renseigner tout les champs');
            }
            }

        public function validerFicheDir(Request $request) {
            $idF = $request->input('idfiche');
            $idU = $request->input('idUser');
            DB::update('update fichehors set statutF="valide" where idfiche = ? and idUser = ?',[$idF,$idU]);
            return redirect()->back();
            }

        public function validerVentil(Request $request) {
            $idF = $request->input('idfiche');
            $idU = $request->input('idUser');
            $FRASAD = $request->input('FRASAD');
            $Entraide = $request->input('Entraide');
            $Fédération = $request->input('Fédération');
            $Prestataire = $request->input('Prestataire');
            $Voisineurs = $request->input('Voisineurs');
            $ADU = $request->input('ADU');
            $Mandataires = $request->input('Mandataires');
            $SOS = $request->input('SOS');
            $Délégation = $request->input('Délégation');
            $ADVM = $request->input('ADVM');
            $venti = DB::select('select * from ventilationfiches where idFiche =? AND idUser = ?',[$idF,$idU]);
            if(ventilationfiche::where('idUser', $idU)->where('idFiche', $idF)->count() > 0){
                DB::update('update ventilationfiches set FRASAD=?,Entraide=?,Federation=?,Prestataire=?,Voisineurs=?,ADU=?,Mandataires=?
                ,SOS=?,Delegation=?,ADVM=? where idfiche = ? and idUser = ?',[$FRASAD,$Entraide,$Fédération,$Prestataire,$Voisineurs,$ADU,$Mandataires,$SOS,$Délégation,$ADVM,$idF,$idU]);
                }
            else
                {
                DB::insert('insert into ventilationFiches (idFiche,idUser,FRASAD,Entraide,Federation,Prestataire,Voisineurs,ADU,Mandataires
                ,SOS,Delegation,ADVM) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$idF,$idU,$FRASAD,$Entraide,$Fédération,$Prestataire,$Voisineurs,$ADU,$Mandataires,$SOS,$Délégation,$ADVM]);
                }
            return redirect()->back();
            }
    
        public function refuse(Request $request) {
            $idf = $request->id;
            $fiche = fichehor::find($idf);
            $id = $fiche->id;
            DB::update('update fichehors set state ="RR" where id=?',[$id]);
            return view('ADMIN/FicheHoraireDetails',['id'=>$id]);
        }

        public function confirm(Request $request) {
            $idf = $request->id;
            $fiche = fichehor::find($idf);
            $id = $fiche->id;
            DB::update('update fichehors set state ="VR" where id=?',[$id]);
            return view('ADMIN/FicheHoraireDetails',['id'=>$id]);
        }


        public function showST($id) {
            $user=Auth::user();
            $session_str = $user->structure;
            $employees = DB::table('employes')->where('structure', 'like', '%'.$session_str.'%')->where('admin',0)->get();
            $employes = DB::select('select * from employes where id = ?',[$id]);
            return view('ADMIN/semaineType',['employes'=>$employes,'employees'=>$employees]);
            }

         public function ajouterST(Request $request){
            $identifiant = $request->input('identifiant');
            $FM1 = $request->input('FM1');
            $DM1 = $request->input('DM1');
            $FA1 = $request->input('FA1');
            $DA1 = $request->input('DA1');
            $FS1 = $request->input('FS1');
            $DS1 = $request->input('DS1');
            $hourdiffLundiMat = round((strtotime($FM1) - strtotime($DM1 ))/3600, 1);
            $hourdiffLundiAprem = round((strtotime($FA1) - strtotime($DA1 ))/3600, 1);
            $hourdiffLundiSoir = round((strtotime($FS1) - strtotime($DS1 ))/3600, 1);
            $poidsLundi = $hourdiffLundiMat + $hourdiffLundiAprem +  $hourdiffLundiSoir;
            $FM2 = $request->input('FM2');
            $DM2 = $request->input('DM2');
            $FA2 = $request->input('FA2');
            $DA2 = $request->input('DA2');
            $FS2 = $request->input('FS2');
            $DS2 = $request->input('DS2');
            $hourdiffMardiMat = round((strtotime($FM2) - strtotime($DM2 ))/3600, 1);
            $hourdiffMardiAprem = round((strtotime($FA2) - strtotime($DA2 ))/3600, 1);
            $hourdiffMardiSoir = round((strtotime($FS2) - strtotime($DS2 ))/3600, 1);
            $poidsMardi = $hourdiffMardiMat + $hourdiffMardiAprem +  $hourdiffMardiSoir;
            $FM3 = $request->input('FM3');
            $DM3 = $request->input('DM3');
            $FA3 = $request->input('FA3');
            $DA3 = $request->input('DA3');
            $FS3 = $request->input('FS3');
            $DS3 = $request->input('DS3');
            $hourdiffMercMat = round((strtotime($FM3) - strtotime($DM3 ))/3600, 1);
            $hourdiffMercAprem = round((strtotime($FA3) - strtotime($DA3 ))/3600, 1);
            $hourdiffMercSoir = round((strtotime($FS3) - strtotime($DS3 ))/3600, 1);
            $poidsMerc = $hourdiffMercMat + $hourdiffMercAprem +  $hourdiffMercSoir;
            $FM4 = $request->input('FM4');
            $DM4 = $request->input('DM4');
            $FA4 = $request->input('FA4');
            $DA4 = $request->input('DA4');
            $FS4 = $request->input('FS4');
            $DS4 = $request->input('DS4');
            $hourdiffJeudiMat = round((strtotime($FM4) - strtotime($DM4 ))/3600, 1);
            $hourdiffJeudiAprem = round((strtotime($FA4) - strtotime($DA4 ))/3600, 1);
            $hourdiffJeudiSoir = round((strtotime($FS4) - strtotime($DS4 ))/3600, 1);
            $poidsJeudi = $hourdiffJeudiMat + $hourdiffJeudiAprem +  $hourdiffJeudiSoir;
            $FM5 = $request->input('FM5');
            $DM5 = $request->input('DM5');
            $FA5 = $request->input('FA5');
            $DA5 = $request->input('DA5');
            $FS5 = $request->input('FS5');
            $DS5 = $request->input('DS5');
            $hourdiffVenMat = round((strtotime($FM5) - strtotime($DM5 ))/3600, 1);
            $hourdiffVenAprem = round((strtotime($FA5) - strtotime($DA5 ))/3600, 1);
            $hourdiffVenSoir = round((strtotime($FS5) - strtotime($DS5 ))/3600, 1);
            $poidsVen = $hourdiffVenMat + $hourdiffVenAprem +  $hourdiffVenSoir;
            $FM6 = $request->input('FM6');
            $DM6 = $request->input('DM6');
            $FA6 = $request->input('FA6');
            $DA6 = $request->input('DA6');
            $FS6 = $request->input('FS6');
            $DS6 = $request->input('DS6');
            $hourdiffSamMat = round((strtotime($FM6) - strtotime($DM6 ))/3600, 1);
            $hourdiffSamAprem = round((strtotime($FA6) - strtotime($DA6 ))/3600, 1);
            $hourdiffSamSoir = round((strtotime($FS6) - strtotime($DS6 ))/3600, 1);
            $poidsSam = $hourdiffSamMat + $hourdiffSamAprem +  $hourdiffSamSoir;
            $FM7 = $request->input('FM7');
            $DM7 = $request->input('DM7');
            $FA7 = $request->input('FA7');
            $DA7 = $request->input('DA7');
            $FS7 = $request->input('FS7');
            $DS7 = $request->input('DS7');
            $hourdiffDimMat = round((strtotime($FM7) - strtotime($DM7 ))/3600, 1);
            $hourdiffDimAprem = round((strtotime($FA7) - strtotime($DA7 ))/3600, 1);
            $hourdiffDimSoir = round((strtotime($FS7) - strtotime($DS7 ))/3600, 1);
            $poidsDim = $hourdiffDimMat + $hourdiffDimAprem +  $hourdiffDimSoir;
            $fiches=DB::select('select * from fichehors where idUser=?',[$identifiant]);
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Lun')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Lun%"',
                    [$poidsLundi,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Mar')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Mar%"',
                    [$poidsMardi,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Mer')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Mer%"',
                    [$poidsMerc,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Jeu')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Jeu%"',
                    [$poidsJeudi,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Ven')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Ven%"',
                    [$poidsVen,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Sam')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Sam%"',
                    [$poidsSam,$identifiant]);
                }
            }
            foreach ($fiches as $fi) {
                if(str_contains($fi->Date, 'Dim')){
                    DB::update('update fichehors set Poids=? where idUser=? AND Date LIKE "%Dim%"',
                    [$poidsDim,$identifiant]);
                }
            }
            $st = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant'),'jour' =>  request('Lun')],
                ['DM' => request('DM1'),'FM' => request('FM1'),'DA' => request('DA1'),'FA' => request('FA1'),'DS' => request('DS1')
                ,'FS' => request('FS1')]
            );
            $st2 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant2'),'jour' =>  request('Mar')],
                ['DM' => request('DM2'),'FM' => request('FM2'),'DA' => request('DA2'),'FA' => request('FA2'),'DS' => request('DS2')
                ,'FS' => request('FS2')]
            );
            $st3 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant3'),'jour' =>  request('Mer')],
                ['DM' => request('DM3'),'FM' => request('FM3'),'DA' => request('DA3'),'FA' => request('FA3'),'DS' => request('DS3')
                ,'FS' => request('FS3')]
            );
            $st4 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant4'),'jour' =>  request('Jeu')],
                ['DM' => request('DM4'),'FM' => request('FM4'),'DA' => request('DA4'),'FA' => request('FA4'),'DS' => request('DS4')
                ,'FS' => request('FS4')]
            );
            $st5 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant5'),'jour' =>  request('Ven')],
                ['DM' => request('DM5'),'FM' => request('FM5'),'DA' => request('DA5'),'FA' => request('FA5'),'DS' => request('DS5')
                ,'FS' => request('FS5')]
            );
            $st6 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant6'),'jour' =>  request('Sam')],
                ['DM' => request('DM6'),'FM' => request('FM6'),'DA' => request('DA6'),'FA' => request('FA6'),'DS' => request('DS6')
                ,'FS' => request('FS6')]
            );
            $st7 = semainetype::updateOrCreate(
                ['idUser' =>  request('identifiant7'),'jour' =>  request('Dim')],
                ['DM' => request('DM7'),'FM' => request('FM7'),'DA' => request('DA7'),'FA' => request('FA7'),'DS' => request('DS7')
                ,'FS' => request('FS7')]
            );
            DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Lundi"',
        [$poidsLundi,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Mardi"',
        [$poidsMardi,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Mercredi"',
        [$poidsMerc,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Jeudi"',
        [$poidsJeudi,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Vendredi"',
        [$poidsVen,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Samedi"',
        [$poidsSam,$identifiant]);
        DB::update('update semainetypes set poidsJour=? where idUser=? AND Jour="Dimanche"',
        [$poidsDim,$identifiant]);
            return redirect()->back()->with('status', 'Les modifications ont été bien enregistrés');
            }

        
    }
