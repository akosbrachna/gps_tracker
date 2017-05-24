<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class csv
{
    public function generate_csv($data)
    {
        $i = 0;
        $csv = null; 
        $csv_data = null; 
        $field_names = null;
        foreach ($data['records'] as $row)
        {
            $num = count($row)-1;
            $n = 0;
            foreach ($row as $key => $field)
            {
                if ($i == 0)
                {
                    $field_names .= $key;
                    if ($n < $num)
                        $field_names .= ';';
                }
                $csv_data .= $field;
                if ($n < $num)
                    $csv_data .= ';';
                $n++;
            }
            if ($i == 0)
            {
                $csv .= "$field_names\n\r";
                $i = 1;
            }
            $csv .= "$csv_data\n\r";
            $csv_data = null;
        }
        $fp = fopen($data['absolute_path'], "w+");
        fwrite($fp, $csv);
        fclose($fp);
    }
    
    public function get_data_from_file($file)
    {
        $replace = array("'",'"');
        $table = array();
        $h = fopen($file, "r");
        $fields = explode(';', fgets($h));
        $count = count($fields);
        $error = array();
        for ($i=0; $i<count($fields); $i++)
        {
            $fields[$i] = trim($fields[$i]);
        }
        while (false !== ($line = fgets($h)))
        {
            $line = str_replace($replace, '', $line);
            $row = explode(';', $line);
            if (count($row) != $count)
            {
                $error[] = $row;
                continue;
            }
            $row_item = array();
            foreach ($row as $key => $value)
            {
                trim($value, "\"\'");
                $row_item[$fields[$key]] = trim($value);
            }
            $data[] = $row_item;
        }
        fclose($h);
        unlink($file);
        $table['fields'] = $fields;
        $table['data']   = $data;
        $table['error']  = (count($error) != 0)?$error:false;
        return $table;
    }

}