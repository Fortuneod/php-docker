<?php
    session_start();
    
    if(isset($_SESSION['exp_manager']))
    {
        require 'DbHandler/dbconn.php';
        require 'DbHandler/dataClass.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="imgs/icon.png" />
    <title>Expense Manager</title>
        
    <link href="css/stylesheet.css?v=8" rel="stylesheet" />
    
</head>

<body>
    <div id="popup">
        
    </div>
    
    <nav class="navbar navbar-expand-md fixed-top" style="">
        <h4 style="width:100%;color:#fff;padding-top:10px">
            <span style="">Expense Manager</span>

            <span style="float:right">
                <button class="btn btn-sm btn-myn btn-top" style="color:#fff" value="expense_page" onClick="pageShow(this)">EXPENSES</button>
                <button class="btn btn-sm btn-myn btn-top" value="emp_page" onClick="pageShow(this)">EMPLOYEES</button>
                <button class="btn btn-sm btn-myn btn-top" value="dept_page" onClick="pageShow(this)">DEPARTMENTS</button>
                <button class="btn btn-sm btn-myn btn-top" value="job_page" onClick="pageShow(this)">JOBS</button>
                <button class="btn btn-sm btn-myn btn-top" value="loc_page" onClick="pageShow(this)">LOCATIONS</button>
                <button class="btn btn-sm btn-myn" onClick="showPop('info', '0')">INFO</button>
                <button class="btn btn-sm btn-myn" onClick="location.href='logout/'">LOGOUT</button>
            </span>

        </h4>    
    </nav>

    <main role="main" class="">
        <div class="row views" id="expense_page" style="">
            <div class="col-small-left" style="">
                <p class="text-small">Filter Expenses <span class="text-right" onClick="clearFilter()">Clear Filters</span></p>
                <hr class="clear-line" />
                
                <form id="filterForm" onSubmit="return false">
                    <input type="hidden" name="type" value="filter_list" />
                    <div class="form-group">
                        <label class="form-label">From</label>
                        <input type="text" class="form-control typo" name="from_date" id="from_date" placeholder="&#128467" onFocus="changeType(this)" onBlur="checkType(this)" onChange="dateLock()" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">To</label>
                        <input type="number" class="form-control typo" name="to_date" id="to_date" placeholder="&#128467" onFocus="changeType(this)" onBlur="checkType(this)" onChange="filterList()" />
                    </div>
                    
                    <div class="col-inner-form">
                        <label class="form-label">Min</label>
                        <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="number" class="form-control" placeholder="Text" name="min_value" id="min_value" onKeyup="filterList()" />
                        </div>
                    </div>

                    <div class="col-inner-divide">
                        -
                    </div>

                    <div class="col-inner-form">
                        <label class="form-label">Max</label>
                        <input type="number" class="form-control" name="max_value" id="max_value" onKeyup="filterList()" />
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="form-label">Employee</label>
                        <select class="form-control" name="f_merchant" id="f_merchant" onChange="filterList()">
                            <option value=""></option>
                            <?php $Data->allEmployees(); ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" style="margin-bottom:10px">Status</label>
                        <div class="col-inner-form">
                            <input type="checkbox" checked title="remove-filter" onClick="stsList(this)" value="New" /> New 
                        </div>
                        <div class="col-inner-form">
                            <input type="checkbox" checked title="remove-filter" onClick="stsList(this)" value="In Progress" /> In Progress
                        </div>
                        <div class="col-inner-form">
                            <input type="checkbox" checked title="remove-filter" onClick="stsList(this)" value="Reimbursed" /> Reimbursed
                        </div>
                        
                        <input type="hidden" class="form-control" name="status_filter" id="status_filter" onChange="Filter()" value="New, In Progress, Reimbursed" />
                    </div>
                    
                </form>
                
             </div>
             
            <div class="col-big table-responsive" style="">
                <table class="table table-none table-ex">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php $Data->expenseList(); ?>                        
                    </tbody>
                </table>             
            </div>
                
            <div class="col-small-right" id="reim" style="">
                <p class="text-small">To be reimbursed</p>
                <hr class="clear-line" /> 
                
                <h1 class="reim">$<?php $Data->reImburse(); ?></h1>
                
            </div>
            
            <button class="add-btn" onClick="showPop('add', '0')">+</button>
        </div>
        
        <div class="row views" id="emp_page" style="display:none">
            <div class="col-smaller-left" style=""></div>
             
            <div class="col-bigger table-responsive" style="">
                <table class="table table-none">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Job</th>
                            <th>Location</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody id="tbody2">
                        <?php $Data->empList(); ?>                        
                    </tbody>
                </table>             
            </div>
                
            <div class="col-smaller-right" style=""></div>
            
            <button class="add-btn-2" onClick="showPop('addEmp', '0')">+</button>
        </div>
        
        <div class="row views" id="dept_page" style="display:none">
            <div class="col-smaller-left" style=""></div>
             
            <div class="col-bigger table-responsive" style="">
                <table class="table table-sn">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody id="tbody3">
                        <?php $Data->deptList(); ?>                        
                    </tbody>
                </table>             
            </div>
                
            <div class="col-smaller-right" style=""></div>
            
            <button class="add-btn-2" onClick="showPop('addDept', '0')">+</button>
        </div>
        
        <div class="row views" id="job_page" style="display:none">
            <div class="col-smaller-left" style=""></div>
             
            <div class="col-bigger table-responsive" style="">
                <table class="table table-sn">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Job</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody id="tbody4">
                        <?php $Data->jobList(); ?>                        
                    </tbody>
                </table>             
            </div>
                
            <div class="col-smaller-right" style=""></div>
            
            <button class="add-btn-2" onClick="showPop('addJob', '0')">+</button>
        </div>
        
        <div class="row views" id="loc_page" style="display:none">
            <div class="col-smaller-left" style=""></div>
             
            <div class="col-bigger table-responsive" style="">
                <table class="table table-sn">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody id="tbody5">
                        <?php $Data->locList(); ?>                        
                    </tbody>
                </table>             
            </div>
                
            <div class="col-smaller-right" style=""></div>
            
            <button class="add-btn-2" onClick="showPop('addLoc', '0')">+</button>
        </div>
    </main>
    
    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/datatables.min.js?v=2"></script>
    <script src="js/main.js"></script>

</body>
</html>
<?php
    }
    else
    {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="imgs/icon.png" />
    <title>Expense Manager</title>
        
    <link href="css/stylesheet.css?v=3" rel="stylesheet" />
    
</head>

<body>
    <div class="login-area">
        <h2 class="title">Expense Manager</h2>
        <div class="line"></div>
        <div class="col-login">
            <br>
            <form id="lgForm" onSubmit="return false">
                <input type="hidden" name="type" value="login" />
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="login_usn" value="demo" id="login_usn" />
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control control" value="demo" name="login_pwd" id="login_pwd" />
                        <div class="input-group-addon-r add-r" id="open" onClick="pShow(this)">&#128065;</div>
                </div>
                <div class="form-group">
                    <br>
                    <button class="btn btn-primary" onClick="Login()" style="color:#fff;opacity:1">Login</button>    
                </div>
            </form>
        </div>
    </div>
    <div class="foot">
        <p class="pull-left">Simple Web App</p>
        <p class="pull-right">Created By Fortune Odesanya</p>
    </div>
        
    <script>
        function _(x)    
        {
            return document.getElementById(x);
        }
        
        function qs(x)
        {
            return document.querySelector(x);
        }
        
        function pShow(x)
        {
            if(x.id=="open")
            {
                x.style.textDecoration = "line-through";
                qs('#login_pwd').type = "text";
                x.id = "close";
            }
            else if(x.id=="close")
            {
                x.style.textDecoration = "none";
                qs('#login_pwd').type = "password";
                x.id = "open";
            }
        }
        
        function Login()
        {
            let fd = new FormData(lgForm);
            let req = new XMLHttpRequest();
            
            req.open("POST", "DbHandler/", true);
            req.onreadystatechange = () => {
                if(req.readyState !== 4 || req.status !== 200) return;
                
                setTimeout(() => {
                    location.reload(true);
                }, 1000);
            }
            req.send(fd);
        }
    </script>
</body>
</html>

<?php
    }

?>