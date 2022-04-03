<?php /* Template Name: Singular Movie page  */ ?>
<?php get_template_part("header") ?>


<?php wp_body_open(); ?>

<?php $movieID = get_query_var('movieID');

      if($movieID){
          $movie = movieGetMovie($movieID);
      } else{
          status_header(404);
          echo "Error, no movie ID specified";
          die();
      }

      $movieName = array_key_exists('original_title', $movie) ? $movie['original_title'] : '';
      $movieRating = array_key_exists('vote_average', $movie) ? $movie['vote_average'] : 0;
      $movieRating = ($movieRating == 0) ? "NR" : $movieRating .  " / 10";
      $imdbURL = array_key_exists('imdb_id', $movie) ? "https://www.imdb.com/title/{$movie['imdb_id']}/" : '';
      $overview = array_key_exists('overview', $movie) ? $movie['overview'] : '';
      $tmdbConfig = movieGetTMDB()->getConfigurationData();
      $posterBase = $tmdbConfig["images"]["secure_base_url"].'w500/';
      $posterImage = array_key_exists('poster_path', $movie) ? $posterBase . $movie['poster_path'] : '';
      $movieID =  array_key_exists('id', $movie) ? $movie['id'] : '';

?>
<div class="movieSingular">
    <div class="titleBar fullWidth">
        <div class="titleBarBGLayer fullWidth">
            <div class="container titleContainer">
            </div>
        </div>
    </div>
    <div class="body-bg">
        <div class="container">

            <div class="content">
                <div class="col-third poster">
                <?php if($posterImage) {
                    echo "<img src='{$posterImage}' />";
                }?>
                </div>
                <div class="two-thirds movieDetails">
                    <h1><?php echo $movieName ?></h1>
                    <i class='fa fa-star rating'></i><?php echo "{$movieRating}"; ?><br>
                    <?php echo "<p>{$overview}</p>"; ?>
                    <?php if($imdbURL) echo "<a href='$imdbURL' target='_blank'>Read more on IMDB</a>"; ?> <br>
                    <div class='setWatchedContainer' data-id='<?php echo $movieID ?>'>
                        I've watched this <br>
                        <a class='button setUnwatched'><i class='fa fa-close' aria-hidden='true'></i></a> <a class='button setWatched'><i class='fa fa-check' aria-hidden='true'></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
get_template_part("footer"); ?>