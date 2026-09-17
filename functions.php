<?php
// 星棠化妆培训学校主题功能

// 加载主题样式
function xingtang_enqueue_styles() {
    wp_enqueue_style('xingtang-style', get_stylesheet_uri(), array(), '65.0');
}
add_action('wp_enqueue_scripts', 'xingtang_enqueue_styles');

// 主题支持
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('custom-logo');
add_theme_support('menus');

// 注册导航菜单
function xingtang_register_menus() {
    register_nav_menus(array(
        'primary' => '主导航菜单',
        'footer' => '底部菜单',
    ));
}
add_action('init', 'xingtang_register_menus');

// 自定义图片大小
add_image_size('teacher-avatar', 400, 400, true);
add_image_size('work-thumbnail', 600, 800, true);

// 移除WordPress版本号
remove_action('wp_head', 'wp_generator');

// 禁用XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// 优化head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// 自定义SEO功能
function xingtang_custom_seo() {
    global $post;
    
    // 页面SEO配置 - 全部18个页面
    $seo_config = array(
        'home' => array(
            'title' => '星棠化妆培训学校_专业化妆培训_美容美发培训_全国13校',
            'desc' => '星棠化妆培训学校成立于2018年，全国13所直营校区，提供化妆、美容、美发、美甲、纹绣、美睫、皮肤管理七大学科培训。零基础到专业毕业，毕业推荐就业，咨询电话15825263079。'
        ),
        'about' => array(
            'title' => '学校简介_星棠化妆培训学校怎么样_星棠化妆学校',
            'desc' => '星棠化妆培训学校始创于2018年，旗下拥有昆妆、贵妆、星棠三个品牌，全国7省13校直营，专注美业培训，国家一级技师领衔授课，咨询电话15825263079。'
        )
    );
    
    // 获取当前页面
    $current_page = '';
    if (is_front_page()) {
        $current_page = 'home';
    } elseif (is_page()) {
        $slug = $post->post_name;
        if (isset($seo_config[$slug])) {
            $current_page = $slug;
        }
    }
    
    // 输出SEO标签
    if ($current_page && isset($seo_config[$current_page])) {
        echo '<title>' . $seo_config[$current_page]['title'] . '</title>' . "\n";
        echo '<meta name="description" content="' . $seo_config[$current_page]['desc'] . '">' . "\n";
    }
}
add_action('wp_head', 'xingtang_custom_seo', 1);

// 移除WordPress默认title，用我们自定义的
remove_action('wp_head', '_wp_render_title_tag', 1);

// 图片懒加载 - 全站所有图片
add_filter('the_content', 'xingtang_lazyload_images');
function xingtang_lazyload_images($content) {
    if (is_admin()) return $content;
    $content = preg_replace('/<img(.*?)src="/i', '<img$1loading="lazy" src="', $content);
    return $content;
}

// 前端直接给所有图片加懒加载
add_action('wp_footer', 'xingtang_lazyload_all_images');
function xingtang_lazyload_all_images() {
    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("img:not([loading])").forEach(img => {
            img.loading = "lazy";
        });
    });
    </script>
    ';
}

// 面包屑导航函数
function xingtang_breadcrumb() {
    if (is_front_page()) return;
    
    echo '<div class="breadcrumb">';
    echo '<div class="container">';
    echo '<a href="' . home_url('/') . '">首页</a> <span class="sep">/</span> ';
    
    if (is_page()) {
        global $post;
        $slug = $post->post_name;
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif (is_single()) {
        echo '<a href="' . home_url('/news/') . '">新闻资讯</a> <span class="sep">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    }
    
    echo '</div>';
    echo '</div>';
}

// 添加主题设置页面
function xingtang_theme_options() {
    add_menu_page('主题设置', '主题设置', 'manage_options', 'xingtang-settings', 'xingtang_settings_page', 'dashicons-admin-settings', 2);
}
add_action('admin_menu', 'xingtang_theme_options');

function xingtang_settings_page() {
    echo '<div class="wrap"><h1>星棠主题设置</h1><p>所有前台内容都可以在这里修改</p></div>';
}

// 获取设置的辅助函数
function xingtang_get_option($key, $default = '') {
    return get_option('xingtang_' . $key, $default);
}

// 动态自动sitemap
function xingtang_sitemap_rewrite() {
    add_rewrite_rule('^sitemap\.xml$', 'index.php?xingtang_sitemap=1', 'top');
}
add_action('init', 'xingtang_sitemap_rewrite');

function xingtang_sitemap_query_vars($vars) {
    $vars[] = 'xingtang_sitemap';
    return $vars;
}
add_filter('query_vars', 'xingtang_sitemap_query_vars');

function xingtang_sitemap_template() {
    if (get_query_var('xingtang_sitemap')) {
        include(get_template_directory() . '/sitemap.php');
        exit;
    }
}
add_action('template_redirect', 'xingtang_sitemap_template');
?>