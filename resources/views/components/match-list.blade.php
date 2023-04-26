<div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
    @foreach ($matches as $key => $match)
        <div class="group relative">
            <div class="mt-4 flex justify-between">
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