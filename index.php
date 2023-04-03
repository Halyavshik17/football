<?php

// https://en.wikipedia.org/wiki/Round-robin_tournament

$teams = [
    "Ливерпуль", "Челси", "Тоттенхэм Хотспур", "Арсенал", 
    "Манчестер Юнайтед", "Эвертон", "Лестер Сити", "Вест Хэм Юнайтед", 
    "Уотфорд", "Борнмут", "Бернли", "Саутгемптон", 
    "Брайтон энд Хоув Альбион", "Норвич Сити", "Шеффилд Юнайтед", "Фулхэм", 
    "Сток Сити", "Мидлсбро", "Суонси Сити", "Дерби Каунти"
];

$teamsCount = count($teams);
$toursCount = (count($teams) - 1) * 2;

$schedule = [];

for ($tour = 1; $tour <= $toursCount; $tour++) {
    $matches = array();
    for ($i = 0; $i < $teamsCount / 2; $i++) {
        if ($tour % 2 == 0) {
            $matches[] = array($teams[$i], $teams[$teamsCount - 1 - $i]);
        } else {
            $matches[] = array($teams[$teamsCount - 1 - $i], $teams[$i]);
        }
    }
    $schedule[] = $matches;
    // Rotate
    $first = array_shift($teams);
    array_unshift($teams, array_pop($teams));
    array_unshift($teams, $first);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="w-2/3 mx-auto">
        <?php for ($tour = 1; $tour <= $toursCount; $tour++): ?>
            <div class="w-full mt-2 mb-2">
                <span class="bg-green-100 text-green-700 py-1 px-7 rounded-full text-xs">Тур: <?php echo $tour ?></span>
            </div>
            <div class="paginate table-fixed bg-white shadow-md rounded">
                <table class="min-w-full text-left md:text-center divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="w-2/5 px-6 py-2 text-sm font-medium text-gray-500 uppercase">
                                Хозяева
                            </th>
                            <th scope="col" class="w-1/5 px-6 py-2 text-sm font-medium text-gray-500 uppercase">
                                Счет
                            </th>
                            <th scope="col" class="w-2/5 px-6 py-2 text-sm font-medium text-gray-500 uppercase">
                                Гости
                            </th>
                        </tr>
                    </thead>
                    <?php foreach ($schedule[$tour - 1] as $team): ?> 
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-2 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo $team[0] ?></div>
                                </td>
                                <td class="px-6 py-2 whitespace-nowrap">
                                    <div class="score text-sm text-gray-900">-:-</div>
                                </td>
                                <td class="px-6 py-2 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo $team[1] ?></div>
                                </td>
                            </tr>
                        </tbody>
                    <?php endforeach ?>
                </table>
            </div>
        <?php endfor ?>
    </div>

    <script>
        $("table tbody tr td").click(function() {
            var team = $(this).find("div:first-of-type").text();
            
            if($(this).find("div.score").text() === team)
                return;

            $("table tbody tr td").each(function() {
                if ($(this).find("div:first-of-type").text() === team || 
                    $(this).find("div:nth-of-type(3)").text() === team) {
                    $(this).addClass("bg-green-200");
                    
                } else {
                    $(this).removeClass("bg-green-200");
                }
            });
        });
    </script>

</body>
</html>