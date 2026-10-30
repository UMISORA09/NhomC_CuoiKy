<?php
require_once __DIR__ . "/nhomc-widget-editor.php";
const NHOMC_WIDGETS_VERSION = "six-pages-editable-20261030";

// This WordPress build omits the Widgets entry from the Appearance menu.
function nhomc_add_widgets_menu() {
    if ( ! current_theme_supports( 'widgets' ) ) {
        return;
    }
    global $submenu;
    foreach ( $submenu['themes.php'] ?? array() as $item ) {
        if ( 'widgets.php' === $item[2] ) {
            return;
        }
    }
    add_submenu_page( 'themes.php', __( 'Widgets' ), __( 'Widgets' ), 'edit_theme_options', 'widgets.php' );
}
add_action( 'admin_menu', 'nhomc_add_widgets_menu', 99 );

/** Widget areas matching the six Nhom C page designs. */
function nhomc_page_widgets() {
    return array(
        'nhomc-home' => array( 'Trang chủ — Banner, Top Jobs, Career, Blog', array( 'home-hero' => array( 'Banner và tìm kiếm', false ), 'home-jobs' => array( 'Top Jobs', true ), 'home-career' => array( 'Career With Us', false ), 'home-blogs' => array( 'Bài viết mới ở trang chủ', true ) ) ),
        'nhomc-jobs' => array( 'Jobs — Banner, danh sách và sắp xếp', array( 'jobs-hero' => array( 'Banner Jobs', false ), 'jobs-list' => array( 'Danh sách việc làm, sắp xếp, xem thêm', true ) ) ),
        'nhomc-blog' => array( 'Blog — Banner và bài viết', array( 'blog-hero' => array( 'Banner Blog', false ), 'blog-list' => array( 'Danh sách bài viết Blog', true ) ) ),
        'nhomc-about' => array( 'About Us — Giới thiệu và công ty', array( 'about-hero' => array( 'Banner About Us', false ), 'about-intro' => array( 'Giới thiệu, tầm nhìn và giá trị', false ), 'about-business' => array( 'Lĩnh vực hoạt động', false ), 'about-company' => array( 'Thông tin công ty', false ) ) ),
        'nhomc-contact' => array( 'Contact Us — Địa chỉ và liên hệ', array( 'contact-hero' => array( 'Banner Contact Us', false ), 'contact-hq' => array( 'Địa chỉ trụ sở', false ), 'contact-info' => array( 'Liên hệ nhà tuyển dụng và ứng viên', false ) ) ),
        'nhomc-job-detail' => array( 'Job Detail — Thông tin, đánh giá, ảnh, việc liên quan', array( 'job-hero' => array( 'Thông tin việc làm và nút Share / Apply Job', true ), 'job-main' => array( 'Mô tả công việc, Staff Rating, Company Photos', true ), 'job-other' => array( 'Other Jobs', true ) ) ),
    );
}

add_action( 'widgets_init', function () {
    $areas = array( 'nhomc-newsletter' => 'Dùng chung — Newsletter (6 trang)', 'nhomc-footer-menu' => 'Dùng chung — Menu chân trang (6 trang)' );
    foreach ( nhomc_page_widgets() as $area => $definition ) {
        $areas[ $area ] = $definition[0];
        foreach ( $definition[1] as $section => $data ) {
            register_widget( new NhomC_Section_Widget( $section, $data[0], $area, $data[1] ) );
        }
    }
    foreach ( $areas as $id => $name ) {
        register_sidebar( array( 'id' => $id, 'name' => 'Nhóm C — ' . $name, 'description' => 'Các khối theo đúng giao diện hiện tại. Có thể sắp xếp hoặc thay bằng HTML tùy chỉnh.', 'before_widget' => '', 'after_widget' => '', 'before_title' => '<span hidden>', 'after_title' => '</span>' ) );
    }
    register_widget( 'NhomC_Newsletter_Widget' );
    register_widget( new NhomC_Section_Widget( 'footer-menu', 'Liên kết chân trang', 'nhomc-footer-menu', false ) );
} );

add_action( 'widgets_init', function () {
    foreach ( $GLOBALS['wp_widget_factory']->widgets as $widget ) {
        if ( str_starts_with( $widget->id_base, 'raratheme_' ) || str_starts_with( $widget->id_base, 'rrtc_' ) ) {
            unregister_widget( get_class( $widget ) );
        }
    }
}, 20 );

/** Pass each page's existing query results to its widgets without querying or freezing them again. */
function nhomc_render_page_widgets( $area, $context ) {
    $context['widget_title'] = '';
    $context['widget_image'] = '';
    $context['widget_description'] = '';
    if ( ! is_active_sidebar( $area ) && ! in_array( get_option( 'nhomc_widgets_version' ), array( 'six-pages-20261023', NHOMC_WIDGETS_VERSION ), true ) ) {
        foreach ( nhomc_page_widgets()[ $area ][1] as $section => $data ) {
            get_template_part( 'template-parts/widgets/' . $section, null, $context );
        }
        return;
    }
    $inject = static function ( $params ) use ( $area, $context ) {
        if ( $params[0]['id'] === $area ) { $params[0]['nhomc_context'] = $context; }
        return $params;
    };
    add_filter( 'dynamic_sidebar_params', $inject );
    try { dynamic_sidebar( $area ); } finally { remove_filter( 'dynamic_sidebar_params', $inject ); }
}

function nhomc_widget_default_html( $section ) {
    $theme_uri = get_template_directory_uri();
    $context = array( 'theme_uri' => $theme_uri, 'site_url' => home_url(), 'hero_bg' => $theme_uri . '/images/home/hero-home-bg.jpg', 'career_bg' => $theme_uri . '/images/home/career-bg.jpg' );
    ob_start();
    get_template_part( 'template-parts/widgets/' . $section, null, $context );
    return str_replace( rtrim( home_url(), '/' ), '', ob_get_clean() );
}

function nhomc_active_widget_settings( $area, $base ) {
    $areas = wp_get_sidebars_widgets();
    foreach ( $areas[ $area ] ?? array() as $id ) {
        if ( preg_match( '/^' . preg_quote( $base, '/' ) . '-(\d+)$/', $id, $match ) ) {
            return get_option( 'widget_' . $base, array() )[ (int) $match[1] ] ?? array();
        }
    }
    return array();
}

class NhomC_Section_Widget extends WP_Widget {
    private $section;
    private $area;
    private $dynamic;
    public function __construct( $section, $label, $area, $dynamic = true ) {
        $this->section = $section;
        $this->area = $area;
        $this->dynamic = $dynamic;
        parent::__construct( 'nhomc_' . str_replace( '-', '_', $section ), 'Nhóm C: ' . $label, array( 'description' => 'Chỉnh chữ, hình ảnh và liên kết trực tiếp. Vùng: ' . $area . '.' ) );
    }
    private function fields() {
        $fields = array( 'title' => array( 'type' => 'text', 'label' => 'Tiêu đề (để trống dùng dữ liệu hiện tại)', 'value' => '' ), 'description' => array( 'type' => 'textarea', 'label' => 'Nội dung bổ sung / mô tả thay thế (áp dụng cho cả khối)', 'value' => '' ) );
        if ( 'job-main' === $this->section ) {
            unset( $fields['title'] );
            $fields['rating_title'] = array( 'type' => 'text', 'label' => 'Tiêu đề phần đánh giá', 'value' => 'Staff Rating' );
            $fields['photos_title'] = array( 'type' => 'text', 'label' => 'Tiêu đề thư viện ảnh', 'value' => 'Company Photos' );
            for ( $i = 1; $i <= 6; $i++ ) {
                $fields[ 'image_' . $i ] = array( 'type' => 'image', 'label' => 'Ảnh công ty ' . $i . ' (để trống giữ ảnh hiện tại)', 'value' => '' );
            }
        } else {
            $fields['image'] = array( 'type' => 'image', 'label' => 'Ảnh dùng chung trong khối (để trống dùng ảnh dữ liệu)', 'value' => '' );
        }
        return $fields;
    }
    public function widget( $args, $instance ) {
        if ( $args['id'] !== $this->area ) { return; }
        if ( ! $this->dynamic ) {
            echo $instance['html'] ?? nhomc_widget_default_html( $this->section );
            return;
        }
        if ( ! isset( $args['nhomc_context'] ) ) { return; }
        $context = $args['nhomc_context'];
        foreach ( $this->fields() as $key => $field ) { $context[ 'widget_' . $key ] = $instance[ $key ] ?? $field['value']; }
        $context['widget_title'] = $instance['title'] ?? '';
        get_template_part( 'template-parts/widgets/' . $this->section, null, $context );
    }
    public function form( $instance ) {
        if ( ! $this->dynamic ) {
            $html = $instance['html'] ?? nhomc_widget_default_html( $this->section );
            $editor = nhomc_widget_html_editor( $html );
            echo '<p>Sửa nội dung và hình ảnh bên dưới. Bố cục được giữ nguyên. Với banner có chữ sẵn trong ảnh, hãy chọn ảnh không chữ khi đổi tiêu đề.</p>';
            foreach ( $editor['fields'] as $key => $field ) { nhomc_widget_editor_field( $this, $key, $field, 'changes' ); }
            return;
        }
        echo '<p>Các ô này tùy chỉnh phần trình bày của khối. Thông tin từng tin vẫn lấy từ mục Việc làm hoặc Bài viết.</p>';
        foreach ( $this->fields() as $key => $field ) {
            $field['value'] = $instance[ $key ] ?? $field['value'];
            nhomc_widget_editor_field( $this, $key, $field );
        }
    }
    public function update( $new_instance, $old_instance ) {
        if ( ! $this->dynamic ) {
            $html = $old_instance['html'] ?? nhomc_widget_default_html( $this->section );
            $changes = isset( $new_instance['changes'] ) && is_array( $new_instance['changes'] ) ? $new_instance['changes'] : array();
            return array( 'html' => nhomc_widget_html_editor( $html, $changes )['html'] );
        }
        $clean = array();
        foreach ( $this->fields() as $key => $field ) {
            $value = $new_instance[ $key ] ?? $field['value'];
            if ( ! is_string( $value ) ) { $value = ''; }
            $clean[ $key ] = 'image' === $field['type'] ? esc_url_raw( $value, array( 'http', 'https' ) ) : ( 'textarea' === $field['type'] ? sanitize_textarea_field( $value ) : sanitize_text_field( $value ) );
        }
        return $clean;
    }
}
class NhomC_Newsletter_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct( 'nhomc_newsletter', 'Nhóm C: Newsletter', array( 'description' => 'Biểu mẫu đăng ký của website hiện tại.' ) );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        get_template_part( 'template-parts/nhomc-newsletter', null, $instance );
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        foreach ( array( 'title' => array( 'Tiêu đề (xuống dòng được)', "Subscribe To\nOur Newsletter" ), 'placeholder' => array( 'Gợi ý ô email', 'Input your email address' ), 'button' => array( 'Chữ trên nút', 'SUBSCRIBE' ) ) as $key => $field ) {
            echo '<p><label for="' . esc_attr( $this->get_field_id( $key ) ) . '">' . esc_html( $field[0] ) . '</label><textarea class="widefat" id="' . esc_attr( $this->get_field_id( $key ) ) . '" name="' . esc_attr( $this->get_field_name( $key ) ) . '">' . esc_textarea( isset( $instance[ $key ] ) ? $instance[ $key ] : $field[1] ) . '</textarea></p>';
        }
    }

    public function update( $new_instance, $old_instance ) {
        return array(
            'title' => sanitize_textarea_field( $new_instance['title'] ?? '' ),
            'placeholder' => sanitize_text_field( $new_instance['placeholder'] ?? '' ),
            'button' => sanitize_text_field( $new_instance['button'] ?? '' ),
        );
    }
}
