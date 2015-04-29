<?php

$_GET['text'] = <<<KUF
Pesho Meshev;2-9-2014;Sometimes I post very deep messages on facebook that have nothing to do with who I am or what I do, but I like people to think that I'm very, very deep; 160;  Confession of the century/hahaha this is so NOT funny

Chico Tashko;06-06-2014;Zasqh piperite i jinite, vreme e za rakiq;2345;

KUF;

date_default_timezone_set('Europe/Sofia');
$text = $_GET['text'];
$data = explode("\n", $text);
$facebook = [];

foreach ($data as $row) {
    if (!trim($row)) continue;
    $info = explode(";", $row);
    $facebook[] = [
        'author' => trim($info[0]),
        'date' => date_create($info[1]),
        'post' => trim($info[2]),
        'likes' => intval($info[3]),
        'comments' => explode("/", $info[4])
    ];
}

usort($facebook, function($a, $b) {
   return $a['date'] < $b['date'];
});

foreach ($facebook as $post) {
    $author = htmlspecialchars($post['author']);
    $date = $post['date']->format('j F Y');
    $status = htmlspecialchars($post['post']);
    $likes = $post['likes'];
    $comments = $post['comments'];
    echo <<<DDS
<article><header><span>$author</span><time>$date</time></header><main><p>$status</p></main><footer><div class="likes">$likes people like this</div>
DDS;
    if (!empty($comments) && !empty($comments[0])) {
        echo '<div class="comments">';
        foreach ($comments as $comment) {
            echo "<p>" . htmlspecialchars(trim($comment)) . "</p>";
        }
        echo '</div>';
    }
    echo '</footer></article>';
}
