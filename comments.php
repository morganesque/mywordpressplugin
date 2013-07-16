<?php

/*
    Take control of the HTML used to display
*/

function tom_comment($comment, $args, $depth) 
{
    // PreDump($args);
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

        <div id="comment-<?php comment_ID(); ?>">

            <div class="comment-author">
                <div class="avatar-frame"><?php echo get_avatar($comment,$size=$args['avatar_size'],$default='<path_to_url>' ); ?></div>
            <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
            </div>
            
            <?php if ($comment->comment_approved == '0') : ?>
            <div class="notice"><em><?php _e('Your comment is awaiting moderation.') ?></em></div>
            <?php endif; ?>

            <div class="comment-meta commentmetadata">
                <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?>
            </div>

            <?php comment_text() ?>

            <div class="reply">
            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>
        
        </div>
        <!-- We don't close the <li> that's done in a different funciton!!!! -->
        <?php
}


/*
    Then you have to call this function to display the comments

    $args = array('avatar_size'=>100,'callback'=>'tom_comment');
    wp_list_comments($args); 
*/

?>