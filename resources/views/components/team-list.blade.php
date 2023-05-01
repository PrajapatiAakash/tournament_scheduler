<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
          <table class="min-w-full text-left text-sm font-light">
            <tbody>
                <tr>
                    <th scope="col" class="px-6 py-4">{{$groupWiseTeamList[0]['name']}}</th>
                    <th scope="col" class="px-6 py-4">{{$groupWiseTeamList[1]['name']}}</th>
                </tr>
                <tr>
                    <th scope="col" class="px-6 py-4">Team Name</th>
                    <th scope="col" class="px-6 py-4">Team Name</th>
                </tr>
                @foreach ($groupWiseTeamList[0]['teams'] as $teamKey => $team)
                    <tr class="border-b dark:border-neutral-500">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{$team['name']}}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{$groupWiseTeamList[1]['teams'][$teamKey]['name']}}</td>
                    </tr>
                @endforeach
                <tr class="border-b dark:border-neutral-500">
                    <td class="whitespace-nowrap px-6 py-4 font-medium"></td>
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{$groupWiseTeamList[1]['teams'][$teamKey+1]['name']}}</td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>