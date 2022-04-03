<?php
// This file expects a variable $movie  and $posterBases to be set
if(isset($movie, $posterBases)) {

    // Prepare variables for interpolation
    $movieTitle = array_key_exists('original_title', $movie) ? $movie['original_title'] : '';
    $movieOverview = array_key_exists('overview', $movie) ? $movie['overview'] : '';
    $posterPath = ""; // Should have a default image here
    $movieId =  array_key_exists('id', $movie) ? $movie['id'] : '';
    $rating = array_key_exists('vote_average', $movie) ? $movie['vote_average'] : 0;
    $rating = ($rating != 0) ? $rating .  " / 10" : "NR";
    $imdbURL = array_key_exists('imdb_id', $movie) ? "https://www.imdb.com/title/{$movie['imdb_id']}/" : '';
    $movieID =  array_key_exists('id', $movie) ? $movie['id'] : '';
    $movieLink = $movieID ? "/movie/?movieID={$movieID}" : '';
    $posterImage = '';

    // Get popularmovies unfortunately never returns an imdbURL
    $imdbButton = $imdbURL ? "<a href='{$imdbURL}' class='button details'>DETAILS</a>" : "";
    if(array_key_exists("poster_path", $movie)){
        $posterPath = $posterBases['w500'] . $movie['poster_path'];
    }
    if($movieLink && $posterPath){
        $posterImage = "<a href='{$movieLink}'><img src='{$posterPath}' alt='{$movieTitle}' class='coverImage' /></a>";
    } else{
        if($posterPath) {
            $posterImage = "<img src='{$posterPath}' class='coverImage'>";
        }
    }

    // We simply return an interpolated string for simplicity
return " 
<div class='fullWidth movie'>
    <div class='card' data-id='{$movieId}'>
        <div class='coverImageContainer'>
            {$posterImage}
        </div>
         <div class='movieInfo'>
            <div class='watchedIndicator'>
                <i class='fa fa-check'></i>
            </div>
            <h2>{$movieTitle}</h2>
            <i class='fa fa-star'></i>{$rating}<br>
            <p>$movieOverview</p>
              
        </div>
        {$imdbButton}
        <div class='setWatchedContainer' data-id='{$movieId}'>
            I've watched this <br>
            <a class='button setUnwatched'><i class='fa fa-close' aria-hidden='true'></i></a> <a class='button setWatched'><i class='fa fa-check' aria-hidden='true'></i></a>            
        </div>
    </div>
</div>";
} else{
    return false;
}