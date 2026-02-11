<?php get_header(); ?>
<section class="derniere-randonnees">
    <div class="container">
        <h2>Récemment ajouté</h2>
        <?php
        $args_toutes = array(
            'post_type'      => 'randonnee',
            'posts_per_page' => 3,
            'orderby'        => 'date',
            'order'          => 'DESC'
        );
        $requete_toutes = new WP_Query($args_toutes);
        if ( $requete_toutes->have_posts() ) : ?>
            <div class="rando-grid">
                <?php while ( $requete_toutes->have_posts() ) : $requete_toutes->the_post(); ?>
                    <?php get_template_part('templates/card', 'randonnee'); ?>
                <?php endwhile; ?>
            </div>
            <?php 
            wp_reset_postdata(); 
            ?>
        <?php else : ?>
            <p>Pas de randonnées récentes.</p>
        <?php endif; ?>
    </div>
</section>
<hr> <section class="randonnees-moyennes" style="background-color: #f9f9f9; padding: 2rem 0;">
    <div class="container">
        <h2>🔥 Challenge : Niveau Moyen</h2>
        <?php
        $args_moyen = array(
            'post_type'      => 'randonnee',
            'posts_per_page' => 3,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'difficulte',
                    'field'    => 'slug',
                    'terms'    => 'moyen',
                ),
            ),
        );
        $requete_moyen = new WP_Query($args_moyen);
        if ( $requete_moyen->have_posts() ) : ?>
            <div class="rando-grid">
                <?php while ( $requete_moyen->have_posts() ) : $requete_moyen->the_post(); ?>
                    <?php get_template_part('templates/card', 'randonnee'); ?>

                <?php endwhile; ?>
            </div>   
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p>Aucune randonnée de niveau moyen trouvée.</p>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>