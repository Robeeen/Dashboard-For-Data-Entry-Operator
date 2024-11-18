<?php

//===========================================
//10.11.2024
//Search  Query
$args = array(
    's' => 'keyword',
);
$query = new WP_Query($args);


//Display posts tagged with bob, under people custom taxonomy:
$args = array(
    'post_type' => 'post',
    'tax_query' => array(
        array(
            'taxonomy' => 'people',
            'field' => 'slug',
            'terms' => 'bob',
        ),
    ),
);

$query = new WP_Query($args);

//Display posts that are in the quotes category OR have the quote post format:
$args = array(
    'post_type' => 'post',
    'tax_query' => array(
    'relation' => 'OR',
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => array(
                'quotes'
            ),
        ),
        array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array('post-format-quote'),
        )
    )
        );

//Display posts that have one tag, using tag slug:
$query = new WP_Query( array( 'tag' => 'cooking' ) );

//Display post by ID:
$query = new WP_Query(array('p' => 10));

//Display child pages using parent page ID:
$query = new WP_Query(array('post_parent' => 10));

//Display post using per page
$query = new WP_Query(array('posts_per_page' => 10));
$query = new WP_Query( array( 'posts_per_page' => -1 ) );

//To display posts from either category 2 OR 6, 
$query = new WP_Query( array( 'category__in' => array( 2, 6 ) ) );

//Display 5 posts per page which follow the 3 most recent posts:
$query = new WP_Query( array( 'posts_per_page' => 5, 'offset' => 3 ) );

$query = new WP_Query( array( 'author' => 123 ) );

