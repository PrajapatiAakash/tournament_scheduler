<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentSchedulerRequest;
use App\Models\Tournament;
use App\Models\Group;
use App\Models\Team;
use App\Models\TMatch;
use App\Services\ScheduleMatchesService;

class TournamentController extends Controller
{
    /**
     * This function is used for generate the scheduler of tournament
     * @params TournamentSchedulerRequest $request
     */
    public function scheduler(TournamentSchedulerRequest $request)
    {
        $tournament = $this->addTournament($request->get('tournament_name'));
        $groupA = $this->addGroup($tournament->id, config('app.group_names')[0]);
        $groupB = $this->addGroup($tournament->id, config('app.group_names')[1]);
        $this->addTeams($tournament->id, $groupA, $request->get('groupa_teams'));
        $this->addTeams($tournament->id, $groupB, $request->get('groupa_teams') + 1);
        (new ScheduleMatchesService($tournament->id, $request->get('groupa_teams')))->schedule();

        return redirect()->route('tournament.view', ['id' => $tournament->id]);
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
     * This function is used for add the group
     * @params int $tournamentId
     * @params string $name
     */
    private function addGroup($tournamentId, $name)
    {
        return Group::create([
            'tournament_id' => $tournamentId,
            'name' => $name
        ]);
    }

    /**
     * This function is used for add the group
     * @params int $tournamentId
     * @params obj $group
     * @params int $totalNoOfTeams
     */
    private function addTeams($tournamentId, $group, $totalNoOfTeams)
    {
        for ($i = 1; $i <= $totalNoOfTeams; $i++) {
            $teamName = "Team-" . $i;
            $this->addTeam($tournamentId, $group->id, $teamName);
        }
    }

    /**
     * This function is used for add the team
     * @params int $tournamentId
     * @params int $groupId
     * @params string $name
     */
    private function addTeam($tournamentId, $groupId, $name)
    {
        return Team::create([
            'tournament_id' => $tournamentId,
            'group_id' => $groupId,
            'name' => $name
        ]);
    }

    /**
     * This function is used for display the tournament view
     * @params int $tournamentId
     */
    public function view($tournamentId)
    {
        $groups = Group::with('teams')
            ->where('tournament_id', $tournamentId)->get();
        $matches = TMatch::with(['teamAName', 'teamBName', 'winningTeamName'])
            ->where('tournament_id', $tournamentId)
            ->orderBy('id', 'DESC')
            ->get();

        return view('tournament_view', compact('groups', 'matches'));
    }
}
