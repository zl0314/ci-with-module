<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * 数据库查询结果模型
 * @author zhang
 * @date   2016-12-15
 */
class Result_model extends MY_Model
{
    public $db;
    public $rwdb;

    public function __construct ()
    {
        parent::__construct();
        $this->db = $this->load->database( 'default', true );
        $this->rwdb = $this->db;
    }

    /**
     * 得到一行数据
     *
     * @param unknown $tb    表名
     * @param string  $field 字段
     * @param array   $where 查询条件
     * @param string  $order 排序
     *
     * @return array            返回一查询结果
     */
    public function getRow ( $tb, $field = '*', $where = [], $order = '' )
    {
        $this->db->select( $field );
        $this->db->from( $tb );
        //拼接where参数
        $this->join_where( $where );
        //排序
        if ( !empty( $order ) ) {
            $this->db->order_by( $order );
        }
        //只读取1条
        $this->db->limit( 1 );
        //查询
        $query = $this->db->get();

        return $query->row_array();
    }

    /**
     * 得到一条记录
     *
     * @param unknown $tb    表名
     * @param string  $field 字段
     * @param array   $where 查询条件
     * @param string  $order 排序
     *
     * @return array            返回一查询结果
     */
    public function getOne ( $tb, $field = '*', $where = [], $order = '' )
    {
        $row = $this->getRow( $tb, $field, $where, $order );
        if ( !empty( $row ) ) {
            $row_one = array_values( $row );

            return $row_one[0];
        }

        return null;
    }

    /**
     * 直接执行写好的SQL语句, 返回以二维数组形式返回
     *
     * @param string $sql
     *
     * @return array
     */
    public function getListBySql ( $sql )
    {
        $query = $this->db->query( $sql );

        return $query->result_array();
    }

    /**
     * 直接执行写好的SQL语句，  返回以一维数组返回
     *
     * @param string $sql
     *
     * @return array
     */
    public function getRowBySql ( $sql, $limit = 0, $offset = 0 )
    {
        //查询数量
        $query = $this->db->query( $sql );

        return $query->row_array();
    }

    /**
     * 直接执行写好的SQL语句，  返回某列的值
     *
     * @param string $sql
     *
     * @return array
     */
    public function getOneBySql ( $sql )
    {
        $row = $this->getRowBySql( $sql );
        if ( !empty( $row ) ) {
            $row_one = array_values( $row );

            return $row_one[0];
        }

        return null;
    }

    /**
     * 直接执行写好的SQL语句, 返回以二维数组形式返回
     *
     * @param string $sql
     *
     * @return array
     */
    public function updateBySql ( $sql )
    {
        $res = $this->db->query( $sql );

        return $res;
    }

    /**
     * 得到一组数据
     *
     * @param unknown $tb     表名
     * @param string  $field  字段
     * @param array   $where  查询条件
     * @param int     $limit  限制几条
     * @param int     $offset 移动几条
     * @param string  $order  排序
     *
     * @return array
     */
    public function getList ( $tb, $field = '*', $where = [], $limit = 0, $offset = 0, $order = '' )
    {
        $this->db->select( $field );
        $this->db->from( $tb );
        //拼接where参数
        $this->join_where( $where );
        //排序
        if ( !empty( $order ) ) {
            $this->db->order_by( $order );
        }
        //查询数量
        if ( !empty( $limit ) ) {
            $this->db->limit( $limit, $offset );
        }
        //查询
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    /**
     * 保存数据
     *
     * @param array $data    保存的数据
     * @param str   $id_name 数据库id字段
     *
     * @return insert_id        返回结果ID
     */
    public function save ( $tb, $data, $id_name = 'id' )
    {
        if ( empty( $data [ $id_name ] ) ) {
            $id = $this->insert( $tb, $data, true );
        } else {
            $id = $data[ $id_name ];
            unset( $data[ $id_name ] );
            $this->update( $tb, [ $id_name => $id ], $data );
        }

        return $id;
    }

    /**
     * 插入数据
     *
     * @param $data   (array)     添加的数据
     * @param $new_id (Bool)    是否返回ID
     *
     * @return (bool)(int)      返回 Bool 或 插入 自增ID
     */
    public function insert ( $tb, $data, $new_id = false )
    {
        $result = $this->rwdb->insert( $tb, $data );
        if ( $result && $new_id ) {
            return $this->rwdb->insert_id();
        }

        return $result;
    }

    /***
     * @param $data
     *
     * @return mixed
     */
    public function insert_batch ( $tb, $data )
    {
        $result = $this->db->insert_batch( $tb, $data );

// 		echo $this->db->last_query();
        return $result;
    }

    /**
     * 编辑数据库条目
     *
     * @param $where (array)        条件
     * @param $data  (array)         更新数据
     *
     * @return (bool)               返回操作结果
     */
    public function update ( $tb, $where, $data )
    {
        return $this->rwdb->update( $tb, $data, $where );
    }

    /**
     * 物理删除数据
     *
     * @param $where    删除where条件
     *
     * @return bool     返回操作结果
     */
    public function delete ( $tb, $where )
    {
        $result = $this->rwdb->delete( $tb, $where );

        return $result;
    }

    /**
     * Usage
     * $where = array(
     *      'in' => array('id' => array(1,2,3)),
     *      'or' => array('title' => '巴西6名警察枪杀2名贫民被捕', 'source' => '国际在线 '),
     *      'like' => array('title' => '巴西', 'source' => '新闻'),
     *      'join' => array('news', 'news.id=stu.id', 'right'),
     *  );
     *
     * @param array $where 查询条件
     */
    private function join_where ( $where )
    {
        if ( !empty( $where ) ) {
            foreach ( $where as $k => $r ) {
                switch ( $k ) {
                    case 'in' :
                        foreach ( $r as $sk => $sr ) {
                            $this->db->where_in( $sk, $sr );
                        }
                        break;
                    case 'or' :
                        foreach ( $r as $sk => $sr ) {
                            $this->db->or_where( $sk, $sr );
                        }
                        break;
                    case 'join' :
                    case 'join' :
                        if ( is_array( $r[0] ) ) {
                            foreach ( $r as $joink => $joinr ) {
                                $this->db->join( $joinr[0], $joinr[1], @$joinr[2] );
                            }
                        } else {
                            $this->db->join( $r[0], $r[1], @$r[2] );
                        }
                        break;
                    case 'like' :
                        foreach ( $r as $sk => $sr ) {
                            $this->db->like( $sk, $sr );
                        }
                        break;
                    case 'or_like' :
                        foreach ( $r as $sk => $sr ) {
                            $this->db->or_like( $sk, $sr );
                        }
                        break;
                    case 'having' :
                        $this->db->having( $k, $r );
                        break;
                    case 'group_by' :
                        $this->db->group_by( $where );
                        break;
                    default:
                        $this->db->where( $k, $r );
                        break;
                }
            }
        }
    }


    /**
     * 得到所有查询语句
     *
     * @param book $dump 是否在页面直接打印
     *
     * @return array $queries
     */
    public function get_queries ( $dump = false )
    {
        $queries_default = $queries_rw = [];
        if ( !empty( $this->db->queries ) ) {
            $queries_default = $this->db->queries;
        }

        $queries = array_merge( $queries_default, $queries_rw );
        if ( $dump ) {
            P( $queries );
        }

        return $queries;
    }

    /**
     * 析构方法， 用于把所有的SQL语句存到日志里， 便于查看
     */
    public function __destruct ()
    {
        $query = $this->get_queries();
        foreach ( $query as $k => $sql ) {
            $sql = str_replace( [ "\r", "\n" ], ' ', $sql );
            MyLog::db( $sql );
        }

    }
}