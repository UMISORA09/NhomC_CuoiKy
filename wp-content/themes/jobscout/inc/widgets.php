<?php
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
            if ( $data[1] ) { register_widget( new NhomC_Section_Widget( $section, $data[0], $area ) ); }
        }
    }
    foreach ( $areas as $id => $name ) {
        register_sidebar( array( 'id' => $id, 'name' => 'Nhóm C — ' . $name, 'description' => 'Các khối theo đúng giao diện hiện tại. Có thể sắp xếp hoặc thay bằng HTML tùy chỉnh.', 'before_widget' => '', 'after_widget' => '', 'before_title' => '<span hidden>', 'after_title' => '</span>' ) );
    }
    register_widget( 'NhomC_Newsletter_Widget' );
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
    if ( ! is_active_sidebar( $area ) && get_option( 'nhomc_widgets_version' ) !== 'six-pages-20261023' ) {
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

class NhomC_Section_Widget extends WP_Widget {
    private $section;
    private $area;
    public function __construct( $section, $label, $area ) {
        $this->section = $section;
        $this->area = $area;
        parent::__construct( 'nhomc_' . str_replace( '-', '_', $section ), 'Nhóm C: ' . $label, array( 'description' => 'Dữ liệu trực tiếp từ trang hiện tại. Đặt trong vùng ' . $area . '.' ) );
    }
    public function widget( $args, $instance ) {
        if ( $args['id'] !== $this->area || ! isset( $args['nhomc_context'] ) ) { return; }
        $context = $args['nhomc_context'];
        $context['widget_title'] = $instance['title'] ?? '';
        get_template_part( 'template-parts/widgets/' . $this->section, null, $context );
    }
    public function form( $instance ) {
        if ( in_array( $this->section, array( 'job-hero', 'job-main' ), true ) ) {
            echo '<p>Dữ liệu lấy từ việc làm đang xem. Chỉnh nội dung tại mục Việc làm; Share, Apply Job và thư viện ảnh giữ nguyên chức năng hiện tại.</p>';
            return;
        }
        echo '<p><label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">Tiêu đề (để trống dùng tiêu đề hiện tại)</label><input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" value="' . esc_attr( $instance['title'] ?? '' ) . '"></p><p>Danh sách lấy dữ liệu trực tiếp; quản lý bài viết và việc làm ở các mục tương ứng.</p>';
    }
    public function update( $new_instance, $old_instance ) {
        return array( 'title' => sanitize_text_field( $new_instance['title'] ?? '' ) );
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
