<?php
/**
 * Nhom C Custom Helper Functions for Job Detail
 * Brand: NhomC
 * Project: FIT - TDC Cuoi Ky
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render Company Logo based on Database metadata or company name
 */
function nhomc_get_company_logo( $company_name = '', $post_id = 0, $size = 'large' ) {
    if ( ! empty( $post_id ) && has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'nhomc-logo-img' ) );
    }

    if ( ! empty( $post_id ) ) {
        $logo_url = get_post_meta( $post_id, '_company_logo', true );
        if ( ! empty( $logo_url ) ) {
            return '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $company_name ) . '" class="nhomc-logo-img">';
        }
    }

    $c_clean = strtoupper( trim( (string)$company_name ) );

    // 1. SODOH / THE SODOH / S 0TbEoH
    if ( strpos( $c_clean, 'SODOH' ) !== false || strpos( $c_clean, '0TBEOH' ) !== false ) {
        return '
        <div class="nhomc-typo-logo sodoh">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#222" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span class="logo-sub">THE</span>
            <span class="logo-main" style="letter-spacing:1px;font-weight:900;">SODOH</span>
            <span class="logo-sub" style="font-size:5px;">HIGASHIYAMA KYOTO</span>
        </div>';
    }

    // 2. FONTAINE GARDEN / GARDEN
    if ( strpos( $c_clean, 'GARDEN' ) !== false ) {
        return '
        <div class="nhomc-typo-logo garden" style="border:1px solid #d1d5db;padding:4px;width:90%;height:85%;">
            <span class="logo-sub" style="font-size:6px;letter-spacing:1px;">FONTAINE</span>
            <span class="logo-main" style="font-size:10px;font-weight:700;letter-spacing:0.8px;">GARDEN</span>
        </div>';
    }

    // 3. The Seygn House / The Seven House
    if ( strpos( $c_clean, 'SEYGN' ) !== false || strpos( $c_clean, 'SEVEN' ) !== false ) {
        return '
        <div class="nhomc-typo-logo seven-house">
            <div style="width:20px;height:20px;border:3px solid #111;margin-bottom:3px;"></div>
            <span class="logo-main" style="font-size:9px;font-weight:800;letter-spacing:0.5px;">TH€ Seygn House</span>
            <span class="logo-sub" style="font-size:5px;">KYOTO</span>
        </div>';
    }

    // 4. PHỞ THÌN / PHd THIN
    if ( strpos( $c_clean, 'THIN' ) !== false || strpos( $c_clean, 'PHỞ' ) !== false || strpos( $c_clean, 'PHO' ) !== false ) {
        return '
        <div class="nhomc-typo-logo pho-thin">
            <div style="border:1px solid #111;padding:2px 6px;margin-bottom:2px;">
                <span class="logo-main" style="font-size:12px;font-weight:900;letter-spacing:1px;">PHỞ</span>
            </div>
            <span class="logo-main" style="font-size:8px;font-weight:800;letter-spacing:1px;">THÌN</span>
        </div>';
    }

    // 5. FROM WHERE I STAND / LOSS PREVENTION
    if ( strpos( $c_clean, 'STAND' ) !== false || strpos( $c_clean, 'WHERE' ) !== false ) {
        return '
        <div class="nhomc-typo-logo stand" style="border-radius:50%;border:1px solid #999;width:55px;height:55px;display:flex;flex-direction:column;align-items:center;justify-content:center;">
            <span style="font-size:16px;">⟐</span>
            <span class="logo-sub" style="font-size:5px;letter-spacing:0.5px;text-align:center;">FROM WHERE<br>I STAND</span>
        </div>';
    }

    // 6. Plan Do See Global
    if ( strpos( $c_clean, 'PLAN' ) !== false || strpos( $c_clean, 'PDS' ) !== false ) {
        return '
        <div class="nhomc-typo-logo pds">
            <span class="logo-main" style="font-size:11px;font-weight:800;letter-spacing:0.8px;">PLAN DO SEE</span>
            <span class="logo-sub" style="font-size:6px;letter-spacing:1px;">GLOBAL</span>
        </div>';
    }

    // Generic Default from Database
    $initials = '';
    $words = explode( ' ', (string)$company_name );
    foreach ( $words as $w ) {
        if ( ! empty( $w ) ) {
            $initials .= mb_substr( $w, 0, 1 );
        }
    }
    $initials = mb_substr( $initials, 0, 3 );

    return '
    <div class="nhomc-typo-logo default" style="background:#f3f4f6;width:100%;height:100%;border-radius:3px;">
        <span class="logo-main" style="font-size:13px;font-weight:900;color:#ea580c;">' . esc_html( $initials ) . '</span>
        <span class="logo-sub" style="font-size:7px;color:#4b5563;max-width:70px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' . esc_html( $company_name ) . '</span>
    </div>';
}

/**
 * Get Job Badges (Type, Category, Location) from Database
 */
function nhomc_get_job_badges( $post_id ) {
    // 1. Type
    $types = wpjm_get_the_job_types( $post_id );
    $type_name = 'Fulltime';
    if ( ! empty( $types ) && is_array( $types ) ) {
        $first_type = reset( $types );
        $type_name = $first_type->name;
    }

    // 2. Category
    $cats = get_the_terms( $post_id, 'job_listing_category' );
    $cat_name = 'Category Name';
    if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
        $first_cat = reset( $cats );
        $cat_name = $first_cat->name;
    }

    // 3. Location
    $location = get_post_meta( $post_id, '_job_location', true );
    if ( empty( $location ) ) {
        $location = 'Ho Chi Minh City';
    }

    return array(
        'type'     => $type_name,
        'category' => $cat_name,
        'location' => $location,
    );
}

/**
 * Get Job Bullets for Other Jobs cards from Database or post_content
 */
function nhomc_get_job_bullets( $post_id, $post_content = '' ) {
    $bullets = array();

    // Parse from post content if contains bullets or <p>•
    if ( ! empty( $post_content ) ) {
        $lines = explode( "\n", strip_tags( $post_content, '<br>' ) );
        foreach ( $lines as $line ) {
            $cleaned = trim( str_replace( array( '<br>', '<br/>', '<br />' ), '', $line ) );
            if ( mb_strpos( $cleaned, '•' ) !== false || mb_strpos( $cleaned, '-' ) === 0 ) {
                $cleaned = trim( preg_replace( '/^[•\-\*\s]+/u', '', $cleaned ) );
                if ( ! empty( $cleaned ) && mb_strlen( $cleaned ) > 10 ) {
                    $bullets[] = $cleaned;
                }
            }
        }
    }

    // Standard 3 bullets matching mockup if not found
    if ( count( $bullets ) < 3 ) {
        $bullets = array(
            'Be responsible for the effective operational management of the hotel',
            'Excellent salary bonuses & recognition activities',
            'Foreign language allowance (up to 500USD/month)'
        );
    }

    return array_slice( $bullets, 0, 3 );
}
