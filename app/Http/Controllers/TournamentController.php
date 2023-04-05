<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Nette\Schema\Schema as SchemaSchema;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournaments = Tournament::all();

        $data = [
            "tournaments" => $tournaments
        ];

        return view('tournaments.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required'
        ]);

        Tournament::create([
            'name' => $request->input('name'),
            'start_date' => $request->input('start_date')
        ]);

        Schema::connection('mysql')->create('tabella_'.$request['name'], function ($table) {
            $table->id();
            $table->integer('CurrentRoundNumber');
            $table->integer('Number');
            $table->string('player_1');
            $table->string('player_2');
            $table->string('results');
        });

        return redirect()->route('tournaments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        DB::table('users_tournaments')->where('nome_torneo', '=', $tournament->name)->delete();
        Schema::dropIfExists('tabella_'.$tournament->name);
        return redirect()->route('tournaments.index');
    }
}
