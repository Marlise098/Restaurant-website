<?php

$films = [
    [
        "titel" => "JURASSIC WORLD: FALLEN KINGDOM",
        "afbeelding" => "assets/images/Dinosaur.jpg",
        "release" => "7-06-2018",
        "rating" => 5,
        "omschrijving" => "Welkom in Jurassic World: Fallen Kingdom! Favoriete personages keren terug in dit spannende spektakel."
    ],
    [
        "titel" => "DEADPOOL 2",
        "afbeelding" => "assets/images/Deadpool2.jpg",
        "release" => "17-05-2018",
        "rating" => 4,
        "omschrijving" => "Na het overleven van een bijna fatale nachtmerrie, wordt Wade Wilson geconfronteerd met een nieuwe dreiging."
    ],
    [
        "titel" => "SOLO: A STAR WARS STORY",
        "afbeelding" => "assets/images/StarWarsSolo.jpg",
        "release" => "23-05-2018",
        "rating" => 3,
        "omschrijving" => "Een compleet nieuw avontuur uit een galaxy far, far away."
    ],
    [
        "titel" => "PIETER KONIJN",
        "afbeelding" => "assets/images/pieter-konijn.jpg",
        "release" => "28-03-2018",
        "rating" => 4,
        "omschrijving" => "Verfilming van Beatrix Potters tijdloze verhaal over een eigenwijze konijn."
    ],
        [
        "titel" => "JURASSIC WORLD: FALLEN KINGDOM",
        "afbeelding" => "assets/images/Dinosaur.jpg",
        "release" => "7-06-2018",
        "rating" => 5,
        "omschrijving" => "Welkom in Jurassic World: Fallen Kingdom! Favoriete personages keren terug in dit spannende spektakel."
    ],
    [
        "titel" => "DEADPOOL 2",
        "afbeelding" => "assets/images/Deadpool2.jpg",
        "release" => "17-05-2018",
        "rating" => 4,
        "omschrijving" => "Na het overleven van een bijna fatale nachtmerrie, wordt Wade Wilson geconfronteerd met een nieuwe dreiging."
    ],
    [
        "titel" => "SOLO: A STAR WARS STORY",
        "afbeelding" => "assets/images/StarWarsSolo.jpg",
        "release" => "23-05-2018",
        "rating" => 3,
        "omschrijving" => "Een compleet nieuw avontuur uit een galaxy far, far away."
    ],
    [
        "titel" => "PIETER KONIJN",
        "afbeelding" => "assets/images/pieter-konijn.jpg",
        "release" => "28-03-2018",
        "rating" => 4,
        "omschrijving" => "Verfilming van Beatrix Potters tijdloze verhaal over een eigenwijze konijn."
    ],
        [
        "titel" => "JURASSIC WORLD: FALLEN KINGDOM",
        "afbeelding" => "assets/images/Dinosaur.jpg",
        "release" => "7-06-2018",
        "rating" => 5,
        "omschrijving" => "Welkom in Jurassic World: Fallen Kingdom! Favoriete personages keren terug in dit spannende spektakel."
    ],
    [
        "titel" => "DEADPOOL 2",
        "afbeelding" => "assets/images/Deadpool2.jpg",
        "release" => "17-05-2018",
        "rating" => 4,
        "omschrijving" => "Na het overleven van een bijna fatale nachtmerrie, wordt Wade Wilson geconfronteerd met een nieuwe dreiging."
    ],
    [
        "titel" => "SOLO: A STAR WARS STORY",
        "afbeelding" => "assets/images/StarWarsSolo.jpg",
        "release" => "23-05-2018",
        "rating" => 3,
        "omschrijving" => "Een compleet nieuw avontuur uit een galaxy far, far away."
    ],
    [
        "titel" => "PIETER KONIJN",
        "afbeelding" => "assets/images/pieter-konijn.jpg",
        "release" => "28-03-2018",
        "rating" => 4,
        "omschrijving" => "Verfilming van Beatrix Potters tijdloze verhaal over een eigenwijze konijn."
    ],
        [
        "titel" => "JURASSIC WORLD: FALLEN KINGDOM",
        "afbeelding" => "assets/images/Dinosaur.jpg",
        "release" => "7-06-2018",
        "rating" => 5,
        "omschrijving" => "Welkom in Jurassic World: Fallen Kingdom! Favoriete personages keren terug in dit spannende spektakel."
    ],
    [
        "titel" => "DEADPOOL 2",
        "afbeelding" => "assets/images/Deadpool2.jpg",
        "release" => "17-05-2018",
        "rating" => 4,
        "omschrijving" => "Na het overleven van een bijna fatale nachtmerrie, wordt Wade Wilson geconfronteerd met een nieuwe dreiging."
    ],
    [
        "titel" => "SOLO: A STAR WARS STORY",
        "afbeelding" => "assets/images/StarWarsSolo.jpg",
        "release" => "23-05-2018",
        "rating" => 3,
        "omschrijving" => "Een compleet nieuw avontuur uit een galaxy far, far away."
    ],
    [
        "titel" => "PIETER KONIJN",
        "afbeelding" => "assets/images/pieter-konijn.jpg",
        "release" => "28-03-2018",
        "rating" => 4,
        "omschrijving" => "Verfilming van Beatrix Potters tijdloze verhaal over een eigenwijze konijn."
    ]
];

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    require_once __DIR__ . '/api-connection.php';
    $remoteFilms = fetchMoviesFromApi();

    header('Content-Type: application/json; charset=utf-8');

    if (!is_array($remoteFilms)) {
        http_response_code(502);
        echo json_encode(['error' => 'De films konden niet van de externe site worden geladen.']);
        exit;
    }

    echo json_encode($remoteFilms);
    exit;
}

?>