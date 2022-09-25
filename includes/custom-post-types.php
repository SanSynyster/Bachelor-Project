<?php

function video_post_types()
{
    register_post_type('video', array(
        'capability_type' => 'video',
        'map_meta_cap' => true,
        'supports' => ['title', 'thumbnail', 'author'],
        'rewrite' => array(
            // 'with_front' => true,
            'slug' => 'video',
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Videos',
            'add_new_item' => 'Add new video',
            'edit_item' => 'Edit video',
            'all_items' => 'All videos',
            'singular_name' => 'Video',
            'new_item' => 'New video',
            'add_new' => 'Add new video',
            'search_items'  => 'Search video'
        ),
        'menu_icon' => 'dashicons-format-video',
        'exclude_from_search' => false, //'true' - site/?s=search-term will not include posts of this post type.
        'menu_position' => 21,
    ));
}

add_action('init', 'video_post_types');

function videoresult_post_type()
{
    register_post_type('videoresult', array(
        'capability_type' => 'videoresult',
        'map_meta_cap' => true,
        'supports' => array('title', 'author'),
        'rewrite' => array(
            // 'with_front' => true,
            'slug' => 'videoresult',
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Video Rate Result',
            'add_new_item' => 'Add new Video Rate Result',
            'edit_item' => 'Edit Video Rate Result',
            'all_items' => 'All Video Rate Result',
            'singular_name' => 'Video Rate Result',
            'new_item' => 'new Video Rate Result',
            'add_new' => 'new Video Rate Result',
            'search_items'  => 'search Video Rate Result'
        ),
        'menu_icon' => 'dashicons-format-chat',
        'exclude_from_search' => false, //'true' - site/?s=search-term will not include posts of this post type.
        'menu_position' => 22,
    ));
}

add_action('init', 'videoresult_post_type');

function compare_video_post_types()
{
    register_post_type('compare-video', array(
        'capability_type' => 'compare-video',
        'map_meta_cap' => true,
        'supports' => ['title', 'thumbnail', 'author'],
        'rewrite' => array(
            // 'with_front' => true,
            'slug' => 'compare-video',
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Compare Videos',
            'add_new_item' => 'Add new Compare video',
            'edit_item' => 'Edit compare video',
            'all_items' => 'All compare videos',
            'singular_name' => 'Compare Video',
            'new_item' => 'New compare video',
            'add_new' => 'Add new compare video',
            'search_items'  => 'Search compare video'
        ),
        'menu_icon' => 'dashicons-format-video',
        'exclude_from_search' => false, //'true' - site/?s=search-term will not include posts of this post type.
        'menu_position' => 23,
    ));
}

add_action('init', 'compare_video_post_types');




function compare_video_result_post_type()
{
    register_post_type('compare-video-result', array(
        'capability_type' => 'compare-video-result',
        'map_meta_cap' => true,
        'supports' => array('title', 'author'),
        'rewrite' => array(
            // 'with_front' => true,
            'slug' => 'compare-video-result',
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Compare Video Rate Result',
            'add_new_item' => 'Add new Compare Video Rate Result',
            'edit_item' => 'Edit Compare Video Rate Result',
            'all_items' => 'All Compare Video Rate Result',
            'singular_name' => 'Compare Video Rate Result',
            'new_item' => 'new Compare Video Rate Result',
            'add_new' => 'new Compare Video Rate Result',
            'search_items'  => 'search Compare Video Rate Result'
        ),
        'menu_icon' => 'dashicons-format-chat',
        'exclude_from_search' => false, //'true' - site/?s=search-term will not include posts of this post type.
        'menu_position' => 24,
    ));
}

add_action('init', 'compare_video_result_post_type');


function advance_compare_video_post_types()
{
    register_post_type('advance-compare', array(
        'capability_type' => 'advance-compare',
        'map_meta_cap' => true,
        'supports' => ['title', 'thumbnail', 'author'],
        'rewrite' => array(
            // 'with_front' => true,
            'slug' => 'advance-compare',
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Advance Compare Videos',
            'add_new_item' => 'Add new Advance Compare video',
            'edit_item' => 'Edit advance compare video',
            'all_items' => 'All advance compare videos',
            'singular_name' => 'Advance Compare Video',
            'new_item' => 'New Advance compare video',
            'add_new' => 'Add new Advance compare video',
            'search_items'  => 'Search Advance compare video'
        ),
        'menu_icon' => 'dashicons-format-video',
        'exclude_from_search' => false, //'true' - site/?s=search-term will not include posts of this post type.
        'menu_position' => 25,
    ));
}

add_action('init', 'advance_compare_video_post_types');



function advance_compare_video_foren_post_types()
{
    register_post_type('ac-foren', array(
        'capability_type' => 'ac-foren',
        'map_meta_cap' => true,
        'supports' => ['title', 'thumbnail', 'author'],
        'rewrite' => array(
            // 'with_front' => true,
            'slug' => 'ac-foren',
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Advance Compare Foreigner Videos',
            'add_new_item' => 'Add new Advance Compare Foreigner video',
            'edit_item' => 'Edit Advance Compare Foreigner video',
            'all_items' => 'All Advance Compare Foreigner videos',
            'singular_name' => 'Advance Compare Foreigner Video',
            'new_item' => 'New Advance Compare Foreigner video',
            'add_new' => 'Add new Advance Compare Foreigner video',
            'search_items'  => 'Search Advance Compare Foreigner video'
        ),
        'menu_icon' => 'dashicons-format-video',
        'exclude_from_search' => false, //'true' - site/?s=search-term will not include posts of this post type.
        'menu_position' => 25,
    ));
}

add_action('init', 'advance_compare_video_foren_post_types');


function wptags_comment()
{
    get_template_part('comment');
}



function advance_compare_video_result_post_type()
{
    register_post_type('advance-result', array(
        'capability_type' => 'advance-result',
        'map_meta_cap' => true,
        'supports' => array('title', 'author'),
        'rewrite' => array(
            // 'with_front' => true,
            'slug' => 'advance-result',
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Advance Compare Video Result',
            'add_new_item' => 'Add new Advance Compare Video Result',
            'edit_item' => 'Edit Advance Compare Video Result',
            'all_items' => 'All Advance Compare Video Result',
            'singular_name' => 'Advance Compare Video Result',
            'new_item' => 'new Advance Compare Video Result',
            'add_new' => 'new Advance Compare Video Result',
            'search_items'  => 'search Advance Compare Video Result'
        ),
        'menu_icon' => 'dashicons-format-chat',
        'exclude_from_search' => false, //'true' - site/?s=search-term will not include posts of this post type.
        'menu_position' => 26,
    ));
}

add_action('init', 'advance_compare_video_result_post_type');


add_theme_support('post-thumbnails');
