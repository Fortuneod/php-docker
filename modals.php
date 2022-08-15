<?php

    session_start();

    require 'DbHandler/dbconn.php';
    require 'DbHandler/dataClass.php';

    $csrf = bin2hex(random_bytes(24));    

    $_SESSION['csrf_session'] = $csrf;
    
    $rty=$conn->cleanUp('type');
    $val=$conn->cleanUp('val');

    if($rty=="add")
    {
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop" style="padding:20px;background:#fff">

            <form id="exForm" onSubmit="return false" class="form-group">
                <input type="hidden" name="csrf_token" value="<?php //echo $csrf; ?>">   
                <input type="hidden" name="type" value="add_expense">  
                
                <div class="col-half">
                    <h2 class="form-head">Add Expense</h2>
                    
                    <div class="form-group">
                        <label class="form-label">Employee</label>
                        <select class="form-control" name="add_merchant" id="add_merchant" onBlur="valCheck(this)">
                            <option value=""></option>
                            <?php $Data->allEmployees(); ?>
                        </select>
                    </div>
                
                   <div class="form-group">
                        <label class="form-label">Total</label>
                        <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="number" class="form-control" name="add_amount" id="add_amount" onBlur="valCheck(this)" />
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input type="text" class="form-control typo" name="add_date" id="add_date" placeholder="&#128467" onFocus="changeType(this)" onBlur="checkType(this);valCheck(this)" />
                    </div>
                
                   <div class="form-group">
                        <label class="form-label">Comment</label>
                        <textarea class="form-control" rows="4" name="add_comments" id="add_comments" style="resize:none"></textarea>
                    </div>
                
                    <div class="col-md-12">
                        <button type="submit" onClick="Process(1)" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> &nbsp;&nbsp;                             
                        <button type="submit" onClick="closePop()" class="btn btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
                    </div>
                </div>
                
                <div class="col-half">
                    <div class="bod">
                        <input type="file" name="img_upload" id="img_upload" onChange="imgShow(this)" accept="image/*" style="display:none" />
                        <input type="text" name="img_file" id="img_file" style="display:none" />
                        <button class="btn btn-cancel" onClick="fileSelect()">Select Receipt</button>
                        <img src="" id="eximg" />
                    </div>
                    
                    <button class="btn btn-delete" onClick="showPop('upload', '0')">Upload Excel</button>
                </div>
            </form>
            <p id="upResp" style="text-align:center"></p>
        </div>
<?php
    }

    if($rty=="upload")
    {
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop-small" style="padding:20px;background:#fff">

            <form id="exForm" onSubmit="return false" class="form-group">
                <input type="hidden" name="csrf_token" value="<?php //echo $csrf; ?>">   
                <input type="hidden" name="type" value="upload_expense">  
                
                <div class="col-full">
                    <h2 class="form-head">Upload Expense <span style="float:right"><button class="btn btn-myn" onClick="window.open('Expense.xlsx', '_blank')">&dArr; Template</button></span></h2>
                    <br>
                    <input type="file" name="img_upload" id="img_upload" onChange="fileName(this)" accept=".xlsx" style="display:none" />
                        <button class="btn btn-cancel" onClick="fileSelect()">Select File</button> 
                        <input type="text" name="img_file" id="img_file" style="border:none;font-size:20px;font-weight:550" readonly />
                    <div class="col-md-12">
                        <br><br>
                        <button type="submit" onClick="Process(7)" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> &nbsp;&nbsp;                             
                        <button type="submit" onClick="closePop()" class="btn btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
                        <button type="submit" onClick="showPop('add', '0')" class="btn btn-delete"><i class="fa fa-times-circle"></i> Upload Single</button>
                    </div>
                </div>
                
                
            </form>
            <p id="upResp" style="text-align:center"></p>
        </div>
<?php
    }

    if($rty=="view")
    {
        $data = $Data->expenseData($val);
        
        $pht = (!is_null($data['receipt']) && !empty($data['receipt'])) ? "receipts/".$data['receipt'] : "";
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop" style="padding:20px;background:#fff">

            <form id="exForm" onSubmit="return false" class="form-group">
                <input type="hidden" name="csrf_token" value="<?php //echo $csrf; ?>">   
                <input type="hidden" name="type" value="edit_expense">  
                <input type="hidden" name="row_num" value="<?php echo $val; ?>">  
                
                <div class="col-half">
                    <h2 class="form-head">Edit Expense</h2>
                    
                    <div class="form-group">
                        <label class="form-label">Employee</label>
                        <select class="form-control" name="edit_merchant" id="edit_merchant" onBlur="valCheck(this)">
                            <?php $Data->editEmployee($data['merchant']); ?>
                        </select>
                    </div>
                
                   <div class="form-group">
                        <label class="form-label">Total</label>
                        <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="number" class="form-control" name="edit_amount" id="edit_amount" value="<?php echo $data['amount']; ?>" onBlur="valCheck(this)" />
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control typo" name="edit_date" id="edit_date" value="<?php echo $data['expense_date']; ?>" placeholder="&#128467" onFocus="changeType(this)" onBlur="checkType(this);valCheck(this)" />
                    </div>
                
                   <div class="form-group">
                        <label class="form-label">Comment</label>
                        <textarea class="form-control" name="edit_comments" id="edit_comments" rows="4" style="resize:none"><?php echo $data['comments']; ?></textarea>
                    </div>
                
                    <div class="col-md-12">
                        <button type="submit" onClick="Process(2)" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> &nbsp;&nbsp;                             
                        <button type="submit" onClick="closePop()" class="btn btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
                    </div>
                </div>
                
                <div class="col-half">
                    <div class="bod">
                        <input type="file" name="img_upload" id="img_upload" onChange="imgShow(this)" accept="image/*" style="display:none" />
                        <input type="text" name="img_file" id="img_file" style="display:none" />
                        <button class="btn btn-cancel" onClick="fileSelect()">Select Receipt</button>
                        <img src="<?php echo $pht; ?>" id="eximg" />
                    </div>
                    
                    <!--<button class="btn btn-delete" onClick="closePop()">Delete</button>-->
                </div>
            </form>
            <p id="upResp" style="text-align:center"></p>
        </div>
<?php
    }

    if($rty=="info")
    {
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop-small" style="padding:20px;background:#fff">
            
            <h2 class="form-head">Welcome To Expense Manager</h2>
            <br>
            <p>This is a Simple Progressive Web App.</p>
            <br>
            <p>Try adding it to your home screen and using it offline.</p>
            <br>
            <p>This demo is built using <strong>HTML5, Pure CSS, JavaScript, JQuery</strong> and <strong>PHP</strong></p>
            
            <br>
            <button class="btn btn-primary" onClick="closePop()">Got it</button>
            
        </div>
<?php
    }
    

    if($rty=="addEmp")
    {
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop" style="padding:20px;background:#fff">

            <form id="exForm" onSubmit="return false" class="form-group">
                <input type="hidden" name="csrf_token" value="<?php //echo $csrf; ?>">   
                <input type="hidden" name="type" value="add_emp">  
                
                <div class="col-two-third">
                    <h2 class="form-head">Add Employee</h2>                   
                    
                
                   <div class="form-group">
                        <label class="form-label">Employee Name</label>
                        <input type="text" class="form-control" name="emp_name" id="emp_name" onBlur="valCheck(this)" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Job</label>
                        <select class="form-control" name="emp_job" id="emp_job" onBlur="valCheck(this)">
                            <option value=""></option>
                            <?php $Data->allJobs(); ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <select class="form-control" name="emp_loc" id="emp_loc" onBlur="valCheck(this)">
                            <option value=""></option>
                            <?php $Data->allLocs(); ?>
                        </select>
                    </div>
                
                    
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="emp_dept" id="emp_dept" onBlur="valCheck(this)">
                            <option value=""></option>
                            <?php $Data->allDepts(); ?>
                        </select>
                    </div>
                
                    <div class="col-md-12">
                        <button type="submit" onClick="Process(3)" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> &nbsp;&nbsp;                             
                        <button type="submit" onClick="closePop()" class="btn btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
                    </div>
                </div>
                
                <div class="col-one-third">
                    <div class="bod">
                        <input type="file" name="img_upload" id="img_upload" onChange="imgShow(this)" style="display:none" />
                        <input type="text" name="img_file" id="img_file" style="display:none" />
                        <button class="btn btn-cancel" onClick="fileSelect()">Select Photo</button>
                        <img align="center" src="" id="eximg" />
                    </div>
                    
                    <!--<button class="btn btn-delete" onClick="closePop()">Delete</button>-->
                </div>
            </form>
            <p id="upResp" style="text-align:center"></p>
        </div>
<?php
    }


    if($rty=="viewEmp")
    {
        $data = $Data->employeeData($val);
        
        $pht = (!is_null($data['emp_photo']) && !empty($data['emp_photo'])) ? "photos/".$data['emp_photo'] : "";
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop" style="padding:20px;background:#fff">

            <form id="exForm" onSubmit="return false" class="form-group">
                <input type="hidden" name="csrf_token" value="<?php //echo $csrf; ?>">   
                <input type="hidden" name="type" value="add_emp">  
                
                <div class="col-two-third">
                    <h2 class="form-head">Employee Info</h2>                   
                    
                
                   <div class="form-group">
                        <label class="form-label">Employee Name</label>
                        <input type="text" class="form-control" name="emp_name" id="emp_name" value="<?php echo $data['emp_name']; ?>" onBlur="valCheck(this)" />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Job</label>
                        <select class="form-control" name="emp_job" id="emp_job" onBlur="valCheck(this)">
                            <option value=""></option>
                            <?php $Data->empView('job', $data['emp_job']); ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <select class="form-control" name="emp_loc" id="emp_job" onBlur="valCheck(this)">
                            <option value=""></option>
                            <?php $Data->empView('loc', $data['emp_loc']); ?>
                        </select>
                    </div>
                
                    
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="emp_dept" id="emp_dept" onBlur="valCheck(this)">
                            <option value=""></option>
                            <?php $Data->empView('dept', $data['emp_dept']); ?>
                        </select>
                    </div>
                
                   <!-- <div class="col-md-12">
                        <button type="submit" onClick="Process()" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> &nbsp;&nbsp;                             
                        <button type="submit" onClick="closePop()" class="btn btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
                    </div>-->
                </div>
                
                <div class="col-one-third">
                    <div class="bod">
                        <br>
                        <!--<input type="file" name="img_upload" id="img_upload" onChange="imgShow(this)" style="display:none" />
                        <input type="text" name="img_file" id="img_file" style="display:none" />
                        <button class="btn btn-cancel" onClick="fileSelect()">Select Photo</button>-->
                        <img align="center" src="<?php echo $pht; ?>" id="eximg" />
                    </div>
                    
                    <!--<button class="btn btn-delete" onClick="closePop()">Delete</button>-->
                </div>
            </form>
            <p id="upResp" style="text-align:center"></p>
        </div>
<?php
    }


    if($rty=="addDept")
    {
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop-small" style="padding:20px;background:#fff">

            <form id="exForm" onSubmit="return false" class="">
                <input type="hidden" name="csrf_token" value="<?php //echo $csrf; ?>">   
                <input type="hidden" name="type" value="add_dept">  
                
                <div class="col-full">
                    <h2 class="form-head">Add Department</h2>
                    <br>
                    <div class="form-group">
                        <label class="form-label">Department Name</label>
                        <input type="text" class="form-control" name="dept_name" id="dept_name" onBlur="valCheck(this)" />
                    </div>
                
                    <div class="col-md-12">
                        <button type="submit" onClick="Process(4)" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> &nbsp;&nbsp;                             
                        <button type="submit" onClick="closePop()" class="btn btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
                    </div>
                </div>
            </form>
            <p id="upResp" style="text-align:center"></p>
        </div>
<?php
    }


    if($rty=="addLoc")
    {
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop-small" style="padding:20px;background:#fff">

            <form id="exForm" onSubmit="return false" class="form-group">
                <input type="hidden" name="csrf_token" value="<?php //echo $csrf; ?>">   
                <input type="hidden" name="type" value="add_loc">  
                
                <div class="col-full">
                    <h2 class="form-head">Add Location</h2>
                    <br>
                    <div class="form-group">
                        <label class="form-label">Location Name</label>
                        <input type="text" class="form-control" name="loc_name" id="loc_name" onBlur="valCheck(this)" />
                    </div>
                
                    <div class="col-md-12">
                        <br>
                        <button type="submit" onClick="Process(5)" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> &nbsp;&nbsp;                             
                        <button type="submit" onClick="closePop()" class="btn btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
                    </div>
                </div>
            </form>
            <p id="upResp" style="text-align:center"></p>
        </div>
<?php
    }


    if($rty=="addJob")
    {
?>
        <div id="popup-in" onClick="closePop()"></div>
        <div class="pop-small" style="padding:20px;background:#fff">

            <form id="exForm" onSubmit="return false" class="form-group">
                <input type="hidden" name="csrf_token" value="<?php //echo $csrf; ?>">   
                <input type="hidden" name="type" value="add_job">  
                
                <div class="col-full">
                    <h2 class="form-head">Add Job</h2>
                    <br>
                    <div class="form-group">
                        <label class="form-label">Job Title</label>
                        <input type="text" class="form-control" name="job_name" id="job_name" onBlur="valCheck(this)" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Job Description</label>
                        <textarea class="form-control" rows="5" style="resize:none" name="job_desc" id="job_desc" onBlur="valCheck(this)"></textarea>
                    </div>
                
                    <div class="col-md-12">
                        <br>
                        <button type="submit" onClick="Process(6)" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button> &nbsp;&nbsp;                             
                        <button type="submit" onClick="closePop()" class="btn btn-cancel"><i class="fa fa-times-circle"></i> Cancel</button>
                    </div>
                </div>
            </form>
            <p id="upResp" style="text-align:center"></p>
        </div>
<?php
    }

?>