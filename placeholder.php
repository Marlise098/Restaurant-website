```php
<?php include 'films.php'; ?>

<link rel="stylesheet" href="assets/css/movie-overview.css">

<div id="movie-overview" class="movie-overview">

    <div class="movie-header">
        <h1>FILM AGENDA</h1>
    </div>

    <nav class="navigation">

        <i class="fa-solid fa-bars"></i>

        <button class="filter-button">Films</button>
        <button class="filter-button">Vandaag</button>
        <button class="filter-button">Deze week</button>

        <div class="filter-options">
            <select id="genre" name="genre">
                <option value="">Categorie</option>
                <option value="actie">Actie</option>
                <option value="avontuur">Avontuur</option>
                <option value="animatie">Animatie</option>
                <option value="comedy">Comedy</option>
                <option value="drama">Drama</option>
            </select>
        </div>

    </nav>

    <section class="film-grid">

        <?php foreach ($films as $film): ?>

            <article class="film-card">

                <!-- Placeholder afbeelding -->
                <img src="assets/images/placeholder.jpg" alt="Filmposter">

                <div class="film-info">

                    <!-- Placeholder titel -->
                    <h2>FILM TITEL</h2>

                    <!-- Placeholder rating -->
                    <div class="rating">
                        ★★★★★
                    </div>

                    <!-- Placeholder release -->
                    <p class="release">
                        Release: 00-00-0000
                    </p>

                    <!-- Placeholder omschrijving -->
                    <p class="description">
                        Hier komt de omschrijving van de film te staan.
                    </p>

                    <a class="button" href="#">
                        MEER INFO & TICKETS
                    </a>

                </div>

            </article>

        <?php endforeach; ?>

    </section>

    <button class="more-films-button">
        <a href="movie-overview.php">
            BEKIJK ALLE FILMS
        </a>
    </button>

</div>
```
