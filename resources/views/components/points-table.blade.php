<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full text-left text-sm font-light">
            <tbody>
                @foreach ($groups as $key => $group)
                    <tr>
                        <th scope="col" class="px-6 py-4" colspan="5">{{$group->name}}</th>
                    </tr>
                    @if ($key == 0)
                        <tr>
                            <th scope="col" class="px-6 py-4">Team Name</th>
                            <th scope="col" class="px-6 py-4">M</th>
                            <th scope="col" class="px-6 py-4">W</th>
                            <th scope="col" class="px-6 py-4">L</th>
                            <th scope="col" class="px-6 py-4">Points</th>
                        </tr>
                    @endif
                    @foreach ($group->teams as $team)
                        <tr class="border-b dark:border-neutral-500">
                            <td class="whitespace-nowrap px-6 py-4 font-medium">{{$team->name}}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{$team->total_number_of_matches}}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{$team->total_number_of_winning_matches}}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{$team->total_number_of_losing_matches}}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{$team->points}}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>