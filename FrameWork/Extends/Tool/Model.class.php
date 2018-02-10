<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9
 * Time: 10:18
 */

class Model
{

    //保存连接信息
    public static $link = null;

    //保存表名
    protected $table = null;

    //初始化表信息
    private $opt;

    //执行的最后一条sql
    protected static $sql = null;

    public function __construct($table=null)
    {
        $table = trim($table);
        //数据库表
        $this->table = is_null($table) ? C('DB_PREFIX') . $this->table : C('DB_PREFIX') . $table;

        //连接数据库
        $this->_connect();

        //初始化表信息
        $this->_opt();

    }

    /**
     * 连接数据库
     */
    private function _connect() {

        if (is_null(self::$link)) {

            if ( empty(C('DB_DATABASE')) ) halt('请先配置数据库');

            $link = new mysqli(C('DB_HOST'),C('DB_USER'),C('DB_PASSWORD'),C('DB_DATABASE'),C('DB_PORT'));

            if ( $link -> connect_error ) halt('，数据库连接错误，请检查数据库配置项');

            $link->set_charset(C('DB_CHARSET'));

            self::$link = $link;

        }

    }

    /**
     * 初始化表信息
     */
    private function _opt() {

        $this->opt = array(
            'fields' => '*',
            'where'   => '',
            'group'   => '',
            'having'  => '',
            'order'   => '',
            'limit'   => ''
        );

    }

    /**
     * 查询字段
     * @param string $fields
     * @return string
     */
    public function fields($fields='*') {
        $this->opt['fields'] = $fields;
        return $this;

    }

    /**
     * 查询where条件
     * @param $where
     * @return $this
     */
    public function where($where) {

        $where = ' WHERE '.$where;

        $this->opt['where'] = $where;

        return $this;

    }

    /**
     * 分组group条件
     * @param $group
     * @return $this
     */
    public function group($group) {
        $this->opt['group'] = ' GROUP BY '.$group;
        return $this;
    }

    /**
     *
     * @param string $fields
     * @return $this
     */
    public function having($having) {
        $this->opt['having'] = $having;
        return $this;

    }

    /**
     * 限制查询条数
     * @param $limit
     * @return $this
     */
    public function limit($limit) {
        $limit_str = ' limit '. $limit;
        $this->opt['limit'] = $limit_str;
        return $this;

    }

    /**
     * 排序
     * @param $order
     * @return $this
     */
    public function order($order) {
        $this->opt['order'] = ' ORDER BY '.$order;
        return $this;

    }

    /**
     * 查询所有
     * @return array
     */
    public function select(){

        $sql = 'select '. $this->opt['fields'] .' from '. $this->table . $this->opt['where'] . $this->opt['group'] . $this->opt['having'] . $this->opt['order'] . $this->opt['limit'];

        return $this->query($sql);

    }


    public function find() {

        $result = $this->limit(1)->select();

        return current($result);

    }

    /**
     * 删除
     * @return mixed
     */
    public function delete() {

        if (empty($this->opt['where'])) halt('没有添加where，不能执行sql');

        $sql = 'DELETE FROM '.$this->table.$this->opt['where'];

        return $this->execute($sql);

    }


    public function add($data) {

        is_array($data) && !empty($data) || halt('The data that you want to insert is not allow empty !');

        $keys_sql = '';
        $values_sql = '';

        foreach ($data as $key => $value) {
            $keys_sql .= $this->_safe_deal($key).',';
            $values_sql .= '"'.$this->_safe_deal($value).'",';
        }

        $keys_sql = substr($keys_sql,0,-1);
        $values_sql = substr($values_sql,0,-1);

        $sql = 'INSERT INTO '.$this->table.' ('.$keys_sql.') values ('.$values_sql.')';

        return $this->execute($sql);

    }


    /**
     * 执行sql
     * @param $sql      需要执行的sql语句
     * @return array    返回数据 含有结果集
     */
    public function query($sql) {

        self::$sql = $sql;

        $result = self::$link -> query($sql);

        if( self::$link -> errno ) halt('mysql错误：' . self::$link->error);

        $select_data = array();

        while($tmp_data = $result->fetch_assoc()){

            $select_data[] = $tmp_data;

        }

        return $select_data;

    }

    /**
     * 执行sql
     * @param $sql
     * @return mixed    返回成功与否
     */
    public function execute($sql) {

        self::$sql = $sql;

        $result = self::$link -> query($sql);

        $this->_opt();

        if (is_object($result)) halt('you should use query() to execute your sql!');

        if($result) {
            return self::$link->insert_id ? self::$link->insert_id : self::$link->affected_rows;
        } else {
            halt('mysql error :'.self::$link->error);
        }

    }

    /**
     * 安全处理
     * @param $str
     * @return mixed
     */
    private function _safe_deal($str) {

        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }

        return self::$link -> real_escape_string($str);

    }


}