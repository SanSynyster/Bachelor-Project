<?php

// Admin ->
function isUserAdmin($user_id)
{
    return user_can($user_id, 'administrator');
}

function isCurrentUserAdmin()
{
    return current_user_can('administrator');
}
// Admin <-

// Author ->
function isUserAuthor($user_id)
{
    return user_can($user_id, 'author');
}

function isCurrentUserAuthor()
{
    return current_user_can('author');
}
// Author <-

// bbbAdmin ->
function isUserBbbAdmin($user_id)
{
    return user_can($user_id, 'bbbAdmin');
}

function isCurrentUserBbbAdmin($user_id)
{
    return current_user_can('bbbAdmin');
}
// bbbAdmin <-

// Teacher ->
function isUserTeacher($user_id)
{
    return user_can($user_id, 'teacher');
}

function isCurrentUserTeacher()
{
    return current_user_can('teacher');
}
// Teacher <-

function isUserTeacherOfProduct($user_id, $product_id)
{
    $teachers = get_field("teachers", $product_id);
    foreach ($teachers as $t) {
        if ($t['user']->ID == $user_id) {
            return true;
        }
    }
    return false;
}

function isCurrentUserTeacherOfProduct($product_id)
{
    if (!is_user_logged_in()) return false;

    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;

    return isUserTeacher($current_user_id, $product_id);
}



function isCurrentUserBoughtCurrentProduct()
{
    if (!is_user_logged_in()) return false;

    return has_bought_item(get_the_ID());
}


function isCurrentUserHavePermissionForProduct($product_id)
{
    if (!is_user_logged_in()) return false;

    return has_bought_item($product_id) or isCurrentUserTeacherOfProduct($product_id) or isCurrentUserAdmin();
}

function isCurrentUserHavePermissionToAnswerTicket($parent_id)
{
    $current_user_id = get_current_user_id();
    $author_id = get_post_field('post_author', $parent_id);
    $product_id = get_field('product_id', $parent_id);

    if (isCurrentUserTeacherOfProduct($product_id) or isCurrentUserAdmin())
        return TRUE;

    if ($author_id == $current_user_id or get_field('user', $parent_id) == $current_user_id)
        return true;

    if (isUserTeacherOfProduct(get_field('user', $parent_id), $product_id))
        return true;

    return FALSE;
}

function isUserHaveAuthorPage($user_id)
{
    if (isUserTeacher($user_id) or isUserAuthor($user_id)) {
        return true;
    }
    return false;
}
