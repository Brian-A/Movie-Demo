<?php
add_action( 'wp_enqueue_scripts', 'movieEnqueueAssets' );
add_theme_support('html5', ['script', 'style']); // Remove extraneous attributes in HTML

$tmdbAPIKey = "";

function movieEnqueueAssets(){
    wp_enqueue_script('movie-scripts', get_template_directory_uri() . '/js/scripts.min.js', array(), wp_get_theme()->get( 'Version' ), true);
    wp_enqueue_style( 'movie-styles', get_template_directory_uri() . '/style.css', [], wp_get_theme()->get( 'Version' ));

}

function movieTMDBUpdateConfig(){
    global $tmdbAPIKey;
    require_once "tmdb-api.php";
    $tmdb = new TMDB($tmdbAPIKey);
    $tmdb->updateConfigurationData();
}

function movieGetTMDB(){
    global $tmdbAPIKey;
    return new TMDB($tmdbAPIKey);
}

function movieGetMovies($page = 1){

    global $tmdbAPIKey;
    require_once "tmdb-api.php";
    $tmdb = new TMDB($tmdbAPIKey);
    $config = $tmdb->getConfigurationData();

    $imageBase = $config["images"]["secure_base_url"];
    $posterBases = [];
    $posterSizes = $config["images"]["poster_sizes"];


    // Concatenate base urls for various poster sizes
    // Sizes at time of writing:
    //"w92"
    //"w154"
    //"w185"
    //"w342"
    //"w500"
    //"w780"
    //"original"

    for($i = 0; $i < count($posterSizes); $i++){
        $size = $posterSizes[$i];
        $posterBases[$size] = $imageBase . $size;
    }

    if(array_key_exists('page',$_GET)) $page = intval($_GET['page']);
    $result = $tmdb->getMovies($page);
    if($result){
        $movies = $result['results'];
        echo '<div class="row">';

        for($i = 0; $i < count($movies); $i++){
            if($i % 3 === 0) {
                echo "</div><div class='row'>";
            }
            $movie = $movies[$i];
            echo "<!-- ";
            var_dump($movie);
            echo " -->";

            echo require('card.php');

        }
        echo "</div>";
        if(wp_doing_ajax()){
            die();
        } else{
            return $tmdb;
        }
    } else{
        echo "Sorry something's gone wrong!";
    }
}

function movieGetMovie($id){
    global $tmdbAPIKey;
    require_once "tmdb-api.php";
    $tmdb = new TMDB($tmdbAPIKey);
    $config = $tmdb->getConfigurationData();
    return $tmdb->getMovie($id);
}



add_filter( 'query_vars', 'movie_query_vars' );
function movie_query_vars( $query_vars ){
    $query_vars[] = 'movieID';
    return $query_vars;
}



function movieSearchMovies(){
    global $tmdbAPIKey;
    require_once "tmdb-api.php";
    $tmdb = new TMDB($tmdbAPIKey);
    $query = $_GET['query'];
    if(!$query){
        echo "Error query required";
        die();
    }
    if(urldecode($query) !== $query){
        echo "Error query not URI encoded (so something odd happened)";
        die();
    }

    $page = 1;
    if(array_key_exists('page', $_GET)) $page = intval($_GET['page']); // sanitise user input to prevent people tampering with the request

    echo json_encode($tmdb->searchMovies($query, $page));
    die();
}
add_action("wp_ajax_nopriv_get_movies", "movieGetMovies");
add_action("wp_ajax_get_movies", "movieGetMovies");
add_action("wp_ajax_nopriv_search_movies", "movieSearchMovies");
add_action("wp_ajax_search_movies", "movieSearchMovies");


add_action("wp_ajax_nopriv_update_tmdb_config", "movieTMDBUpdateConfig");
add_action("wp_ajax_update_tmdb_config", "movieTMDBUpdateConfig");




