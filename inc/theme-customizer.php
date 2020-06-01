<?php

function theme_customizer($wp_customize){
    $wp_customize->add_section('sec_header_contact',array(
        'title'=> 'Contact Us',
        'description'=>'Contact Us here'
    ));

    $wp_customize->add_setting('set_header_contact_label',array(
        'type'=>'theme_mod',
        'default' => '',
        'sanitize_callback' => 'esc_attr'
    ));
    $wp_customize->add_setting('set_header_contact_info',array(
        'type'=>'theme_mod',
        'default' => '',
        'sanitize_callback' => 'esc_attr'
    ));

    $wp_customize->add_control('ctrl_header_contact_label',array(
        'label'=> 'Contact Label',
        'description' => 'Type your Contact Label',
        'section' => 'sec_header_contact',
        'settings'=> 'set_header_contact_label',
        'type'=>'text'
    ));

    $wp_customize->add_control('ctrl_header_contact_info',array(
        'label'=> 'Contact Info',
        'description' => 'Type your Contact Number',
        'section' => 'sec_header_contact',
        'settings'=> 'set_header_contact_info',
        'type'=>'text'
    ));
}

add_action('customize_register','theme_customizer');

?>