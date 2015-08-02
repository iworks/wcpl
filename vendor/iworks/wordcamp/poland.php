<?php

class iworks_wordcamp_poland
{
    private $base;
    private $capability;
    private $options;
    private $root;
    private $version = '0.0';

    public function __construct()
    {
        /**
         * static settings
         */
        $this->base = dirname(dirname( dirname( __FILE__ ) ));
        $this->root = plugins_url('', (dirname(dirname(dirname(__FILE__)))));
        $this->capability = apply_filters( 'iworks_wordcamp_poland_capability', 'manage_options' );

        /**
         * options
         */
        $this->options = get_iworks_wordcamp_poland_options();

        /**
         * generate
         */
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_filter('the_content', array($this, 'the_content'));

    }

    public function admin_init()
    {
        add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
        /**
         * options
         */
        $this->options->options_init();
    }

    public function admin_enqueue_scripts()
    {
        $screen = get_current_screen();
        if ( 'appearance_page_wcpl_index' != $screen->base ) {
            return;
        }
        $file = strtolower(sprintf('/scripts/%s.admin.js', __CLASS__));
        wp_enqueue_script( __CLASS__, plugins_url( $file, $this->base ), array( 'jquery' ), $this->get_version( $file ) );
        wp_enqueue_script(__CLASS__);
    }

    private function get_version($file = null)
    {
        if ( defined( 'IWORKS_DEV_MODE' ) && IWORKS_DEV_MODE ) {
            if ( null != $file ) {
                $file = dirname($this->base) . $file;
                if ( is_file( $file ) ) {
                    return md5_file( $file );
                }
            }
            return rand( 0, 99999 );
        }
        return $this->version;
    }

    public function plugin_row_meta($links, $file)
    {
        if ( !preg_match('/wcpl.php$/', $file ) ) {
            return $links;
        }
        if ( !is_multisite() && current_user_can( $this->capability ) ) {
            $links[] = sprintf(
                '<a href="%s">%s</a>',
                esc_url(add_query_arg( 'page', 'wcpl_index', admin_url('themes.php'))),
                __( 'Settings' )
            );
        }
        $links[] = sprintf(
            '<a href="http://iworks.pl/donate/wcpl.php">%s</a>',
            __( 'Donate' )
        );
        return $links;
    }

    private function get_banner()
    {
        $banner = '';
        switch($this->options->get_option('banner_size')) {
        case '970x250':
            $banner = '970_250.jpg';
            break;
        case '1260x399':
            $banner = '1260_399.jpg';
            break;
        }
        if ( empty($banner) ) {
            return '';
        }
        $style = '';
        switch( $this->options->get_option('position')) {
        case 'top':
        case 'after2p':
            $style = 'padding: 0 0 1em 0;';
            break;
        case 'bottom':
            $style = 'padding: 1em 0 0 0;';
            break;
        }
        return sprintf(
            '<div class="wcpl" style="%s"><a href="%s"><img src="%s%s" alt="%s" /></a></div>',
            esc_attr($style),
            esc_attr('https://goo.gl/GC92jC'),
            plugins_url('images/2015/banners/', dirname(dirname(dirname(__FILE__)))),
            $banner,
            __('WordCamp Poland', 'wcpl')
        );
    }

    public function the_content($content)
    {
        if ( is_singular() ) {
            switch( $this->options->get_option('position')) {
            case 'top':
                $content = $this->get_banner() . $content;
                break;
            case 'after2p':
                $c = explode('<p>', $content);
                if ( count($c) > 1 ) {
                    $content = '';
                    $i = 0;
                    foreach($c as $one) {
                        $content .= '<p>'.$one;
                        if ( $i == 2 ) {
                            $content .= $this->get_banner();
                        }
                        $i++;
                    }
                }
                break;
            case 'bottom':
                $content .= $this->get_banner();
                break;
            }
        }
        return $content;
    }

}
