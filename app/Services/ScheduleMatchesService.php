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
        //$this->scheuleQuarterFinalMatches();
        //$this->scheuleSemiFinal();
        //$this->scheuleFinal();
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
                        $scheduleTeams = [$teams[$i]['id'], $teams[$j]['id']];
                        $winningTeamKey = array_rand($scheduleTeams);
                        $losingTeamKey = 0;
                        if ($winningTeamKey == 0) {
                            $losingTeamKey = 1;
                        }
                        $data = [
                            'tournament_id' => $this->tournamentId,
                            'teama_id' => $teams[$i]['id'],
                            'teamb_id' => $teams[$j]['id'],
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
}