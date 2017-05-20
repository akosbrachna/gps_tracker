<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( function_exists('pdf_layout') == false)
{
    function pdf_layout($sections, $settings, $records)
    {
        foreach ($sections as $section)
        {
            ?>
            <hr style="color: red;" />
            <TABLE class="t0">
                <TBODY>
                    <TR class="tr_header">
                        <TD><P class="p0 ft1"><?php echo $section ?></P><TD>
                    </TR>
                    <?php pdf_field($section, $settings, $records);?>
                </TBODY>
            </TABLE>
            <?php
        }
    }
}

if ( function_exists('pdf_field') == false)
{
    function pdf_field($section, $settings, $records)
    {
        foreach ($settings as $value)
        {
            if ($section == $value['pdf_section'])
            {
            ?>
            <TR>
                <TD class="td0"><P class="p0 ft0"><?php echo $value['pdf_field_name'] ?></P></TD>
                <TD class="td1">
                    <P class="p0 ft0"><?php echo $records[$value['table_field_name']]; ?></P>
                </TD>
            </TR>
            <?php
            }
        }
    }
}
