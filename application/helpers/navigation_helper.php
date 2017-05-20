<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( function_exists('nav_side_menu') == false)
{
    function nav_side_menu($menu)
    {
        $num = $menu->num_rows();
        if ($num == 0) return;
        $items = $menu->result();
        $i=0;
        echo '<div id="'.$items[$i]->navigation_menu.'" class="side_menu_div" style="display:none;">';
        echo '<ol class="side_menu">';
        while ($i<$num)
        {
            $submenu = $items[$i]->submenu;
            echo '<li class="menu_section">';
                echo $items[$i]->submenu
                     . '<ol>';
                while($i<$num)
                {
                    echo '<li class="file"><a class="side_menu_item" href="'.$items[$i]->controller.'">'
                          .$items[$i]->title.'</a></li>';
                    $i++;
                    if ($i == $num)
                    break;
                    if($items[$i]->submenu <> $submenu)
                    {
                        break;
                    }
                }
                echo '</ol>'
                .'</li>';
                if ($i==$num) break;
        }
        echo '</ol>';
        echo '</div>';
    }
}

if ( function_exists('nav_top_menu') == false)
{
    function nav_top_menu($menus)
    {
        $num = $menus->num_rows();
        if ($num == 0) return;
        foreach ($menus->result() as $item)
        {
            if ($item->navigation_menu <> '')
            {
                echo '<li class="nav_menu" href="#'.$item->navigation_menu.'">'
                     .ucfirst($item->navigation_menu).'</li>';
            }
        }
    }
}

if ( function_exists('nav_side_menu_dynamic') == false)
{
    function nav_side_menu_dynamic($menu)
    {
        $num = $menu->num_rows();
        $items = $menu->result();
        $i=0;
        $nav = '<ol class="tree">';
        while ($i<$num)
        {
            $submenu = $items[$i]->submenu;
            echo '<li>';
                echo '<label for="'.$items[$i]->submenu.'">'.$items[$i]->submenu
                    .'</label><input type="checkbox" id="'.$items[$i]->submenu.'" />'
                     . '<ol>';
                while($i<$num)
                {
                    echo '<li class="file"><a href="'.$items[$i]->controller.'">'.$items[$i]->title.'</a></li>';
                    $i++;
                    if($items[$i]->submenu <> $submenu)
                    {
                        break;
                    }
                }
                echo '</ol>'
                .'</li>';
        }
        $nav.= '</ol>';
    }
}
