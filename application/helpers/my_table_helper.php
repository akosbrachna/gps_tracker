<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( function_exists('draw_table') == false)
{
    function draw_table($records)
    {
        if (count($records)== 0)
        {
            return;
        }
        echo '<div id="main">';
        echo '<table class="sortable table" border="0" cellpadding="4" cellspacing="0">'.PHP_EOL;
        draw_table_header($records);        
        foreach ($records as $row)
        {
            draw_table_row($row);
        }
        echo '</table>';
        echo '</div>';
    }   
}

if ( function_exists('draw_table_header') == false)
{
    function draw_table_header($query)
    {
        echo '<thead>';
        $array = array_keys($query[0]);
        if ($array[0]=='id') unset($array[0]);
        foreach ($array as $field_name)
        {
            echo '<th>'.$field_name.'</th>'.PHP_EOL;
        }
        echo '</thead>'.PHP_EOL;
    }
}
if ( function_exists('draw_table_row') == false)
{
    function draw_table_row($row)
    {
        echo '<tr class="table_row" id=';
        if (isset($row['id'])) 
        {
            echo $row['id'];
            unset($row['id']);
        }
        echo '>';
        foreach ($row as $key=>$value)
        {
            echo '<td>'.$value.'</td>'.PHP_EOL;
        }
        echo '</tr>';
    }
}

if ( function_exists('draw_table_checkbox') == false)
{
    function draw_table_checkbox($records, $post = '1')
    {
        if(count($records) == 0)
        {
            echo 'no records in table';
            return;
        }
        echo '<table id="controller_table" class="sortable table" border="0" cellpadding="4" cellspacing="0" >';
        draw_table_header_checkbox($records);
        echo '<tbody>';
        foreach ($records->result() as $row)
        {
            draw_table_row_checkbox($row, $post);
        }
        echo '</tbody>';
        echo '</table>';
    }   
}
if ( function_exists('draw_table_header_checkbox') == false)
{
    function draw_table_header_checkbox($query)
    {
        echo '<thead><tr>';
        echo '<th>Top menu</th>';
        echo '<th>Side menu group</th>';
        echo '<th>Side menu link</th>';
        echo '<th>Access to link?</th>';
        echo '<th>Can access all users?</th>';
        echo '<th>Can access all companies?</th>';
        echo '</tr></thead>';
    }
}
if ( function_exists('draw_table_row_checkbox') == false)
{
    function draw_table_row_checkbox($row, $post = '1')
    {
        echo '<tr>';
        echo '<td>'.ucfirst($row->TopMenu).'</td>'.PHP_EOL;
        echo '<td>'.$row->SideMenuGroup.'</td>'.PHP_EOL;
        echo '<td>'.$row->SideMenuLink.'</td>'.PHP_EOL;
        echo '<td style="text-align:center;">'
           . '<input name="'.$row->controller.'" '
           . 'type="checkbox" style="size: 15px;" ';
        if($row->access_group == $post)
        {
                echo ' checked value="controller"';
        }
        echo ' /></td>'.PHP_EOL;
        echo '<td style="text-align:center;">'
           . '<input name="can_access_all_users_on_'.$row->controller.'" '
           . 'type="checkbox" style="size: 15px;" ';
        if($row->can_access_all_users == 1)
        {
                echo ' checked value="users"';
        }
        echo ' /></td>'.PHP_EOL;
        echo '<td style="text-align:center;">'
           . '<input name="can_access_all_companies_on_'.$row->controller.'" '
           . 'type="checkbox" style="size: 15px;" ';
        if($row->can_access_all_companies == 1)
        {
                echo ' checked value="companies"';
        }
        echo ' /></td></tr>'.PHP_EOL;
    }
}

if ( function_exists('draw_table_input') == false)
{
    function draw_table_input($records, $elem)
    {
        if (count($records)== 0)
        {
            return;
        }
        echo '<rows> (';
        echo count($records).' rows in table)'; 
        echo '</rows>'.PHP_EOL;
        echo '<main>';
        echo '<table class="sortable table" border="0" cellpadding="4" cellspacing="0">'.PHP_EOL;
        draw_table_input_header($records);        
        foreach ($records as $row)
        {
            draw_table_input_row($row, $elem);
        }
        echo '</table>';
        echo '</main>';
    }   
}
if ( function_exists('draw_table_input_header') == false)
{
    function draw_table_input_header($query)
    {
        echo '<thead>';
        $array = array_keys($query[0]);
        if ($array[0]=='id') unset($array[0]);
        foreach ($array as $field_name)
        {
            echo '<th>'.$field_name.'</th>'.PHP_EOL;
        }
        echo '</thead>'.PHP_EOL;
    }
}
if ( function_exists('draw_table_input_row') == false)
{
    function draw_table_input_row($row, $elem)
    {
        $row_id = $row['id'];
        unset($row['id']);
        echo '<tr class="table_row" id='.$row_id.'>';
        foreach ($row as $key=>$value)
        {
            if ($key == 'ETA')
            {
                if ($elem == 'textarea')
                {
                    echo '<td><textarea style="height: 42px;" name="'.$row_id.'">'.$value.'</textarea></td>'.PHP_EOL;
                }
                else
                {
                    echo '<td><input name="'.$row_id.'" value="'.$value.'" ></td>'.PHP_EOL;
                }
            }
            else
            {
                echo '<td>'.$value.'</td>'.PHP_EOL;
            }
        }
        echo '</tr>';
        
    }
}

if ( function_exists('draw_table_mail') == false)
{
    function draw_table_mail($records)
    {
        if (count($records)== 0)
        {
            return;
        }
        $data = '<br />';
        $data .= '<table>';
        $data .= '<thead>';
        $array = array_keys($records[0]);
        foreach ($array as $field_name)
        {
            $data .= '<th>'.$field_name.'</th>';
        }
        $data .= '</thead>';
        foreach ($records as $row)
        {
            $data .= '<tr>';
            foreach ($row as $key=>$value)
            {
                if ($key == 'ETA') $data .= '<td><font color="red"><b>'.$value.'</b></font></td>';
                else $data .= '<td>'.$value.'</td>';
            }
            $data .= '</tr>';
        }
        $data .= '</table>';
        return $data;
    }   
}