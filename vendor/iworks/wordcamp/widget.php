<?php

class iWorks_WordCamp_Widget extends WP_Widget
{
    private $options = array();

    public function __construct()
    {
        parent::__construct(
            __CLASS__,
            __( 'WordCamp Poland', 'wcpl' ),
            array(
                'description' => __( 'WordCamp Poland', 'wcpl' ),
            )
        );
        $this->options['kind'] = array(
            '2015' => array(
                '2015/banners/250_250.jpg' => __('Banner', 'wcpl'),
                '2015/logo/logo.png' => __('Logo', 'wcpl'),
                '2015/qr-code.png' =>__('QR Code with link', 'wcpl'),
                '2015/logo/logo_black_simple.png' => __('Logo Black', 'wcpl'),
                '2015/logoi/logo_white_simple.png' => __('Logo White', 'wcpl'),
            ),
        );
        $this->options['root'] = dirname(dirname(dirname(dirname(__FILE__))));
    }

    private function check_kind($kind)
    {
        foreach( $this->options['kind'] as $year => $data ) {
            foreach( $data as $value => $label ) {
                if ( $kind == $value ) {
                    return true;
                }
            }
        }
        return false;
    }

    public function widget($args, $instance)
    {
        if ( empty( $instance['kind'] ) ) {
            $instance['kind'] = '2015/banners/250_250.jpg';
        }
        if ( !$this->check_kind($instance['kind']) ) {
            return;
        }
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        printf(
            '<a href="%s"><img src="%s" alt="%s" /></a>',
            esc_attr('https://goo.gl/GC92jC'),
            plugins_url('images/'.$instance['kind'], $this->options['root'].'/wcpl.php'),
            __('WordCamp Poland', 'wcpl')
        );
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'WordCamp Poland 2015', 'wcpl' );
?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wcpl' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
<?php
        $kind = ! empty( $instance['kind'] ) ? $instance['kind'] : '';
?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Kind:', 'wcpl' ); ?></label> 
        <select class="widefat" id="<?php echo $this->get_field_id( 'kind' ); ?>" name="<?php echo $this->get_field_name( 'kind' ); ?>">
<?php
        foreach( $this->options['kind'] as $year => $data ) {
            printf ( '<optgroup label="%s">', esc_attr($year));
            foreach( $data as $value => $label ) {
                printf(
                    '<option value="%s"%s>%s</option>',
                    esc_attr($value),
                    $value == $kind? ' selected="selected"':'',
                    esc_html($label)
                );
            }
            echo '</optgroup>';
        }
?>
        </select>
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['kind'] = ( ! empty( $new_instance['kind']) && $this->check_kind($new_instance['kind'])) ? $new_instance['kind']:'';
        return $instance;
    }
}
