<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Tournament;

class AdminController extends Controller
{
    public function getRegistration()
    {
        return view('registration.registration');
    }

    public function getPanel()
    {
        return view('panel');
    }

    public function importFile(Request $request)
    {
        $filename = $request->file('users')->getClientOriginalName();
        $filename = $request->file('users')->storeAs('', $filename);
        $path = storage_path('app/' . $filename);

        $users = (new FastExcel)->import($path, function ($line) {
            DB::table('users_tournaments')->insert([
                'nome_torneo' => $line['tournament'],
                'email_utente' => $line['email'],
            ]);

            return User::firstOrCreate(
                [
                    'email' => $line['email'],
                    'firstName' => $line['firstName'],
                    'lastName' => $line['lastName'],
                    'role' => $line['role'],
                    'dci' => $line['dci'],
                    'country' => $line['country'],
                    'status' => $line['status'],
                ],
            );
        });
        return redirect('getPanel');
    }

    public function getResults()
    {
        return view('registration.results');
    }

    public function importResults(Request $request)
    {
        $json = file_get_contents($request->file('results'));
        $array = json_decode($json);
        $eventName = $array->data->EventName;
        $decoded = $array->data->MatchingTables;
        foreach ($decoded as $key => $value) {
            DB::table('tabella_' . $eventName)->insert([
                'currentRoundNumber' => $decoded[$key]->RoundNumber,
                'Number' =>  $decoded[$key]->Number,
                'player_1' => $decoded[$key]->Player1,
                'player_2' => $decoded[$key]->Player2,
                'results' => $decoded[$key]->GameWins1 . '-' . $decoded[$key]->GameWins2
            ]);
        }

        $players = $array->data->Persons;
        foreach ($players as $key => $value) {
            DB::table('players')->insert([
                'FirstName' => $players[$key]->FirstName,
                'LastName' => $players[$key]->LastName,
                'player_id' => $players[$key]->_id
            ]);
        }

        $stats = $array->data->Teams;
        foreach ($stats as $key => $value) {
            DB::table('statistics')->insert([
                'eventname' => $eventName,
                'rank' => $stats[$key]->Rank,
                'name' => $stats[$key]->_id,
                'points' => $stats[$key]->GamePoints,
                'OMW' => $stats[$key]->OpponentsMatchWinPercent,
                'Game_Win' => $stats[$key]->GameWinPercent,
                'OGW' => $stats[$key]->OpponentsGameWinPercent
            ]);

            DB::table('players')
                ->where('player_id', '=', $stats[$key]->Players)
                ->update([
                    'teams_id' => $stats[$key]->_id
                ]);
        }

        return redirect('getPanel');
    }
}
