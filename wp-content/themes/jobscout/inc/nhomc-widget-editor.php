<?php
/** Edit text and media with WordPress' HTML API while keeping the existing layout intact. */
defined( 'ABSPATH' ) || exit;

function nhomc_widget_html_editor( $html, $changes = array() ) {
    $processor = new WP_HTML_Tag_Processor( $html );
    $fields = array();
    $token = 0;
    $skip = '';
    $last_tag = '';
    $modified = false;
    while ( $processor->next_token() ) {
        $token++;
        $tag = $processor->get_tag();
        if ( $skip ) {
            if ( $tag === $skip && $processor->is_tag_closer() ) { $skip = ''; }
            continue;
        }
        if ( in_array( $tag, array( 'SVG', 'SCRIPT', 'STYLE' ), true ) && ! $processor->is_tag_closer() ) { $skip = $tag; continue; }
        if ( '#text' === $processor->get_token_type() ) {
            $text = $processor->get_modifiable_text();
            if ( '' === trim( $text ) ) { continue; }
            $key = 'text_' . $token;
            $fields[ $key ] = array( 'type' => 'textarea', 'label' => ( in_array( $last_tag, array( 'H1', 'H2', 'H3', 'H4' ), true ) ? 'Tiêu đề' : 'Nội dung' ) . ' — ' . wp_trim_words( trim( $text ), 8, '…' ), 'value' => trim( $text ) );
            if ( isset( $changes[ $key ] ) && is_string( $changes[ $key ] ) ) {
                $value = sanitize_textarea_field( $changes[ $key ] );
                if ( $value !== trim( $text ) ) { $processor->set_modifiable_text( $value ); $modified = true; }
            }
            continue;
        }
        if ( '#tag' !== $processor->get_token_type() || $processor->is_tag_closer() ) { continue; }
        $last_tag = $tag;
        $attributes = array();
        if ( 'IMG' === $tag ) { $attributes = array( 'src' => array( 'image', 'Hình ảnh' ), 'alt' => array( 'text', 'Mô tả ảnh' ) ); }
        if ( 'A' === $tag ) { $attributes['href'] = array( 'url', 'Đường dẫn liên kết' ); }
        if ( 'INPUT' === $tag && is_string( $processor->get_attribute( 'placeholder' ) ) ) { $attributes['placeholder'] = array( 'text', 'Gợi ý ô nhập' ); }
        foreach ( $attributes as $attribute => $definition ) {
            $key = $attribute . '_' . $token;
            $current = (string) $processor->get_attribute( $attribute );
            $fields[ $key ] = array( 'type' => $definition[0], 'label' => $definition[1], 'value' => $current );
            if ( isset( $changes[ $key ] ) && is_string( $changes[ $key ] ) ) {
                $value = in_array( $definition[0], array( 'image', 'url' ), true ) ? esc_url_raw( $changes[ $key ], 'image' === $definition[0] ? array( 'http', 'https' ) : null ) : sanitize_text_field( $changes[ $key ] );
                if ( $value !== $current ) {
                    $processor->set_attribute( $attribute, $value );
                    if ( 'src' === $attribute ) { $processor->remove_attribute( 'srcset' ); $processor->remove_attribute( 'sizes' ); }
                    $modified = true;
                }
            }
        }
        $style = (string) $processor->get_attribute( 'style' );
        if ( preg_match( '/background-image\s*:\s*url\(\s*([\'"]?)(.*?)\1\s*\)/i', $style, $match ) ) {
            $key = 'background_' . $token;
            $fields[ $key ] = array( 'type' => 'image', 'label' => 'Ảnh nền', 'value' => $match[2] );
            if ( isset( $changes[ $key ] ) && is_string( $changes[ $key ] ) ) {
                $url = esc_url_raw( $changes[ $key ], array( 'http', 'https' ) );
                if ( $url !== $match[2] ) {
                    $url = str_replace( array( "'", '"', '(', ')', '\\' ), array( '%27', '%22', '%28', '%29', '%5C' ), $url );
                    $processor->set_attribute( 'style', str_replace( $match[0], 'background-image: url("' . $url . '")', $style ) );
                    $modified = true;
                }
            }
        }
    }
    $result = $processor->get_updated_html();
    if ( $modified ) {
        // shortcut: source banners may contain lettering; choose a text-free image when editing headings.
        $banner = new WP_HTML_Tag_Processor( $result );
        if ( $banner->next_tag( 'SECTION' ) && preg_match( '/\b(?:ab|aj|news|cu)-hero(?:-banner)?\b/', (string) $banner->get_attribute( 'class' ) ) ) {
            $banner->add_class( 'nc-widget-banner-edited' );
            $result = $banner->get_updated_html();
        }
    }
    return array( 'fields' => $fields, 'html' => $result );
}

function nhomc_widget_editor_field( $widget, $key, $field, $group = '' ) {
    $name = $group ? $widget->get_field_name( $group ) . '[' . $key . ']' : $widget->get_field_name( $key );
    $id = $widget->get_field_id( ( $group ? $group . '-' : '' ) . $key );
    echo '<p class="nc-widget-field"><label for="' . esc_attr( $id ) . '">' . esc_html( $field['label'] ) . '</label>';
    if ( 'textarea' === $field['type'] ) {
        echo '<textarea class="widefat" rows="3" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $field['value'] ) . '</textarea>';
    } else {
        echo '<input class="widefat" type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $field['value'] ) . '">';
        if ( 'image' === $field['type'] ) {
            echo '<span class="nc-widget-image-controls"><button type="button" class="button nc-widget-image-select">Chọn / đổi ảnh</button> <button type="button" class="button-link nc-widget-image-remove">Bỏ ảnh</button></span><img class="nc-widget-image-preview"' . ( $field['value'] ? ' src="' . esc_url( $field['value'] ) . '"' : ' hidden' ) . ' alt="Xem trước ảnh">';
        }
    }
    echo '</p>';
}

add_filter( 'use_widgets_block_editor', '__return_false' );
function nhomc_widget_editor_assets( $hook ) {
    if ( ! in_array( $hook, array( 'widgets.php', 'customize.php' ), true ) ) { return; }
    wp_enqueue_media();
    wp_enqueue_script( 'nhomc-widget-editor', get_template_directory_uri() . '/js/nhomc-widget-editor.js', array( 'jquery', 'media-views' ), filemtime( get_template_directory() . '/js/nhomc-widget-editor.js' ), true );
    wp_enqueue_style( 'nhomc-widget-editor', get_template_directory_uri() . '/css/nhomc-widget-editor.css', array(), filemtime( get_template_directory() . '/css/nhomc-widget-editor.css' ) );
}
add_action( 'admin_enqueue_scripts', 'nhomc_widget_editor_assets' );
add_action( 'customize_controls_enqueue_scripts', function () { nhomc_widget_editor_assets( 'customize.php' ); } );
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'nhomc-widget-content', get_template_directory_uri() . '/css/nhomc-widget-content.css', array(), filemtime( get_template_directory() . '/css/nhomc-widget-content.css' ) );
} );
