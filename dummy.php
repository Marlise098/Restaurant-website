<?php include 'films.php'; ?>
<?php include 'header.php'; ?>
<link rel="icon" href="assets/images/annexbiosLogo.png" type="image/x-icon">
<script src="https://kit.fontawesome.com/a369785260.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="assets/css/movie-overview.css">
<link rel="stylesheet" href="assets/css/header.css">
<link rel="stylesheet" href="assets/css/footer.css">
<div id="movie-overview" class="movie-overview">
    <div class="movie-overview">
        <h1>FILM AGENDA</h1>
    </div>
<nav class="navigation">

            <i class="fa-solid fa-bars"></i>
            <button class="filter-button">Films</button>
            <button class="filter-button">Vandaag</button>
            <button class="filter-button">Deze week</button>

            <div class="filter-options">
                <div class="filter-dropdown">
                    <select id="genre" name="genre">
                        <option class="filter-option" value="">Categorie</option>
                        <option class="filter-option" value="actie">Actie</option>
                        <option class="filter-option" value="avontuur">Avontuur</option>
                        <option class="filter-option" value="animatie">Animatie</option>
                        <option class="filter-option" value="comedy">Comedy</option>
                        <option class="filter-option" value="drama">Drama</option>
                        <option class="filter-option" value="familie">Familie</option>
                        <option class="filter-option" value="fantasie">Fantasie</option>
                        <option class="filter-option" value="horror">Horror</option>
                        <option class="filter-option" value="romantiek">Romantiek</option>
                        <option class="filter-option" value="sci-fi">Sci-Fi</option>
                    </select>

                </div>

</nav>

        <!-- Films(tijdelijk) -->
        <section class="film-grid">

            <?php foreach ($films as $film): ?>
                <article class="film-card">

                    <img
                        src="<?= htmlspecialchars($film["afbeelding"]) ?>"
                        alt="<?= htmlspecialchars($film["titel"]) ?>"
                    >

                    <div class="film-info">

                        <h2>
                            <?= htmlspecialchars($film["titel"]) ?>
                        </h2>

                        <!-- Sterren -->
                        <div class="rating">

                            <?php for ($i = 1; $i <= 5; $i++): ?>

                                <?php if ($i <= $film["rating"]): ?>
                                    <span class="star">★</span>
                                <?php else: ?>
                                    <span class="empty-star">☆</span>
                                <?php endif; ?>

                            <?php endfor; ?>

                        </div>

                        <p class="release">
                            Release: <?= htmlspecialchars($film["release"]) ?>
                        </p>

                        <p class="description">
                            <?= htmlspecialchars($film["omschrijving"]) ?>
                        </p>

                        <a class="infobutton" href="#">
                            MEER INFO & TICKETS
                        </a>

                    </div>

                </article>



            <?php endforeach; ?>

</section>


                <button class="more-films-button"> 
                    <a href="movie-overview.php">BEKIJK ALLE FILMS</a>
                </button>

</div>

<?php include 'footer.php'; ?>