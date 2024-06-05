<?php
// Gestion des filtres d'affichage des photos en page d'accueil (front-page)       
?>

<div class="filter-area swiper-container">
    <form class="flexrow swiper-wrapper" method="post">
        <!--  -->
        <!-- $terms->term_id :  -->
        <!-- $terms->taxonomy : nom de la taxonomie -->
        <!-- $terms->name : nom de l'élément de la taxonomie -->
        <!-- $terms->term_taxonomy_id : n° de l'élément de la taxonomie -->
        <div class="filterleft swiper-slide flexrow">
            <div id="filtre-categorie" class="select-filter flexcolumn">
                <select class="option-filter" name="categorie_id" id="categorie_id">
                    <option id="categorie_0" value="">CATÉGORIES</option>
                    <?php
                    // Récupérer les termes de la taxonomie "catégorie"
                    $filtres_categorie_acf = get_terms('categorie-acf', array('hide_empty' => false));
                    foreach ($filtres_categorie_acf as $terms) :
                    ?>
                        <?php if ($terms->term_taxonomy_id == $categorie_id) : ?>
                            <option id="categorie_<?php echo $terms->term_taxonomy_id; ?>" value="<?php echo $terms->term_taxonomy_id; ?>" selected><?php echo $terms->name; ?></option>
                        <?php else : ?>
                            <option id="categorie_<?php echo $terms->term_taxonomy_id; ?>" value="<?php echo $terms->term_taxonomy_id; ?>"><?php echo $terms->name; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="filtre-format" class="select-filter flexcolumn">
                <select class="option-filter" name="format_id" id="format_id">
                    <option id="format_0" value="">FORMATS</option>
                    <?php
                    // Récupérer les termes de la taxonomie "Format"
                    $filtre_format_acf = get_terms('format-acf', array('hide_empty' => false));
                    foreach ($filtre_format_acf as $terms) :
                    ?>
                        <?php if ($terms->term_taxonomy_id == $format_id) : ?>
                            <option id="format_<?php echo $terms->term_taxonomy_id; ?>" value="<?php echo $terms->term_taxonomy_id; ?>" selected><?php echo $terms->name; ?></option>
                        <?php else : ?>
                            <option id="format_<?php echo $terms->term_taxonomy_id; ?>" value="<?php echo $terms->term_taxonomy_id; ?>"><?php echo $terms->name; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="filterright swiper-slide flexrow">
            <div id="filtre-date" class="select-filter flexcolumn">
                <select class="option-filter" name="date" id="date">
                    <option value="">TRIER PAR</option>
                    <option value="desc" <?php if ($order === "desc") : ?>selected<?php endif; ?>>à partir des plus récentes</option>
                    <option value="asc" <?php if ($order === "asc") : ?>selected<?php endif; ?>>à partir des plus anciennes</option>
                </select>
            </div>
        </div>
    </form>
</div>