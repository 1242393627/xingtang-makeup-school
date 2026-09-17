<?php
/**
 * 首页模板
 * Template Name: 首页
 */
get_header();
?>
<section class="hero-carousel">
    <div class="hero-slide active">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/slides/slide1.jpg" alt="星棠化妆培训学校" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="kicker">七大学科 · 免费试学一天</span>
            <h1 class="hero-title">从<span class="g">零基础</span>，<br>到签协议入学。</h1>
            <p>星棠化妆培训学校 始创于2018年，13大校区全部直营。化妆、美容、美发、美甲、纹绣、美睫、皮肤管理 7大学科，国家一级技师领衔，毕业即推荐上岗。</p>
            <div class="acts">
                <a href="/apply/" class="p">预约免费试学</a>
                <a href="#courses" class="g2">查看全部课程</a>
            </div>
        </div>
    </div>
</section>
<section class="news-faq">
    <div class="container">
        <div class="news-faq-grid">
            <div class="news-col">
                <div class="nf-header">
                    <h3 class="nf-title">学校资讯</h3>
                    <a href="/news/" class="nf-more">查看全部 →</a>
                </div>
                <div class="nf-list">
                    <?php $latest_news = new WP_Query(array('post_type'=>'post','posts_per_page'=>3,'orderby'=>'ID','order'=>'DESC')); ?>
                    <?php if($latest_news->have_posts()): while($latest_news->have_posts()): $latest_news->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="nf-item">
                            <div class="nf-date"><?php echo get_the_date('Y.m.d'); ?></div>
                            <div class="nf-content"><h4><?php the_title(); ?></h4></div>
                        </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>