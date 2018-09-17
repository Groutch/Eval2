<?php

namespace App\Http\Controllers;

use App\Objets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ObjetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objets=DB::table('objets')
            ->select('objets.idObjet', 'objets.nomObjet','objets.image','objets.description','objets.idVendeur','objets.created_at','objets.updated_at','users.id as iduser','users.name as name')
            ->join('users', function ($join) {
                $join->on('objets.idVendeur', '=', 'users.id');
            })
            ->get();
        $user = Auth::user();
        return view('listObjets',compact('objets'),compact('user'),compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('categorie')->get();
        $user = Auth::user();
        if ($user!=NULL){
            return view('createObjet', compact('user'), compact('categories'));
        }else{
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objet = new \App\Objets;
        if ($request->hasFile('image'))
        {
            $filename=$request->image->getClientOriginalName();
            $request->image->storeAs('public/upload',$filename);
            $objet->image=$filename;
        }else{
            $objet->image="";
        }
        $objet->nomObjet=$request->get('nomObjet');
        $objet->description=$request->get('description');
        $objet->idVendeur=$request->get('idVendeur');
        $objet->idCategorie=$request->get('categorie');
        $objet->save();
        return redirect('/')->with('status', "L'objet a été ajouté !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Objets  $objets
     * @return \Illuminate\Http\Response
     */
    public function show(Objets $objets)
    {
        //
    }


    public function take($id)
    {
        $user = Auth::user();
        if ($user!=NULL){
            $objreq=DB::table('objets')->where('idObjet','=',$id)->get();
            //on récup le score de l'utilisateur à qui l'objet appartenait
            $userreq=DB::table('users')
                ->join('objets', 'users.id', '=', 'objets.idVendeur')
                ->select('users.id','users.score')
                ->where('objets.idObjet','=',$id)
                ->get();;
            $idvendeur=$userreq[0]->id;
            $score=$userreq[0]->score;
            $nomObjet = $objreq[0]->nomObjet;
            
            //on incrémente le score et pouf on le remet dans la bdd
            $score++;
            
            DB::table('users')
            ->where('id', $idvendeur)
            ->update(['score' => $score]);
            
            //on ajoute une notif dans la bdd pour l'afficher sur le panel du vendeur
            
            $message = "L'utilisateur ".$user->name." est interessé par votre objet : ".$nomObjet.". Vous pouvez le contacter à ".$user->email;
            DB::table('notifs')->insert(['idVendeur' => $idvendeur, 'contenu' => $message]);
            
            
            return redirect('/')->with('status', "L'utilisateur a été informé de votre intérêt !");
        }
        return redirect('/')->with('status', "Erreur!");
    }
    
    public function delete($id)
    {
        $user = Auth::user();
        if ($user!=NULL){
            DB::table('objets')->where('idObjet', '=', $id)->delete();
            
            return redirect('/')->with('status', "Votre objet est bien supprimé !");
        }
        return redirect('/')->with('status', "Erreur!");
    }
    
    public function viewPanel()
    {
        $user = Auth::user();
        $notifs = DB::table('notifs')->where('idVendeur',$user->id)->get();
        if ($user!=NULL){
            return view('viewPanel',compact('user'), compact('notifs'));
        }
    }
}
