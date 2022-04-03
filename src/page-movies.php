<?php /* Template Name: Movie Listing */ ?>
<?php get_template_part("header") ?>


<?php wp_body_open(); ?>
    <div class="titleBar fullWidth">
        <div class="titleBarBGLayer fullWidth">
            <div class="container titleContainer">
                <h1><?php the_title(); ?></h1>
                <p class="breadcrumb">Home </p>
            </div>
        </div>
    </div>
<div class="body-bg">
    <div class="container">
        <?php

        ?>
        <div class="content movies" id="moviecontainer">
            <?php

            $pageNumber = get_query_var('page');
            if($pageNumber === "") $pageNumber = 1;
            $tmdb = movieGetMovies($pageNumber); ?>


        </div>
        <div class="pagination">
            <?php $pagination = $tmdb->getPagination();
            $pageNumbers = $pagination['pageNumbers'];
            if($pageNumber > 1){
                $prevPage = $pageNumber - 1;
                echo "<a href='/page/{$prevPage}' class='paginationPrevious'>Previous</a> ";
            }
            for($i = 0; $i < count($pageNumbers); $i++){
                $number = $pageNumbers[$i];
                if($number === $pageNumber){
                    echo "<span class='paginationItem currentPage'>{$number}</span> ";
                } else{
                    echo "<a href='/page/{$number}/' class='paginationItem'>{$number}</a> ";
                }
            }
            if($pageNumber < $pagination['totalPages'] ) {

                $nextpage = $pageNumber + 1;

                echo "<a href='/page/{$nextpage}/' class='paginationNext'>Next</a>";
            }

            ?>

        </div>

    </div>
</div>
<?php

get_template_part("footer"); ?>