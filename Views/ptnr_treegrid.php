

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../Views/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Views/css/bootstrap-responsive.css">
    <link rel="stylesheet" href="../Views/css/style.css">
    <script src="../Views/js/jquery.js"></script>
    <script src="../Views/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Views/css/jquery-ui.css">
    <script src="../Views/js/jquery-ui.js"></script>

    <link rel="stylesheet" href="../Views/css/treeview1.css">
    <link rel="stylesheet" href="../Views/css/jquerysctipttop.css" >
    <link rel="stylesheet" href="../Views/css/jquery.orgchart.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css">

    <title>대리점 계보도</title>
</head>

<style>


    .tree_wrap{
        margin-left: 60px;
        margin-top: 51px;

    }
    .fa-user{
        position:absolute; margin-left:39px;
        color: darkturquoise;

    }
    .fa-user ul li {
        float:left; font-size:14px;
        color:black; font-weight:bold;
    }
    .fa-user ul{
        position:absolute; width:200px;
        top:28%; left:55px;
        border-left:none !important;
    }
    .fs{display:none;}

    /*li, ul, dl, dd, dt, ol{margin-left:10px;}*/
    /*.tree_ul1{float:left; width:100%;}*/
    /*li {text-align:center; }*/
    /*.two_st_wrap{display:inline-block; float:left;}*/

    .tree_wrap > li > ul{
        margin-top:0 !important;
    }
    i{    z-index: 9999;}


    .w163 a{ color:#333 !important;}
    .w163 li:hover a {color:white !important;
        font-weight:300 !important;
    }








    #chart-container{}
    .orgchart {
        background: white;
    }
    .orgchart .node .title {

        color: white;
    }

    .orgchart .node .content {
        border-color: transparent;
        border-top-color: #333;
    }
    .orgchart .node:hover {
        background-color: rgba(255, 255, 0, 0.6);
    }
    .orgchart .node.focused {
        background-color: rgba(255, 255, 0, 0.6);
    }
    .orgchart .node .edge {
        color: rgba(0, 0, 0, 0.6);
    }
    .orgchart .edge:hover {
        color: #000;
    }
    .orgchart td.left,
    .orgchart td.top,
    .orgchart td.right {
        border-color: #fff;
    }
    .orgchart td>.down {
        background-color: #fff;
    }


</style>
<?php


function array2ul($array) {

    if(isset($array[0])){
        $out = "<ul>";
    } else {
        $out = '';
    }

    foreach($array as $key => $elem){

        $out = is_array($elem) ? $out . "<li><a target=\"_blank\" href='/ptnr/ptnr_view/$elem[id]' onclick=\"window.open(this.href, '_blank', 'width=1120,height=480px,toolbars=no,scrollbars=no, left=500, top=250'); return false;\"
>$elem[id] $elem[name] $elem[level]</a>" . array2ul($elem) . "</li>" : $out = $out;
    }
    if(isset($array[0])){
        $out = $out ."</ul>";
    } else {
        $out = $out;
    }


    return $out;


}

if($_POST) {
//    print_r($_POST);
    $schk = $_POST['wherechk'];
    if($schk=='my_tree') $my_tree = "checked"; else $my_tree = "";
    if($schk=='all_tree') $all_tree = "checked"; else $all_tree = "";
    $schk2 = $_POST['wherechk2'];
    if($schk2=='ptnr_name') $ptnr_name = "checked"; else $ptnr_name = "";
    if($schk2=='ptnr_mp') $ptnr_mp = "checked"; else $ptnr_mp = "";
    $tchk = $_POST['treechk'];
    if($tchk=='height_tree') $height_tree = "selected"; else $height_tree = "";
    if($tchk=='width_tree') $width_tree = "selected"; else $width_tree = "";
    $sel_row = $_POST['sel_row'];
    if($sel_row=='3') $row_chk[0] = 'selected';
    if($sel_row=='4') $row_chk[1] = 'selected';
    if($sel_row=='all') $row_chk[2] = 'selected';
    if($_POST['nolike']=='1') { $nolike1 = "checked";$nolike2=""; } else { $nolike2="checked";$nolike1=""; }
} else {
    $my_tree = "checked";
    $nolike1 = "checked";
    $nolike2 = "";
    $ptnr_name = "checked";
    $height_tree = "selected";
}



?>

<body>
<form action="" method="post" name="keyword_list"  >
    <table class="search_table">
        <tbody>
        <tr>
            <th>트리형</th>
            <td>
                <select name="treechk" id="">
                    <option value="height_tree" <?=$height_tree?>>세로형</option>
                    <option value="width_tree" <?=$width_tree ?? null ?>>가로형</option>
                </select>
            </td>

        </tr>
        <tr>
            <th>Depth</th>
            <td>
                <select name="sel_row" id="">
                    <option value="3" <?=$row_chk[0] ?? null ?>>2대</option>
                    <option value="4" <?=$row_chk[1] ?? null ?>>3대</option>
                    <option value="all" <?=$row_chk[2] ?? null ?>>전체보기</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>구분</th>
            <td>
                <input type="radio" name="wherechk" id="wc1" class="checkbox ckck" value='my_tree' onClick="box_check(this)" <?=$my_tree ?? null ?>/><label for="wc1">내 조직도</label>
                <input type="radio" name="wherechk" id="wc2" class="checkbox ckck" value='all_tree' onClick="box_check(this)"<?=$all_tree ?? null ?>/><label for="wc2">전체보기</label>

            </td>
        </tr>
        <tr>
            <th>검색영역</th>
            <td>
                <input type="radio" name="wherechk2" id="wc3" class="checkbox" value='ptnr_name' <?=$ptnr_name ?? null ?>/><label for="wc3">이름</label>
                <input type="radio" name="wherechk2" id="wc4" class="checkbox" value='ptnr_mp' <?=$ptnr_mp ?? null ?>/><label for="wc4">핸드폰</label>

            </td>
        </tr>
        <tr>
            <th>검색구분</th>
            <td>
                <input type="radio" name="nolike" id="nl1" value="1" class="checkbox" <?=$nolike1 ?? null ?> /> <label for="nl1">일치</label>
                <input type="radio" name="nolike" id="nl2" value="2" class="checkbox" <?=$nolike2 ?? null ?> /> <label for="nl2">포함</label>
            </td>
        </tr>
        <tr>
            <th>검색어</th>
            <td>
                <input type="text" name="str" class="input-medium search-query"  id="search_query" value="<?=$_POST['str'] ?? null ?>" />
                <button type="submit" class="btn btn-primary">검색</button>
                <a href="" class="btn">초기화</a>
            </td>
        </tr>
        </tbody>
    </table>
</form>
<?php

?>

<i class="fa fa-user fa-4x" aria-hidden="true" >
    <ul>
        <?php
        if(isset($_POST['treechk'])) {
            if ($_POST['wherechk'] !== 'all_tree') {
                ?>
                <li><?= $search->ptnr_mp; ?>&nbsp;</li>
                <li><?= $search->ptnr_name; ?>&nbsp;</li>
                <li><?= $search->gen_level; ?></li>
            <?php } else { ?>
                <li>전체보기</li>
            <?php }
        }?>
    </ul>
</i>
<div class="tree_wrap">
    <?php if(isset($_POST['treechk'])){
        if($_POST['treechk'] == 'height_tree' || $_POST['treechk'] == null){
        echo array2ul($send_data);
        }
    }?>
</div>
<script src="../Views/js/jquery.min.js"></script>

<script src="../Views/js/jquery.orgchart.js"></script>
<script>
    let treechk = '<?=$_POST['treechk'] ?? null;?>';
    let wherechk = '<?=$_POST['wherechk'] ?? null;?>';

    if(treechk == 'width_tree' && wherechk == 'all_tree'){
        $(document).ready(function() {
                datascource = <?=json_encode($send_data[0]) ?? null; ?>;
            $('#chart-container').orgchart({
                'data': datascource,
                'nodeContent': 'id',
            });
            datascource = <?=json_encode($send_data[1]) ?? null ?>;
            $('#chart-container1').orgchart({
                'data': datascource,
                'nodeContent': 'id',
            });
        });
    }

</script>
<script>
    let treechk2 = '<?=$_POST['treechk'] ?? null;?>';
    let wherechk2 = '<?=$_POST['wherechk'] ?? null;?>';

    if(treechk2 == 'width_tree' && wherechk2 == 'my_tree') {
        $(document).ready(function() {

            datascource = <?=json_encode($send_data) ?? null ?>;
            $('#chart-container').orgchart({
                'data': datascource,
                'nodeContent': 'id',
            });
        });
    }
</script>
<?php if(isset($_POST['treechk'])) { ?>
    <?php if($_POST['treechk'] == 'width_tree'){?>
        <div id="chart-container"></div>
        <div id="chart-container1"></div>
    <?php }?>
<?php } ?>

</body>
</html>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="../Views/js/treeview1.js"></script>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>

<script>

    let inputElements = document.getElementsByClassName('ckck');
    // alert(checkWherechk);
    let search_query = document.getElementById("search_query");
    console.log(search_query);
    let element_tr = document.getElementsByTagName("tr");

    for(let i=0; inputElements[i]; i++)
    {
        if(inputElements[i].checked){
            let checkedValue = inputElements[i].value;
            if(checkedValue == 'all_tree'){
                element_tr[3].style.display  = 'none';
                element_tr[4].style.display  = 'none';
                search_query.style.display  = 'none';
            } else  {
                element_tr[3].style.display  = 'table-row';
                element_tr[4].style.display  = 'table-row';
                search_query.style.display  = 'inherit';
            }
            break;
        }
    }


    function box_check(box){
        if(box.value == 'all_tree'){
            element_tr[3].style.display  = 'none';
            element_tr[4].style.display  = 'none';
            search_query.style.display  = 'none';
        } else  {
            element_tr[3].style.display  = 'table-row';
            element_tr[4].style.display  = 'table-row';
            search_query.style.display  = 'inherit';
        }

    }



    console.log(element_tr);



</script>