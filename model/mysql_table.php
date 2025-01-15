<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

class PDF_MySQL_Table extends FPDF
{
    protected $ProcessingTable = false;
    protected $aCols = array();
    protected $TableX;
    protected $HeaderColor;
    protected $RowColors;
    protected $ColorIndex;

    function Header()
    {
        if ($this->ProcessingTable)
            $this->TableHeader();
    }

    function TableHeader()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetX($this->TableX);
        $fill = !empty($this->HeaderColor);
        if ($fill)
            $this->SetFillColor($this->HeaderColor[0], $this->HeaderColor[1], $this->HeaderColor[2]);
        foreach ($this->aCols as $col) {
            $utf8Text = mb_convert_encoding($col['c'], 'ISO-8859-1', 'UTF-8');
            $this->Cell($col['w'], 6, $utf8Text, 1, 0, 'C', $fill);
        }
        $this->Ln();
    }

    function Row($data)
    {
        $this->SetX($this->TableX);
        $ci = $this->ColorIndex;
        $fill = !empty($this->RowColors[$ci]);
        if ($fill)
            $this->SetFillColor($this->RowColors[$ci][0], $this->RowColors[$ci][1], $this->RowColors[$ci][2]);
        foreach ($this->aCols as $col) {
            $utf8Text = mb_convert_encoding($data[$col['f']], 'ISO-8859-1', 'UTF-8');
            $this->Cell($col['w'], 10, $utf8Text, 1, 0, $col['a'], $fill);
        }
        $this->Ln();
        $this->ColorIndex = 1 - $ci;
    }

    function CalcWidths($width, $align)
    {
        $TableWidth = 0;
        foreach ($this->aCols as $i => $col) {
            $w = $col['w'];
            if ($w == -1)
                $w = $width / count($this->aCols);
            elseif (substr($w, -1) == '%')
                $w = $w / 100 * $width;
            $this->aCols[$i]['w'] = $w;
            $TableWidth += $w;
        }
        if ($align == 'C')
            $this->TableX = max(($this->w - $TableWidth) / 2, 0);
        elseif ($align == 'R')
            $this->TableX = max($this->w - $this->rMargin - $TableWidth, 0);
        else
            $this->TableX = $this->lMargin;
    }

    function AddCol($field = -1, $width = -1, $caption = '', $align = 'L')
    {
        if ($field == -1)
            $field = count($this->aCols);
        $this->aCols[] = array('f' => $field, 'c' => $caption, 'w' => $width, 'a' => $align);
    }

    function Table($db, $query, $prop = array())
    {
        try {
            $res = $db->query($query);
        } catch (PDOException $ex) {
            echo "Error in query: " . $query;
            echo $ex->getMessage();
        }


        if (count($this->aCols) == 0) {
            //$nb=mysqli_num_fields($res);
            $nb = $res->columnCount();
            for ($i = 0; $i < $nb; $i++)
                $this->AddCol();
        }

        $fields = array_keys($res->fetch(PDO::FETCH_ASSOC));

        foreach ($this->aCols as $i => $col) {
            if ($col['c'] == '') {
                if (is_string($col['f']))
                    $this->aCols[$i]['c'] = ucfirst($col['f']);
                else
                    //$this->aCols[$i]['c']=ucfirst(mysqli_fetch_field_direct($res,$col['f'])->name);
                    $this->aCols[$i]['c'] = ucfirst($fields[$i]);
            }
        }

        if (!isset($prop['width']))
            $prop['width'] = 0;
        if ($prop['width'] == 0)
            $prop['width'] = $this->w - $this->lMargin - $this->rMargin;
        if (!isset($prop['align']))
            $prop['align'] = 'C';
        if (!isset($prop['padding']))
            $prop['padding'] = $this->cMargin;
        $cMargin = $this->cMargin;
        $this->cMargin = $prop['padding'];
        if (!isset($prop['HeaderColor']))
            $prop['HeaderColor'] = array();
        $this->HeaderColor = $prop['HeaderColor'];
        if (!isset($prop['color1']))
            $prop['color1'] = array();
        if (!isset($prop['color2']))
            $prop['color2'] = array();
        $this->RowColors = array($prop['color1'], $prop['color2']);

        $this->CalcWidths($prop['width'], $prop['align']);

        $this->TableHeader();

        $this->SetFont('Arial', '', 9);
        $this->ColorIndex = 0;
        $this->ProcessingTable = true;


        $res = $db->query($query);
        while ($row = $res->fetch(PDO::FETCH_BOTH))
            $this->Row($row);

        $this->ProcessingTable = false;
        $this->cMargin = $cMargin;
        $this->aCols = array();
    }
}
