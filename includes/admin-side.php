<?php

// Adds meta box
function lwppd_meta_box() {
    // Meta box ID, meta box title, function to call, where to show meta box
	add_meta_box( 'lwppd_contributors_box', 'Contributors', 'lwppd_meta_box_content', 'post');
}
add_action( 'add_meta_boxes', 'lwppd_meta_box' );

// Adds meta box content
function lwppd_meta_box_content( $post ) {
    // Validates that form content came from location on current site and not somewhere else
    wp_nonce_field( basename( __FILE__ ), 'lwppd_contributors_box_nonce' );
    // Only gets users who are 'author', 'editor' and 'administrator'; and puts them into array
    $contributors = get_users( array( 'role__in' => array( 'author', 'editor', 'administrator' ) ) );
    
    // For each user in $contributors
    foreach ( $contributors as $user ) {
        $id = $user->ID;
        $name = $user->display_name;
        $checkbox_value = get_post_meta( $post->ID, 'contributor_' . $id, true ); // Saved value of checkbox (1 or 0)
    ?>
        <label for="<?php echo esc_attr( $id ); ?>">
            <!-- Checkbox with ID of current user in $contributors as id and name;
            value="1" is value to be sent to server when checkbox is checked;
            checked() is used to check if $checkbox_value is 1 or not and inserts 'checked' attribute if it is 1, making checkbox checked -->
            <input type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>" value="1" <?php checked( $checkbox_value, '1' ); ?> />
            <!-- Displays name of current user in $contributors -->
            <?php echo esc_html( $name ); ?>
        </label>
    <?php
    }
}

// Saves meta box when post is saved
function lwppd_meta_box_save( $post_id ) {
    // Checks nonce and exit function if $_POST[ 'lwppd_contributors_box_nonce' ] is not declared or null, or wp_verify_nonce() is false
    if ( !isset( $_POST[ 'lwppd_contributors_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'lwppd_contributors_box_nonce' ], basename( __FILE__ ) ) ) {
        return;
    }

    // Only gets users who are 'author', 'editor' and 'administrator'; and puts them into array
    $contributors = get_users( array( 'role__in' => array( 'author', 'editor', 'administrator' ) ) );

    foreach ( $contributors as $user ) {
        $id = $user->ID;
        // Tests if $_POST[$id] () is declared and is different than null or not; 1 if true, 0 if false
        $checkbox_value = isset( $_POST[ $id ] ) ? '1' : '0';
        // For $post_id, updates meta key 'contributor_' . $id with $checkbox_value (so those with 1 will be checked in post editor)
        update_post_meta( $post_id, 'contributor_' . $id, $checkbox_value );
    }
}
add_action( 'save_post', 'lwppd_meta_box_save' );
