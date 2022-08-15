<?php

    class DataClass
	{       
        //DASHBOARD
        function reImburse()
        {
            global $conn;
            
            $s="SELECT SUM(amount) AS total FROM `expenses` WHERE status='New'";
            $r=$conn->Execute($s);
            $v=$conn->Display($r);
            
            echo (!is_null($v->total)) ? number_format($v->total, 2) : 0;
                
        }
        
        function allMerchants()
        {
            global $conn;
            
            $s="SELECT * FROM `merchants`";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $m=$v->merchant;
                echo "<option>$m</option>";
            }
        }
        
        function allJobs()
        {
            global $conn;
            
            $s="SELECT * FROM `jobs` ORDER BY job_name";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $m=$v->job_name;
                echo "<option>$m</option>";
            }
        }
        
        function allDepts()
        {
            global $conn;
            
            $s="SELECT * FROM `depts` ORDER BY dept_name";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $m=$v->dept_name;
                echo "<option>$m</option>";
            }
        }
        
        function allLocs()
        {
            global $conn;
            
            $s="SELECT * FROM `locs`";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $m=$v->loc_name;
                echo "<option>$m</option>";
            }
        }
        
        function allEmployees()
        {
            global $conn;
            
            $s="SELECT * FROM `employees` ORDER BY emp_name";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $m=$v->emp_name;
                echo "<option>$m</option>";
            }
        }
        
        function editEmployee($x)
        {
            global $conn;
            
            $s="SELECT * FROM `employees` ORDER BY emp_name";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $m=$v->emp_name;
                
                echo ($x==$m) ? "<option selected>$m</option>" : "<option>$m</option>";                    
            }
        }
        
        function empView($x, $y)
        {
            global $conn;
            
            $t = $x."s";
            $c = $x."_name";
            
            $s="SELECT * FROM `$t` ORDER BY $c";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $m=$v->$c;
                
                echo ($y==$m) ? "<option selected>$m</option>" : "<option>$m</option>";                    
            }
        }
        
        function expenseData($x)
        {
            global $conn;
            
            $s="SELECT * FROM `expenses` WHERE id=$x";
            $r=$conn->Execute($s);
            $v=$conn->DisplayAssoc($r);
            
            return $v;
        }
        
        function employeeData($x)
        {
            global $conn;
            
            $s="SELECT * FROM `employees` WHERE id=$x";
            $r=$conn->Execute($s);
            $v=$conn->DisplayAssoc($r);
            
            return $v;
        }
        
        function expenseList()
        {
            global $conn;
            
            $s="SELECT * FROM `expenses` ORDER BY date(expense_date) DESC";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $style;
                
                if($v->status=="New")
                {
                    $style="style='font-weight:550;color:#f00'";
                }
                elseif($v->status=="In Progress")
                {
                    $style="style='font-weight:550;font-style:italic'";
                }
                else
                {
                    $style="";
                }
            ?>
                <tr onClick="showPop('view', '<?php echo $v->id; ?>')">
                    <td width="15%"><?php echo date('m/d/Y', strtotime($v->expense_date)); ?></td>
                    <td width="15%"><?php echo $v->merchant; ?></td>
                    <td width="15%">$ <?php echo number_format($v->amount, 2); ?></td>
                    <td  width="15%" <?php echo $style; ?>><?php echo $v->status; ?></td>
                    <td  width="40%"><?php echo $v->comments; ?></td>
                </tr>
            <?php
            }
        }
        
        function empList()
        {
            global $conn;
            
            $s="SELECT * FROM `employees` ORDER BY emp_name";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
            ?>
                <tr onClick="showPop('viewEmp', '<?php echo $v->id; ?>')">
                    <td width="40%"><?php echo $v->emp_name; ?></td>
                    <td width="20%"><?php echo $v->emp_job; ?></td>
                    <td width="20%"><?php echo $v->emp_loc; ?></td>
                    <td  width="20%"><?php echo $v->emp_dept; ?></td>
                </tr>
            <?php
            }
        }
        
        function jobList()
        {
            global $conn;
            
            $sn=1;
            
            $s="SELECT * FROM `jobs` ORDER BY job_name";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
            ?>
                <tr>
                    <td width="10%"><?php echo $sn; ?></td>
                    <td width="20%"><?php echo $v->job_name; ?></td>
                    <td width="70%"><?php echo $v->job_desc; ?></td>
                </tr>
            <?php
                $sn++;
            }
        }
        
        function locList()
        {
            global $conn;
            
            $sn=1;
            
            $s="SELECT * FROM `locs` ORDER BY loc_name";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
            ?>
                <tr>
                    <td width="10%"><?php echo $sn; ?></td>
                    <td width="90%"><?php echo $v->loc_name; ?></td>
                </tr>
            <?php
                $sn++;
            }
        }
        
        function deptList()
        {
            global $conn;
            
            $sn=1;
            
            $s="SELECT * FROM `depts` ORDER BY dept_name";
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
            ?>
                <tr>
                    <td width="10%"><?php echo $sn; ?></td>
                    <td width="90%"><?php echo $v->dept_name; ?></td>
                </tr>
            <?php
                $sn++;
            }
        }
        
        
        function filterList($fd, $td, $mn, $mx, $mc, $st)
        {
            global $conn;
            
            $s="SELECT * FROM `expenses` WHERE ";
        
            if(!empty($fd) && !empty($td))
            {
                $s .="date(expense_date) BETWEEN '$fd' AND '$td' AND ";
            }
            elseif(empty($fd) && !empty($td))
            {
                $s .="date(expense_date) <= '$td' AND ";
            }
            elseif(!empty($fd) && empty($td))
            {
                $s .="date(expense_date) >= '$fd' AND ";
            }


            if(!empty($mn) && !empty($mx))
            {
                $s .="amount BETWEEN '$mn' AND '$mx' AND ";
            }
            elseif(empty($mn) && !empty($mx))
            {
                $s .="amount <= '$mx' AND ";
            }
            elseif(!empty($mn) && empty($mx))
            {
                $s .="amount >= '$mn' AND ";
            }
            
            
            if(!empty($mc))
            {
                $s .= "merchant='$mc' AND ";
            }


            if(!empty($st))
            {
                $sar = explode(", ", $st);

                $sts="";

                foreach($sar as $ist)
                {
                    if(empty($sts))
                    {
                        $sts .= "'$ist'";
                    }
                    else
                    {
                        $sts .= ", '$ist'";
                    }
                }

                $s .="status IN ($sts)";
            }
            else
            {
                $s .="status IN ('')";
            }
            
            $r=$conn->Execute($s);
            while($v=$conn->Display($r))
            {
                $style;
                
                if($v->status=="New")
                {
                    $style="style='font-weight:550;color:#f00'";
                }
                elseif($v->status=="In Progress")
                {
                    $style="style='font-weight:550;font-style:italic'";
                }
                else
                {
                    $style="";
                }
            ?>
                <tr onClick="showPop('view', '<?php echo $v->id; ?>')">
                    <td width="15%"><?php echo date('m/d/Y', strtotime($v->expense_date)); ?></td>
                    <td width="15%"><?php echo $v->merchant; ?></td>
                    <td width="15%">$ <?php echo number_format($v->amount, 2); ?></td>
                    <td  width="15%" <?php echo $style; ?>><?php echo $v->status; ?></td>
                    <td  width="40%"><?php echo $v->comments; ?></td>
                </tr>
            <?php
            }
            
            
            //echo $s;
        }
        
    }


    $Data = new DataClass();

?>