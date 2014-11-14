<?php while (have_posts()) : the_post(); ?>
    <? $meta = get_post_meta(get_the_id()); ?>
    <article <?php post_class(); ?>>
        <header>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php get_template_part('templates/entry-meta'); ?>
        </header>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
        <footer>
            <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
        </footer>
        <?php comments_template('/templates/comments.php'); ?>
    </article>

    <hr/>
    <h1>Read enteries on <?= get_the_title(); ?></h1>
    <?
    $query = new WP_QUery(
        array(
            'post_type' => 'blogentery',
            'meta_key' => 'blogParent',
            'meta_value' => get_the_id(),
        )
    );

    if ($query->have_posts()) : ?>

        <ul>
            <?php while ($query->have_posts()) : $query->the_post();
            global $post;
                ?>
                <li><a href="/blogentry/<?= sanitize_title( get_the_title());?> "><? the_title(); ?></a></li>
            <?php endwhile; ?>
        </ul>
        <?php wp_reset_postdata(); ?>

    <?php else : ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
<?php endwhile; ?>
