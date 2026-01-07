<?php
//This file holds all the functions required for our main <header> navigations to work

// Build out primary-menu 
function mobile_nav_build_primary($menu_name) {
    if (empty($menu_name)) {
        return false;
    }

    $menu_items = wp_get_nav_menu_items($menu_name);

    $menu_items = mobile_nav_extend_nav_menu_items($menu_items);

    //
    if (get_field('mobile_menu_type', 'options') === 'dropdown') {
        $sub_menu_style = 'dropdown';
    } else if (get_field('mobile_menu_type', 'options') === 'paginated') {
        $sub_menu_style = 'paginated';
    }

    // Now, begin building the HTML
    ob_start();
?>
    <ul class="toggled-menu <?= strtolower($menu_name) ?>" data-level="1">
        <?php
        foreach ($menu_items as $item) :
            // Skip if not a top level item
            if ($item->menu_item_parent !== '0') {
                continue;
            }

            $classes = mobile_nav_build_classes('menu-item', $item);
        ?>
            <li id="menu-item-<?= $item->ID; ?>" class="<?= $classes; ?>" <?php if (count($item->submenu_items) > 0) : ?>data-sub-menu-style="<?= $sub_menu_style ?>" <?php endif; ?>>
                <?php
                mobile_nav_build_parent_link($item);

                // Secondary menu level
                if (count($item->submenu_items) > 0) :
                    mobile_nav_build_sub_menu($item, $item->submenu_items);
                endif;
                ?>
            </li>
        <?php
        endforeach;
        ?>
    </ul>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
}

//Create a map/dictionary where each parent menu item's index position is saved to array
function mobile_nav_create_submenu_index_map($menu_items) {
    $map = [];
    foreach ($menu_items as $index => $item) {
        if ($item->menu_item_parent) {
            if (!isset($map[$item->menu_item_parent])) {
                $map[$item->menu_item_parent] = array_search($item->menu_item_parent, array_column($menu_items, 'ID'));
            }
        }
    }

    return $map;
}

//Extend menu item object w/ 3 custom properties
function mobile_nav_extend_nav_menu_items($menu_items) {

    // Ref array that maps parent menu id to its index
    $map = mobile_nav_create_submenu_index_map($menu_items);

    foreach ($menu_items as $item) {
        $isParent = $item->menu_item_parent;

        // Initialize a custom object property containing an array of objects
        $item->submenu_items = [];
        if ($item->menu_item_parent) {
            $parent_menu_item = $menu_items[$map[$item->menu_item_parent]];

            // If object has menu item parent, map menu item parent to nav index 
            // Push submenu items into new custom subemnu_item property
            array_push($parent_menu_item->submenu_items, $item);
        }

        // Check menu item ID matches current page
        $item->current_page = false;
        if (get_the_id() === (int)$item->object_id) {
            $item->current_page = true;
        }
    }

    return $menu_items;
}

//Build out list item class string
function mobile_nav_build_classes($initial_class, $item) {
    $hasSubMenu = false;

    if (!empty($item->submenu_items)) {
        $hasSubMenu = true;
    }

    $isCurrentPage = $item->current_page;

    $class = $initial_class;
    if ($hasSubMenu) {
        $class .= ' has-sub-menu';
    }
    if ($isCurrentPage) {
        $class .= ' current-menu-item';
    }

    return $class;
}

//Build out parent menu link & button
function mobile_nav_build_parent_link($item) {
    $id = $item->ID;
    $title = $item->title;
    $url = $item->url;
    $hasSubMenuMenu = count($item->submenu_items) > 0;

    $isNewTab = $item->target !== '' ? 'target="_blank"' : '';
    $isEmpty = $item->url == '#' ? true : false;

    $hasUrlAndSubMenu = !$isEmpty && $hasSubMenuMenu;
    $hasUrlAndNoSubMenu = !$isEmpty && !$hasSubMenuMenu;
    $hasNoUrlAndSubMenu = $isEmpty && $hasSubMenuMenu;

    if ($hasUrlAndSubMenu) :
    ?>
        <a href="<?= $url; ?>" <?= $isNewTab; ?>><?= $title; ?></a>
        <button type="button" class="sub-menu-toggle" aria-expanded="false" aria-controls="sub-menu-<?= $id ?>">
            <span class="icon"></span>
            <span class="accessible-text">Open <?= $title; ?></span>
        </button>
    <?php
    endif;
    if ($hasNoUrlAndSubMenu) :
    ?>
        <button type="button" class="sub-menu-toggle no-parent-link" aria-expanded="false" aria-controls="sub-menu-<?= $id ?>">
            <?= $title; ?>
            <span class="icon"></span>
        </button>
    <?php
    endif;
    if ($hasUrlAndNoSubMenu) :
    ?>
        <a href="<?= $url; ?>" <?= $isNewTab; ?>>
            <?= $title; ?>
        </a>
    <?php
    endif;
}

//Build out recursive sub-menu 
function mobile_nav_build_sub_menu($parent_item, $submenu, $data_level = 2) {
    $parent_id = $parent_item->ID;
    $parent_title = $parent_item->title;
    ?>
    <ul id="sub-menu-<?= $parent_id; ?>" class="toggled-sub-menu" data-level="<?= $data_level ?>" aria-hidden="true">
        <?php
        if (get_field('mobile_menu_type', 'options') === 'paginated') :
        ?>
            <li class="breadcrumb-item">
                <button type="button" class="sub-menu-back" aria-controls="sub-menu-<?= $parent_id; ?>">
                    <span class="icon"></span>
                    <span class="accessible-text">Back to <?= $parent_title; ?></span>
                </button>
            </li>
        <?php
        endif;
        ?>
        <?php
        foreach ($submenu as $item) :
            $classes = mobile_nav_build_classes('sub-menu-item', $item);
        ?>
            <li id="menu-item-<?= $item->ID; ?>" class="<?= $classes; ?>">
                <?php
                mobile_nav_build_parent_link($item);

                // Secondary menu level
                if (count($item->submenu_items) > 0) :
                    mobile_nav_build_sub_menu($item, $item->submenu_items, $data_level + 1);
                endif;
                ?>
            </li>
        <?php
        endforeach;
        ?>
    </ul>
<?php
}
?>