<?php
    session_start();

    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

    require 'dbconn.php';
    require 'dataClass.php';
    require_once 'vendor/autoload.php';

    $rty = $conn->cleanUp('type');


    if($rty=="login")
    {
        $usn = "Exp_Manager";
        
        $_SESSION['exp_manager'] = $usn;
    }

    if($rty=="add_expense")
    {
        $m = $conn->cleanUp('add_merchant');
        $t = $conn->cleanUp('add_amount');
        $d = $conn->cleanUp('add_date');
        $c = $conn->cleanUp('add_comments');
        
        $t = preg_replace("/[^0-9.]/", "", $t);
        $d = date('Y-m-d', strtotime($d));
        
        if($conn->isFile('img_upload'))
        {
            $path="../receipts/";
            
            $tmp = $conn->getFile('img_upload');
            $fnm = substr(md5(rand()), 0, 10)."_".$conn->nameFile('img_upload');
            
            $s="INSERT INTO `expenses`(`merchant`, `expense_date`, `amount`, `comments`, `receipt`, `status`) VALUES('$m', '$d', '$t', '$c', '$fnm', 'New')";
            $r=$conn->Execute($s);
            
            if($r)
            {
                move_uploaded_file($tmp, $path.$fnm);
            }
        }
        else
        {            
            $s="INSERT INTO `expenses`(`merchant`, `expense_date`, `amount`, `comments`, `receipt`, `status`) VALUES('$m', '$d', '$t', '$c', '', 'New')";
            $r=$conn->Execute($s);
        }
    }

    if($rty=="upload_expense")
    {
        $tmp = $conn->getFile('img_upload');
        $fnm = $conn->nameFile('img_upload');
        
        $targetPath = 'uploads/' . $fnm;
        move_uploaded_file($tmp, $targetPath);
        
        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $sheetCount = count($spreadSheetAry);

        for ($i = 0; $i <= $sheetCount; $i ++) {
            $sn = "";
            $emp = "";
            $exd = "";
            $amt = "";
            $cmt = "";
            
            if (isset($spreadSheetAry[$i][0])) {
                $sn = $conn->cleanVar($spreadSheetAry[$i][0]);
            }
            
            if (isset($spreadSheetAry[$i][1])) {
                $emp = $conn->cleanVar($spreadSheetAry[$i][1]);
            }
            
            if (isset($spreadSheetAry[$i][2])) {
                $exd = $conn->cleanVar($spreadSheetAry[$i][2]);
            }
            
            if (isset($spreadSheetAry[$i][3])) {
                $amt = $conn->cleanVar($spreadSheetAry[$i][3]);
            }
            
            if (isset($spreadSheetAry[$i][4])) {
                $cmt = $conn->cleanVar($spreadSheetAry[$i][4]);
            }

            if (!empty($sn) && is_numeric($sn) && !empty($emp) && !empty($exd) && !empty($amt)) 
            {
                $exd = date('Y-m-d', strtotime($exd));
                $amt = preg_replace("/[^0-9.]/", "", $amt);
                    
                $s="INSERT INTO `expenses`(`merchant`, `expense_date`, `amount`, `comments`, `receipt`, `status`) VALUES('$emp', '$exd', '$amt', '$cmt', '', 'New')";
                $r=$conn->Execute($s);
            }
        }
        
        unlink($targetPath);
    }

    if($rty=="edit_expense")
    {
        $rn = $conn->cleanUp('row_num');
        $m = $conn->cleanUp('edit_merchant');
        $t = $conn->cleanUp('edit_amount');
        $d = $conn->cleanUp('edit_date');
        $c = $conn->cleanUp('edit_comments');
        
        $t = preg_replace("/[^0-9.]/", "", $t);
        $d = date('Y-m-d', strtotime($d));
        
        if($conn->isFile('img_upload'))
        {
            $path="../receipts/";
            
            $tmp = $conn->getFile('img_upload');
            $fnm = substr(md5(rand()), 0, 10)."_".$conn->nameFile('img_upload');
            
            $s="UPDATE `expenses` SET `merchant`='$m', `expense_date`='$d', `amount`='$t', `comments`='$c', `receipt`='$fnm' WHERE id=$rn";
            $r=$conn->Execute($s);
            
            if($r)
            {
                move_uploaded_file($tmp, $path.$fnm);
            }
        }
        else
        {            
            $s="UPDATE `expenses` SET `merchant`='$m', `expense_date`='$d', `amount`='$t', `comments`='$c' WHERE id=$rn";
            $r=$conn->Execute($s);
        }        
    }

    if($rty=="filter_list")
    {
        $fd = $conn->cleanUp('from_date');
        $td = $conn->cleanUp('to_date');
        $mn = $conn->cleanUp('min_value');
        $mx = $conn->cleanUp('max_value');
        $mc = $conn->cleanUp('f_merchant');
        $st = $conn->cleanUp('status_filter');
        
        $Data->filterList($fd, $td, $mn, $mx, $mc, $st);       
    }

    if($rty=="delete_expense")
    {
        
    }

    if($rty=="add_emp")
    {
        $n = $conn->cleanUp('emp_name');
        $j = $conn->cleanUp('emp_job');
        $l = $conn->cleanUp('emp_loc');
        $d = $conn->cleanUp('emp_dept');
        
        $path="../photos/";

        $tmp = $conn->getFile('img_upload');
        $fnm = substr(md5(rand()), 0, 10)."_".$conn->nameFile('img_upload');

        $s="INSERT INTO `employees`(`emp_name`, `emp_job`, `emp_loc`, `emp_dept`, `emp_photo`) VALUES('$n', '$j', '$l', '$d', '$fnm')";
        $r=$conn->Execute($s);

        if($r)
        {
            move_uploaded_file($tmp, $path.$fnm);
        }
        
    }

    if($rty=="add_dept")
    {
        $d = $conn->cleanUp('dept_name');
        
        $s="INSERT INTO `depts`(`dept_name`) VALUES('$d')";
        $r=$conn->Execute($s);        
    }

    if($rty=="add_loc")
    {
        $d = $conn->cleanUp('loc_name');
        
        $s="INSERT INTO `locs`(`loc_name`) VALUES('$d')";
        $r=$conn->Execute($s);        
    }  

    if($rty=="add_job")
    {
        $j = $conn->cleanUp('job_name');
        $d = $conn->cleanUp('job_desc');
        
        $s="INSERT INTO `jobs`(`job_name`, `job_desc`) VALUES('$j', '$d')";
        $r=$conn->Execute($s);        
    }
    

?>