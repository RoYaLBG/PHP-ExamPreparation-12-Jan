<?php
$_GET = array (
    'list' => 'The Hobbit: The Battle of the Five Armies (adventure)- Ian McKellen, Martin Freeman, Richard Armitage, Cate Blanchett / 300
Night at the Museum: Secret of the Tomb (comedy)- Ben Stiller, Robin Williams, Owen Wilson, Dick Van Dyke / 200
Annie (comedy)- Quvenzhane Wallis, Cameron Diaz, Jamie Foxx, Rose Byrne / 160
Night at the Museum: Secret of the Tomb (comedy)- Ben Stiller, Robin Williams, Owen Wilson, Dick Van Dyke / 180
Exodus: Gods and Kings (action)- Christian Bale, Joel Edgerton, Ben Kingsley, Sigourney Weaver / 250',
    'minSeats' => '160',
    'maxSeats' => '300',
    'filter' => 'all',
    'order' => 'ascending',
);


$list = $_GET['list'];
$rows = preg_split("/\r?\n/", $_GET['list'], -1, PREG_SPLIT_NO_EMPTY);
$order = $_GET['order'];

$moviesInfo = [];

foreach ($rows as $row) {
    preg_match_all('/(.*?)\((.*?)\)-\s*(.*?)\s*\/\s*(\d+)/', $row, $matches);

    //if (empty($matches[0])) continue;
    if ($matches[4][0] < $_GET['minSeats'] || $matches[4][0] > $_GET['maxSeats']) continue;
    if (trim($matches[2][0]) != $_GET['filter'] && $_GET['filter'] !='all') continue;

    $moviesInfo[] = [
        'name' => trim($matches[1][0]),
        'genre' => trim($matches[2][0]),
        'stars' => trim($matches[3][0]),
        'seats' => intval($matches[4][0])
    ];
}

usort($moviesInfo, function($a, $b) use ($order) {
    $compare = strcmp($a['name'], $b['name']);

    if ($compare === 0) {
        return $a['seats'] > $b['seats'];
    }

    if ($order == 'descending') {
        $compare *= -1;
    }

    return $compare;
});

foreach ($moviesInfo as $movie) {
    $name = htmlspecialchars($movie['name']);

    echo <<<EOL
<div class="screening"><h2>$name</h2><ul>
EOL;
    $stars = explode(",", $movie['stars']);
    foreach ($stars as $star) {
        echo '<li class="star">' . htmlspecialchars(trim($star)) . '</li>';
    }
    echo "</ul>";
    echo '<span class="seatsFilled">' . $movie['seats'] . ' seats filled</span>';
    echo "</div>";
}