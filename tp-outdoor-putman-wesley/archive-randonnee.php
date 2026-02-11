<?php get_header(); ?>

<main class="archive-container">
    <h1>Nos Randonnées</h1>

    <div class="rando-grid">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php 
            get_template_part('templates/card', 'randonnee'); 
            ?>

        <?php endwhile; endif; ?>
    </div>
    
    <div class="pagination">
        <?php the_posts_pagination(); ?>
    </div>
</main>

<?php get_footer(); ?>