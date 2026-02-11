<?php get_header(); ?>

<main id="main-content" class="single-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="randonnee-detail">
            
            <header class="rando-header">
                <h1><?php the_title(); ?></h1>
                <div class="rando-infos-cles">
                    <?php
                    $distance = get_field('distance_km');
                    $duree = get_field('duree');
                    ?>
                    <?php if ( $distance ) : ?>
                        <div class="info-badge">
                            <span class="dashicons dashicons-location"></span> 
                            <strong><?php echo esc_html($distance); ?> km</strong>
                        </div>
                    <?php endif; ?>
                    <?php if ( $duree ) : ?>
                        <div class="info-badge">
                            <span class="dashicons dashicons-clock"></span> 
                            <strong><?php echo esc_html($duree); ?></strong>
                        </div>
                    <?php endif; ?>
                </div>
            </header>

            <div class="randonnee-image-une">
                <?php the_post_thumbnail('large'); ?>
            </div>

            <div class="rando-layout">
                
                <div class="rando-main">
                    <h2>À propos de cette randonnée</h2>
                    <div class="content-body">
                        <?php the_content(); ?>
                    </div>
                    <?php 
                    $image_secondaire = get_field('image');
                    if ( $image_secondaire ) : ?>
                        <div class="image-supplementaire">
                            <h3>Aperçu du parcours</h3>
                            <img src="<?php echo esc_url($image_secondaire); ?>" alt="Aperçu">
                        </div>
                    <?php endif; ?>
                </div>

                <aside class="rando-sidebar">
                    
                    <?php if( have_rows('points_interets') ): ?>
                        
                        <?php 
                        $points_map = array();
                        // On boucle une première fois juste pour remplir les données de la carte
                        while( have_rows('points_interets') ): the_row();
                            $lat = get_sub_field('lat');
                            $lng = get_sub_field('lng');
                            $nom = get_sub_field('nom');
                            $difficile = get_sub_field('access_difficile');
                            
                            if($lat && $lng) {
                                $points_map[] = array(
                                    'lat' => $lat,
                                    'lng' => $lng,
                                    'nom' => $nom,
                                    'difficile' => $difficile
                                );
                            }
                        endwhile;
                        // IMPORTANT : On doit remettre le pointeur à zéro pour refaire la boucle de la liste juste après
                        // Mais avec ACF, appeler have_rows() une deuxième fois suffit souvent.
                        // Par sécurité, on peut utiliser reset_rows() si on est dans une boucle imbriquée, 
                        // mais ici on va simplement relancer la boucle while plus bas.
                        ?>

                        <?php if ( !empty($points_map) ) : ?>
                            <div class="map-box" style="margin-bottom: 2rem;">
                                <h3>🗺️ Carte du parcours</h3>
                                <div id="ma-carte-rando" 
                                     style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid #ddd;"
                                     data-points='<?php echo json_encode($points_map); ?>'>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="points-interets-box">
                            <h3>📍 Points d'intérêt</h3>
                            <ul class="poi-list">
                                <?php while( have_rows('points_interets') ): the_row(); 
                                    $nom = get_sub_field('nom');
                                    $difficile = get_sub_field('access_difficile');
                                ?>
                                    <li class="poi-item <?php echo $difficile ? 'is-difficult' : ''; ?>">
                                        <span class="poi-name"><?php echo esc_html($nom); ?></span>
                                        <?php if( $difficile ): ?>
                                            <span class="badge-difficile" title="Accès Difficile">⚠️ Difficile</span>
                                        <?php endif; ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>

                    <?php endif; ?>
                </aside>
            </div>
        </article>
    <?php endwhile; endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var mapContainer = document.getElementById('ma-carte-rando');
    
    // On vérifie que la div existe et que Leaflet (L) est chargé
    if (mapContainer && typeof L !== 'undefined') {
        var points = JSON.parse(mapContainer.dataset.points);
        
        if (points.length > 0) {
            var map = L.map('ma-carte-rando').setView([points[0].lat, points[0].lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var bounds = [];
            
            points.forEach(function(point) {
                var marker = L.marker([point.lat, point.lng]).addTo(map);
                var popupContent = "<b>" + point.nom + "</b>";
                if (point.difficile) {
                    popupContent += "<br><span style='color:red;'>⚠️ Accès difficile</span>";
                }
                marker.bindPopup(popupContent);
                bounds.push([point.lat, point.lng]);
            });

            if (bounds.length > 1) {
                var group = new L.featureGroup(points.map(p => L.marker([p.lat, p.lng])));
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }
    }
});
</script>

<?php get_footer(); ?>