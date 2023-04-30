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
        $tournament = $this->addTournament($request->get('tournament_name'), $request->get('groupa_teams'));
        $groupA = $this->addGroup($tournament->id, config('app.group_names')[0]);
        $groupB = $this->addGroup($tournament->id, config('app.group_names')[1]);
        $this->addTeams($tournament->id, $groupA, $request->get('groupa_teams'));
        $this->addTeams($tournament->id, $groupB, $request->get('groupa_teams') + 1, true);
        (new ScheduleMatchesService($tournament->id, $request->get('groupa_teams')))->schedule();

        return redirect()->route('tournament.view', ['tournament' => $tournament->id]);
    }

    /**
     * This function is used for add the tournament
     * @params string $name
     * @params int $noOfTeams
     */
    private function addTournament($name, $noOfTeams)
    {
        return Tournament::create([
            'name' => $name,
            'no_of_teams' => $noOfTeams
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
     * @params bool $isExtraTeam
     */
    private function addTeams($tournamentId, $group, $totalNoOfTeams, $isExtraTeam = false)
    {
        for ($i = 1; $i <= $totalNoOfTeams; $i++) {
            $teamName = "Team-" . $i;
            $extraFields = [];
            if ($isExtraTeam && $i == $totalNoOfTeams) {
                $extraFields['is_extra_team'] = true;
            }
            $this->addTeam($tournamentId, $group->id, $teamName, $extraFields);
        }
    }

    /**
     * This function is used for add the team
     * @params int $tournamentId
     * @params int $groupId
     * @params string $name
     * @params array $extraFields
     */
    private function addTeam($tournamentId, $groupId, $name, $extraFields)
    {
        return Team::create(
            array_merge([
                'tournament_id' => $tournamentId,
                'group_id' => $groupId,
                'name' => $name
            ], $extraFields)
        );
    }

    /**
     * This function is used for display the tournament view
     * @params obj $tournament
     */
    public function view(Tournament $tournament)
    {
        $groups = Group::with('teams')
            ->where('tournament_id', $tournament->id)->get();
        $matches = TMatch::with(['teamAName', 'teamBName', 'winningTeamName'])
            ->where('tournament_id', $tournament->id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('tournament_view', compact('tournament', 'groups', 'matches'));
    }
}
