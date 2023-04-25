<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentSchedulerRequest;
use App\Models\Tournament;
use App\Models\Group;

class TournamentController extends Controller
{
    /**
     * This function is used for generate the scheduler of tournament
     * @params TournamentSchedulerRequest $request
     */
    public function scheduler(TournamentSchedulerRequest $request)
    {
        $tournament = $this->addTournament($request->get('tournament_name'));
        $this->addGroupsTeams($tournament->id, $request->get('groupa_teams'));
    }

    /**
     * This function is used for add the tournament
     * @params string $name
     */
    private function addTournament($name)
    {
        return Tournament::create([
            'name' => $name
        ]);
    }

    /**
     * This function is used for add the groups and teams
     * @params int $tournament_id
     * @params int $noOfTeams
     */
    private function addGroupsTeams($tournament_id, $noOfTeams)
    {
        $groupA = $this->addGroup($tournament_id, config('app.group_names')[0]);
        $groupB = $this->addGroup($tournament_id, config('app.group_names')[1]);
        
    }

    /**
     * This function is used for add the group
     * @params int $tournament_id
     * @params string $name
     */
    private function addGroup($tournament_id, $name)
    {
        return Group::create([
            'tournament_id' => $tournament_id,
            'name' => $name
        ]);
    }
}
