<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function getPairingsPage()
    {
        $torneo = Cache::get('torneo');

        $roundNumber = DB::table('tabella_' . $torneo)
            ->max('CurrentRoundNumber');

        $roundData = DB::table('tabella_' . $torneo)
            ->where('CurrentRoundNumber', $roundNumber)
            ->get()
            ->toArray();

        $id_player1 = DB::table('tabella_' . $torneo)
            ->where('CurrentRoundNumber', $roundNumber)
            ->get('player_1')
            ->toArray();

        $id_player2 = DB::table('tabella_' . $torneo)
            ->where('CurrentRoundNumber', $roundNumber)
            ->get('player_2')
            ->toArray();

        foreach ($id_player1 as $key => $value) {
            $nome_player1[] = DB::table('players')
                ->where('player_id', '=', $id_player1[$key]->player_1)
                ->get()
                ->toArray();

            $nome_player2[] = DB::table('players')
                ->where('player_id', '=', $id_player2[$key]->player_2)
                ->get()
                ->toArray();
        }

        foreach ($roundData as $key => $value) {
            $firstName1[] = implode(',', array_column($nome_player1[$key], 'FirstName'));
            $lastName1[] = implode(',', array_column($nome_player1[$key], 'LastName'));

            $firstName2[] = implode(',', array_column($nome_player2[$key], 'FirstName'));
            $lastName2[] = implode(',', array_column($nome_player2[$key], 'LastName'));
            //dump($lastName1);
        }

        $data = [
            'roundData' => $roundData,
            'firstName1' => $firstName1,
            'lastName1' => $lastName1,
            'firstName2' => $firstName2,
            'lastName2' => $lastName2
        ];

        return view('user.pairings', $data);
    }

    public function getStandingsPage()
    {
        $stats = DB::table('statistics')
            ->where('eventname', '=', Cache::get('torneo'))
            ->orderBy('rank', 'ASC')
            ->get()
            ->toArray();
        $id_player = DB::table('statistics')
            ->where('eventname', '=', Cache::get('torneo'))
            ->orderBy('rank', 'ASC')
            ->get('name');
        $nome = array();
        foreach ($id_player as $key => $value) {
            $nome[] = DB::table('players')
                ->where('teams_id', '=', $id_player[$key]->name)
                ->get()
                ->toArray();
        }
        dd($nome);
        foreach ($stats as $index => $value) {
            $stats[$index];
            $firstName[] = implode(',', array_column($nome[$index], 'FirstName'));
            $lastName[] = implode(',', array_column($nome[$index], 'LastName'));
        }
        //dd($lastName);
        $data = [
            'stats' => $stats,
            'firstName' => $firstName,
            'lastName' => $lastName
        ];
        return view('user.standings', $data);
    }

    public function index()
    {
        $tournaments  = DB::table('users_tournaments')
            ->where('email_utente', '=', Auth::user()->email)
            ->get('nome_torneo');

        $torneo  = DB::table('users_tournaments')
            ->where('email_utente', '=', Auth::user()->email)
            ->value('nome_torneo');

        // return response()->json($tournaments);

        Cache::put('torneo', $torneo);

        $data = [
            'tournaments' => $tournaments
        ];

        return view('user.index', $data);
    }

    public function RedirectToPersonal()
    {
        $torneo = Cache::get('torneo');
        //return $torneo;
        $player_id = DB::table('players')
            ->where('FirstName', '=', Auth::user()->firstName)
            ->where('LastName', '=', Auth::user()->lastName)
            ->value('player_id');

        $player_data = DB::table('tabella_' . $torneo)
            ->orderByDesc('CurrentRoundNumber')
            ->where('player_1', '=', $player_id)
            ->orWhere('player_2', '=', $player_id)
            ->get()
            ->toArray();
        //dump($player_data);

        $first = DB::table('tabella_' . $torneo)
            ->selectRaw('player_2 as opponent_id')
            ->where('player_1', $player_id);

        $opponents_id = DB::table('tabella_' . $torneo)
            ->selectRaw('player_1 as opponent_id')
            ->orderByDesc('CurrentRoundNumber')
            ->where('player_2', $player_id)
            ->union($first)
            ->get()
            ->toArray();

        $opponents = array();
        foreach ($opponents_id as $key => $value) {
            //dump($opponents_id[$key]);
            $opponents[] = DB::table('players')
                ->where('player_id', '=', $opponents_id[$key]->opponent_id)
                ->get(['FirstName', 'LastName'])
                ->toArray();
        }
        foreach ($opponents_id as $index => $value) {
            $opponents_id[$index];
            $firstName[] = implode(',', array_column($opponents[$index], 'FirstName'));
            $lastName[] = implode(',', array_column($opponents[$index], 'LastName'));
        }
        
        //dump($firstName);
        //dump($names);

        $data = [
            "player_data" => $player_data,
            "firstName" => $firstName,
            "lastName" => $lastName,
        ];
        return view('user.personal', $data);
    }
}
