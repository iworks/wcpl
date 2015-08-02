<?php

function iworks_wordcamp_poland_options()
{
    $options = array();

    /**
     * main settings
     */
    $options['index'] = array(
        'use_tabs' => false,
        'version'  => '0.0',
        'page_title' => __('WordCamp Poland', 'wcpl'),
        'menu_title' => __('WordCamp Poland', 'wcpl'),
        'menu' => 'theme',
        'enqueue_scripts' => array(
            'wcpl-admin-js',
        ),
        'enqueue_styles' => array(
            'wcpl-admin',
            'wcpl',
        ),
        'options'  => array(
            array(
                'name'              => 'position',
                'type'              => 'radio',
                'th'                => __( 'Banner position in entry.', 'wcpl' ),
                'default'           => 'no',
                'radio'             => array(
                    'no'            => array( 'label' => __( 'Do not display banner in entries.', 'wcpl' ) ),
                    'top'           => array( 'label' => __( 'top', 'wcpl' ) ),
                    'after2p'       => array( 'label' => __( 'after second paragraph',  'wcpl' ) ),
                    'bottom'        => array( 'label' => __( 'bottom',  'wcpl' ) ),
                    'action'        => array( 'label' => __( 'action',  'wcpl' ) ),
                ),
                'sanitize_callback' => 'esc_html',
            ),
            array(
                'name'              => 'action',
                'th'                => __( 'Action name', 'wcpl' ),
                'sanitize_callback' => 'esc_html',
                'description'        => __('If you have a action in your theme then you can put here this action name for display WC PL banner.', 'wcpl'),
            ),
            array(
                'name'              => 'banner_size',
                'type'              => 'radio',
                'th'                => __( 'Banner size', 'wcpl' ),
                'default'           => '970x250',
                'radio'             => array(
                    '970x250'       => array( 'label' => __( '970px x 250px',  'wcpl' ) ),
                    '1260x399'      => array( 'label' => __( '1260px x 399px', 'wcpl' ) ),
                ),
                'sanitize_callback' => 'esc_html',
            ),
        ),
    );
    return $options;
}

