<?php get_header(); ?>
<main class="container single-post">
<?php while(have_posts()): the_post(); ?>
<h1><?php the_title(); ?></h1>
<div class="post-meta"><?php echo get_the_date('Y-m-d'); ?></div>
<div class="post-content"><?php the_content(); ?></div>
<div class="post-nav">
<div class="prev"><?php previous_post_link('上一篇: %link'); ?></div>
<div class="next"><?php next_post_link('下一篇: %link'); ?></div>
</div>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>