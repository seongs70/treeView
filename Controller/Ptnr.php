<?php
namespace Controller;


class Ptnr {

    public $ptnrTable;

    public function __construct($ptnrTable)
    {
        $this->ptnrTable = $ptnrTable;

    }
    //계보도 작성
    public function treegrid()
    {

        //로그인 사용자 핸드폰 번호
        if ($_POST) {
            //Depth
            $tree_row = $_POST['sel_row'];
            //구분 : 내조직도, 전체
            $wchk = $_POST['wherechk'];
            //검색영역 : 이름, 핸드폰
            $wchk2 = $_POST['wherechk2'];
            //트리형 :세로, 가로
            $treechk = $_POST['treechk'];
            //검색구분 : 일치, 포함
            $like = $_POST['nolike'];
            //검색어
            $str = $_POST['str'];
            if ($wchk) {
                $where = $wchk2. "|" . $str;

            }

        }

        //baro_ptnr 모든 데이터 조회
        $ptnr_list = $this->ptnrTable->findAll();

        if ($_POST) {
            //검색한 결과값
            $search = $this->ptnrTable->search($wchk2, $str, $like);

        }
        if(isset($search)){
            $my_level = $search->gen_level;
            $ptnr_mp = $search->ptnr_mp;
        }

//
//        //전체 데이터 값에서 필요한 값만 배열로 구성
        foreach ($ptnr_list as $key => &$value) {
            $sub_data["id"] = &$value->ptnr_mp;
            if(isset($treechk) && $treechk == 'width_tree'){
                $sub_data["name"] = $value->ptnr_name.' '.$value->gen_level;
            } else {
                $sub_data["name"] = $value->ptnr_name;
            }
            $sub_data["level"] = &$value->gen_level;
//            $sub_data["parent_name"] = &$value->prnts_ptnr_name;
            $sub_data["parent_id"] = &$value->prnts_ptnr_mp;
            $data[] = $sub_data;

        }

//
//        // 아래 foreach로 $data 배열을 연관배열로 구성할텐데 현재 레벨 + Depth로 숫자 설정

        if ($_POST) {

            if($wchk !== 'all_tree' || empty($wchk)){
                $tree_number = $my_level + $tree_row;
//
            }
            // 전체 & 세로형
            if($wchk == 'all_tree' && $treechk == 'height_tree'){
                $tree_number = $my_level + $tree_row;
            }
            // 전체 & 가로형
            if($wchk == 'all_tree' && $treechk == 'width_tree'){
                $tree_number = $my_level + $tree_row;
            }

            // $ouput[id]값에 해당id값 배열 넣기
            foreach ($data as $key => &$value) {
                $output[$value["id"]] = &$value;
            }
        }
//
//



        foreach ($data as $key => &$value) {
            if(isset($tree_row) && $tree_row !== 'all') {
                //$output에 연관배열 값 넣기      &$value에서 & 값이 중요하다
                if ($value['level'] < $tree_number) {
                    if ($treechk == 'width_tree' && $value["parent_id"] && isset($output[$value["parent_id"]])) {
                        $output[$value["parent_id"]]['children'][] = &$value;
                    } else {
                        $output[$value["parent_id"]][] = &$value;
                    }
                }
            } else {
                if (isset($treechk) &&$treechk == 'width_tree' && $value["parent_id"] && isset($output[$value["parent_id"]])) {
                    //                if($output[$value["level"] < 3){
                    $output[$value["parent_id"]]['children'][] = &$value;
                } else {
                    $output[$value["parent_id"]][] = &$value;
                }
            }
        }

        //의미 크게 없는듯
        foreach ($data as $key => &$value) {

            if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
                unset($data[$key]);
            }

        }


        if (isset($ptnr_mp)){
            $send_data = $output[$ptnr_mp];
        }
        if (isset($wchk) && $wchk == 'all_tree' &&  $treechk == 'width_tree'){
            $send_data[0] = $output['0000000'];
            $send_data[1] = $output['0000001'];
        }
        if (isset($wchk)) {
            if ($wchk == 'all_tree') {
                $send_data = $data;
            }
        }

        include(__DIR__ . '/../Views/ptnr_treegrid.php');

    }
}