<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use Illuminate\Http\Request;

class VoitureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $voitures = Voiture::with('modele',
            'transmission',
            'carburant',
            'carrosserie',
            'modele.constructeur',
            'photos')->get();
        return response()->json($voitures);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prixVente = $request->prix + ($request->prix)/4;

        $nouvelleVoiture = Voiture::create([
            'date_arrivee' => $request->date_arrivee,
            'prix' => $prixVente,
            'modeleId' => $request->nom_modele,
            'transmissionId' => $request->transmissionId,
            'carburantId' => $request->carburantId,
            'carrosserieId' => $request->carroserieId,
        ]);

        return response()->json([
            'voiture' => $nouvelleVoiture,
            'message' => 'voiture enregistrer avec succes'
        ], 200);




    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Voiture $voiture
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voiture = Voiture::with('modele',
            'transmission',
            'carburant',
            'carrosserie',
            'modele.constructeur',
            'photos')->find($id);
        return response()->json($voiture);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Voiture $voiture
     * @return \Illuminate\Http\Response
     */
    public function edit(Voiture $voiture)
    {
        $voiture = Voiture::find($voiture);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Voiture $voiture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
       
        $voiture = Voiture::find($id);

        $voiture->update([
            'date_arrivee' => $request->date_arrivee,
            'prix' => $request->prix,
            'modeleId' => $request->nom_modele,
            'transmissionId' => $request->transmissionId,
            'carburantId' => $request->carburantId,
            'carrosserieId' => $request->carroserieId,
        ]);

        return response()->json([
            'voiture' => $voiture,
            'message' => 'voiture modifier avec succes'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Voiture $voiture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voiture $voiture)
    {
        $voiture->delete();
        return response()->json('voiture supprimer');
    }
}
