<?php

function lwppd_show_contributors( $content ) {
    // Only gets users who are 'author', 'editor' and 'administrator'; and puts them into array
    $contributors = get_users( array( 'role__in' => array( 'author', 'editor', 'administrator' ) ) );
    
    // Checks if $content is a post or not    
    if ( is_single() ) {
            $content .= '<h5>Contributors</h5>';

            // For each user in $contributors
            foreach ( $contributors as $user ) {
                $id = $user->ID;
                $name = $user->display_name;
                $role = $user->roles[0]; // Role of $user
                $gravatar = get_avatar_url( $id ); // Avatar of $id
                $author_page = get_author_posts_url( $id ); // Link to author page of $id
                $current_post_id = get_the_ID(); // ID of post being displayed
                $checkbox_value = get_post_meta( $current_post_id, 'contributor_' . $id, true ); // Checks whether user is contributor (1) or not (0)

                // Only adds authors who are checked as contributor
                if ( '1' === $checkbox_value ) {
                    $content .=
                        '<div class="container">
                            <div>
                                <img class="profile-pic" src="' . $gravatar . '" />
                            </div>
                            <div>
                                <span class="' . $role . '"><a href="' . $author_page . '">' . $name . '</a></span>
                            </div>
                        </div>';
                }
            }
    }
    return $content;
}
add_filter( 'the_content', 'lwppd_show_contributors' );
