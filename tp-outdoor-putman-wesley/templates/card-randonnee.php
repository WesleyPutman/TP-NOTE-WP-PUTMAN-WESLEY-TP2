<?php
?>
<article class="rando-card">
    
    <a href="<?php the_permalink(); ?>" class="rando-img-wrapper">
        <?php 
        if ( has_post_thumbnail() ) {
            the_post_thumbnail('medium_large'); 
        } else {
            echo '<div class="no-image">Pas d\'image</div>';
        }
        ?>
    </a>

    <div class="rando-content">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <div class="rando-meta">
            <?php
            if ( function_exists('get_field') ) {
                $distance = get_field('distance_km');
                $duree = get_field('duree');
                
                if ($distance) {
                    echo '<div class="meta-item"><span class="dashicons dashicons-location"></span> ' . esc_html($distance) . ' km</div>';
                }
                if ($duree) {
                    echo '<div class="meta-item"><span class="dashicons dashicons-clock"></span> ' . esc_html($duree) . '</div>';
                }
            }
            ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="btn-detail">Voir le parcours</a>
    </div>

</article>