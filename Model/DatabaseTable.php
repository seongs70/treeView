<?php
namespace Model;

class DatabaseTable{
    public $pdo;
    public $table;
    public $primaryKey;
    public $className;
    //해당 클래스의 인수
    public $constructorArgs;

    //메서드를 호출하기 전 변수가 설정되지 않거나 $pdo변수에 문자열이 저정되는 오류를 없애기 위해 생성자를 사용
    //stdClass는 PHP내장 클래스며 알맹이가 ㅇ벗는 빈 클래스, 간단한 데이터를 저장
    //클래스명 인수를 생략하면 기본적으로 stdClass가 지정된다. 일일이 엔티티 클래스를 만들필요 없이
    //추가로 메서드를 구현할 엔티티클래스만 만들면된다.
    public function __construct(\PDO $pdo, string $table, string $primaryKey, string $className = '\stdClass', array $constructorArgs = [])
    {

        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
        $this->constructorArgs = $constructorArgs;
    }
    //쿼리 실행
    public function query($sql, $parameters = []){
        //데이터베이스 커넥션과 테이블명을 인수로 전달받지 않고 클래스 변수에서 가져온다.
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);

        return $query;
    }

    public function findAll()
    {
        $result = $this->query('SELECT * FROM `' . $this->table . '`');

        return $result->fetchAll(\PDO::FETCH_CLASS);
    }

    //PK로 열검색
    public function findById($value)
    {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :value';
        $parametesr = ['value' => $value];

        //query()함수에서 사용할 $parameter배열 제공
        $query = $this->query($query, $parameters);
        //findById()메서드에서 fetchObject()메서드를 호출할때 클래스명과 인수를 코드에 직접 쓰지않고 클래스 변수로 대체한다.
        return $query->fetchObject($this->className, $this->constructorArgs);
    }
    
    //지정한 칼럼에서 지정한 값을 검색해 반환
    public function find($column, $value)
    {
        $query = 'SELECT * FROM' . $this->table . ' WHERE ' . $column . ' =:value';

        $parameters = [
            'value' => $value
        ];

        $query = $this->query($query, $parameters);

        return $query->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }



    //검색 함수
    //    //$where == 검색할 열 $value == 검색할 단어 $
    public function searchAll($where, $value, $division){
        if($division==1){
            $query = 'SELECT * FROM `' . $this->table.'` WHERE' . ' `'.$where.'`' . ' like' .  ' \''.$value.'\''.' order by '. $this->primaryKey.' DESC' ;
        } else {
            $query = 'SELECT * FROM `' . $this->table.'` WHERE' . ' `'.$where.'`' . ' like' .  ' \'%'.$value.'%\''.' order by '. $this->primaryKey.' DESC';
        }
        //echo $query;
        $query = $this->query($query, $parameters);
        return $query->fetchAll();
    }
    public function search($where, $value, $division) {

        if($division==1){
            $query = 'SELECT * FROM `' . $this->table.'` WHERE' . ' `'.$where.'`' . ' like' .  ' \''.$value.'\''.' order by '. $this->primaryKey.' DESC';
//            echo $query;
        } else {
            $query = 'SELECT * FROM `' . $this->table.'` WHERE' . ' `'.$where.'`' . ' like' .  ' \'%'.$value.'%\''.' order by '. $this->primaryKey.' DESC';
        }


        //echo $query;
        // query() 함수에서 사용할 $parameters 배열 생성
        //$parameters = ['value' => $value];
        // query() 함수에서 사용할 $parameters 배열 제공
//        echo $query;

        $query = $this->query($query);
        return $query->fetchObject($this->className, $this->constructorArgs);
        // print_r($query->fetch());
    }



    public function paging($s_point, $list) {

        $query = 'SELECT * FROM `' . $this->table . '`'  . ' order by ' . $this->primaryKey . ' DESC LIMIT '. $s_point.','.$list;
        try{
            $query = $this->query($query, $parameters);
            return $query->fetchAll();
        } catch(Exception $e) {
            $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        }


    }

    //elpd_qr_list에서 날짜검색할때 필요한 조인문 쿼리
    public function elpd_qr_join($start_date, $end_date, $s_point, $list){
        $query = 'SELECT * FROM (`elpd_qr`) LEFT OUTER JOIN `elpd_sale_nation` ON `elpd_qr`.`elpd_nation_code`=`elpd_sale_nation`.`nation_code` WHERE `elpd_prod_de` >= \''.$start_date. '\' AND `elpd_prod_de` <= '.'\''.$end_date.'\' ORDER BY '.$this->primaryKey.' DESC LIMIT '. $s_point.','.$list;
        //echo $query;
        $query = $this->query($query, $parameters);
        return $query->fetchAll();
    }
    public function elpd_qr_join_count($start_date, $end_date){
        $query = 'SELECT COUNT(*) FROM (`elpd_qr`) LEFT OUTER JOIN `elpd_sale_nation` ON `elpd_qr`.`elpd_nation_code`=`elpd_sale_nation`.`nation_code` WHERE `elpd_prod_de` >= \''.$start_date. '\' AND `elpd_prod_de` <= '.'\''.$end_date.'\'';
        $query = $this->query($query, $parameters);
        return $query->fetch();
    }








}
