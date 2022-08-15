function _(x) {
    return document.getElementById(x);
}

function qs(x) {
    return document.querySelector(x);
}

function chkVal(x) {
    return qs(x).value != "";
}

function getVal(x) {
    return qs(x).value;
}

function pageShow(x) {
    let ff = "#" + x.value;

    $('.btn-top').css('color', '#069bff');
    x.style.color = "#fff";
    $('.views').hide();
    $(ff).show();
}

$(document).ready(() => {

    $('.table-none').DataTable({
        dom: '',
        ordering: true,
        order: [[0, 'desc']],
        paging: false
    });

    $('.table-sn').DataTable({
        dom: '',
        ordering: true,
        order: [[0, 'asc']],
        paging: false
    });
});


function clearFilter() {
    $('#filterForm').load(location.href + " #filterForm>*", "");
    $('#tbody').load(location.href + " #tbody>*", "");
}

function showPop(x, y) {
    $.ajax({
        url: "modals.php",
        data: {
            type: x,
            val: y
        },
        type: "POST",
        success: function (out) {
            $('#popup').html(out);
            $('#popup').show();
        }
    });
}

function closePop() {
    $('#popup').hide();
    $('#popup').html('');
}

function Process(x) {
    let opr, tbd;
    let out = 0;

    x = parseInt(x);

    if (x == 1) {
        opr = ["add_merchant", "add_amount", "add_date"];
        tbd = "#tbody";
    } else if (x == 2) {
        opr = ["edit_merchant", "edit_amount", "edit_date"];
        tbd = "#tbody";
    } else if (x == 3) {
        opr = ["emp_name", "emp_job", "emp_loc", "emp_dept", "img_file"];
        tbd = "#tbody2";
    } else if (x == 4) {
        opr = ["dept_name"];
        tbd = "#tbody3";
    } else if (x == 5) {
        opr = ["loc_name"];
        tbd = "#tbody5";
    } else if (x == 6) {
        opr = ["job_name"];
        tbd = "#tbody4";
    } else if (x == 7) {
        opr = ["img_file"];
        tbd = "#tbody";
    }

    opr.forEach((item) => {
        let id = "#" + item;
        if (!chkVal(id)) {
            out += 1;
        }
    });

    let fd = new FormData(exForm);
    let req = new XMLHttpRequest();


    if (out <= 0) {
        req.open("POST", "DbHandler/", true);
        req.onreadystatechange = () => {
            if (req.readyState !== 4 || req.status !== 200) return;

            closePop();
            $(tbd).load(location.href + " " + tbd + ">*", "");
            $("#reim").load(location.href + " #reim>*", "");
        }
        req.send(fd);
        //$('#ihistory').load(location.href + " #ihistory>*", "");
    }
}

function imgShow(x) {
    let reader = new FileReader();
    qs('#img_file').value = x.value.split('\\')[2];
    reader.onload = (e) => {
        qs('#eximg').src = e.target.result;
    };

    reader.readAsDataURL(x.files[0]);
}

function fileName(x) {
    qs('#img_file').value = x.value.split('\\')[2];
}

function fileSelect() {
    qs('#img_upload').click();
}

function changeType(x) {
    x.type = "date";
}

function checkType(x) {
    if (x.value == "") {
        x.type = "text";
    }
}

function valCheck(x) {
    if (x.value == "") {
        x.style.backgroundColor = "rgba(200,0,0,0.1)";
    } else {
        x.style.backgroundColor = "rgba(120, 150, 150, 0.15)";
    }
}

function filterList() {
    let fd = new FormData(filterForm);
    let req = new XMLHttpRequest();

    req.open("POST", "DbHandler/", true);
    req.onreadystatechange = () => {
        if (req.readyState !== 4 || req.status !== 200) return;

        $('.table-ex').DataTable().clear().destroy();

        qs('#tbody').innerHTML = req.responseText;

        $('.table-ex').DataTable({
            dom: '',
            ordering: true,
            order: [[0, 'desc']],
            paging: false
        });
    }
    req.send(fd);
}


function dateLock() {
    let pd = qs('#from_date').value;
    $('#to_date').attr('min', pd);

    filterList();
}


function stsList(x) {
    var t = x.value;
    var o = x.title;
    var tx = qs('#status_filter').value;
    var nt;

    if (o == "add-filter") {
        if (tx == "") {
            qs('#status_filter').value = t;
        } else {
            qs('#status_filter').value = tx + ", " + t;
        }

        nt = "remove-filter";
    } else if (o == "remove-filter") {
        var sa = tx.split(', ');

        var r = sa.indexOf(t);

        sa.splice(r, 1);

        var ls = "";

        sa.forEach(function (item) {
            if (ls == "") {
                ls = item;
            } else {
                ls += ", " + item;
            }
        });

        qs('#status_filter').value = ls;

        nt = "add-filter";
    }

    x.title = nt;

    filterList();
}