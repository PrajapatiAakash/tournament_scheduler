<?php
namespace App\Services;

use App\Models\Group;
use App\Models\TMatch;
use App\Models\Team;

class ScheduleMatchesService
{
    private $roundTypes = [
        'league_stage' => 'league_stage',
        'quarter_final' => 'quarter_final',
        'semi_final' => 'semi_final',
        'final' => 'final'
    ];
    private $tournamentId = null;
    private $noOfTeams = null;

    function __construct($tournamentId, $noOfTeams) {
        $this->tournamentId = $tournamentId;
        $this->noOfTeams = $noOfTeams;
    }

    /**
     * This function is used for schedule the matches for the tournament
     */
    public function schedule()
    {
        if ($this->noOfTeams > 4) {
            $this->scheduleLeagueMatches();
        }
        $this->scheduleQuarterFinalMatches();
        $this->scheduleSemiFinal();
        $this->scheduleFinal();
    }

    /**
     * This function is used for set the league matches
     */
    private function scheduleLeagueMatches()
    {
        $matches = [];
        $groups = Group::with('teams')->where('tournament_id', $this->tournamentId)->get();
        if ($groups) {
            foreach ($groups as $group) {
                $teams = $group->teams->toArray();
                for ($i = 0; $i < count($teams); $i++) {
                    for ($j = $i + 1; $j < count($teams); $j++) {
                        for ($k = 0; $k <= 1; $k++) {
                            $scheduleTeams = [$teams[$i]['id'], $teams[$j]['id']];
                            $winningTeamKey = array_rand($scheduleTeams);
                            $losingTeamKey = 0;
                            if ($winningTeamKey == 0) {
                                $losingTeamKey = 1;
                            }
                            $data = [
                                'tournament_id' => $this->tournamentId,
                                'teama_id' => $scheduleTeams[0],
                                'teamb_id' => $scheduleTeams[1],
                                'round_type' => $this->roundTypes['league_stage'],
                                'winner_team_id' => $scheduleTeams[$winningTeamKey]
                            ];
                            $match = $this->addMatch($data);
                            $this->updateWinningTeam($scheduleTeams[$winningTeamKey]);
                            $this->updateLosingTeam($scheduleTeams[$losingTeamKey]);
                        }
                    }    
                }
            }
        }
    }

    /**
     * This function is used for save the match
     * @params array $data
     */
    private function addMatch($data)
    {
        return TMatch::create($data);
    }

    /**
     * This function is used for save the match
     * @params int $teamId
     */
    private function updateWinningTeam($teamId)
    {
        return Team::where('id', $teamId)
            ->update([
                'points' => \DB::raw( 'points + 2' ),
                'total_number_of_matches' => \DB::raw( 'total_number_of_matches + 1' ),
                'total_number_of_winning_matches' => \DB::raw( 'total_number_of_winning_matches + 1' )
            ]);
    }

    /**
     * This function is used for save the match
     * @params int $teamId
     */
    private function updateLosingTeam($teamId)
    {
        return Team::where('id', $teamId)
            ->update([
                'total_number_of_matches' => \DB::raw( 'total_number_of_matches + 1' ),
                'total_number_of_losing_matches' => \DB::raw( 'total_number_of_losing_matches + 1' )
            ]);
    }

    /**
     * This function is used for schedule the quarter final matches
     */
    private function scheduleQuarterFinalMatches()
    {
        $groupWiseTeams = [];
        if ($this->noOfTeams > 4) {
            $groupWiseTeams = $this->getQuarterFinalTeamsBased(true);
        } else {
            $groupWiseTeams = $this->getQuarterFinalTeamsBased();
        }
        $keys = array_keys($groupWiseTeams);
        foreach ($groupWiseTeams[$keys[0]] as $key => $team) {
            $this->addMatchHelper($team, $groupWiseTeams[$keys[1]][$key], $this->roundTypes['quarter_final']);
        }
    }

    /**
     * This function is used for get the quarter final teams
     */
    private function getQuarterFinalTeamsBased($isBasedOnPoint = false)
    {
        $groupWiseTeams = [];
        $groups = \DB::table('groups')
            ->where('tournament_id', $this->tournamentId)
            ->select('id')
            ->pluck('id')
            ->toArray();
        if ($groups) {
            foreach ($groups as $group) {
                $teams = \DB::table('teams')
                    ->where('group_id', $group);
                if ($isBasedOnPoint) {
                    $teams = $teams->orderBy('points', 'DESC');
                } else {
                    $teams = $teams->orderBy('id', 'ASC');
                }
                $teams = $teams ->limit(4)
                    ->pluck('id')
                    ->toArray();
                $groupWiseTeams[$group] = $teams;
            }
            if (isset($groups[1])) {
                $team = \DB::table('teams')
                    ->where('group_id', $groups[1])
                    ->where('is_extra_team', true)
                    ->pluck('id')
                    ->first();
                if (!in_array($team, $groupWiseTeams[$groups[1]])) {
                    $groupWiseTeams[$groups[1]][count($groupWiseTeams[$groups[1]]) - 1] = $team;
                }
            }
        }

        return $groupWiseTeams;
    }

    /**
     * This function is used for set the semi final matches
     */
    private function scheduleSemiFinal()
    {
        $matches = TMatch::where('tournament_id', $this->tournamentId)
            ->where('round_type', $this->roundTypes['quarter_final'])
            ->get()
            ->toArray();
        $this->addMatchHelper($matches[0]['winner_team_id'], $matches[1]['winner_team_id'], $this->roundTypes['semi_final']);
        $this->addMatchHelper($matches[2]['winner_team_id'], $matches[3]['winner_team_id'], $this->roundTypes['semi_final']);
    }

    /**
     * This function is used for set the semi final matches
     */
    private function scheduleFinal()
    {
        $matches = TMatch::where('tournament_id', $this->tournamentId)
            ->where('round_type', $this->roundTypes['semi_final'])
            ->get()
            ->toArray();
        $this->addMatchHelper($matches[0]['winner_team_id'], $matches[1]['winner_team_id'], $this->roundTypes['final']);
    }

    /**
     * This function is used for add match helper
     * @params int $teamA
     * @params int $teamB
     * @params string $roundType
     */
    private function addMatchHelper($teamA, $teamB, $roundType)
    {
        $scheduleTeams = [$teamA, $teamB];
        $data = [
            'tournament_id' => $this->tournamentId,
            'teama_id' => $scheduleTeams[0],
            'teamb_id' => $scheduleTeams[1],
            'round_type' => $roundType,
            'winner_team_id' => $scheduleTeams[array_rand($scheduleTeams)]
        ];
        $this->addMatch($data);
    }
}