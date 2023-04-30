<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
    @foreach ($matches as $key => $match)
        <div
            @class([
                'group relative p-5',
                'bg-blue-500' => ($match['round_type'] == 'league_stage'),
                'bg-yellow-500' => ($match['round_type'] == 'quarter_final'),
                'bg-orange-500' => ($match['round_type'] == 'semi_final'),
                'bg-green-500' => ($match['round_type'] == 'final'),
            ])
            >
            <div class="flex justify-between">
                <div>
                    <span>
                        Round Type: {{$match->round_type}}
                    </span>
                    <br>
                    <span>
                        {{$match->teama_id}} vs {{$match->teamb_id}}
                    </span>
                    <br>
                    <span>
                        {{$match->winner_team_id}} won
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>