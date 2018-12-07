<?php

/**
 * Service 基类
 *
 * @author cuijiji
 * @date 2018/10/15
 */

namespace Services\Code;


class BaseService
{
    /**
     * 创建
     *
     * @param array $data 数据
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->dao->create($data);
    }

    /**
     * 更新
     *
     * @param array $data 数据
     * @param int $id 主键
     * @param string $attribute 默认主键id，可设置其他的
     * @return mixed
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        return $this->dao->where($attribute, '=', $id)->update($data);
    }

    /**
     * 删除
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->dao->destroy($id);
    }

    /**
     * 获取全部数据
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->dao->get($columns)->toArray();
    }

    /**
     * 根据id获取数据
     *
     * @param $id
     * @param array $columns 查询的字段
     * @return mixed
     */
    public function findById($id, $columns = ['*'])
    {
        $data = $this->dao->find($id, $columns);
        if(count($data)){
            $data->toArray();
        }
        return $data;
    }


    /**
     * 根据指定的字段和值获取单条数据
     *
     * @param string $attribute 字段
     * @param void $value 值
     * @param array $columns 查询字段
     * @return mixed
     */
    public function find($attribute, $value, $columns = ['*'])
    {
        $data = $this->dao->where($attribute, '=', $value)->first($columns);
        if(count($data)){
            $data->toArray();
        }
        return $data;
    }

    /**
     *
     * 根据指定的字段和值获取多条数据
     *
     * @param $attribute 字段
     * @param $value 值
     * @param array $columns 查询的字段
     * @return mixed
     */
    public function findAll($attribute, $value, $columns = ['*'])
    {
        if (is_array($value)) {
            return $this->dao->whereIn($attribute, $value)->get($columns)->toArray();
        } else {
            return $this->dao->where($attribute, '=', $value)->get($columns)->toArray();
        }

    }

    /**
     *
     * 根据id获取数据
     *
     * @param $value 值
     * @param array $columns 查询的字段
     * @return mixed
     */
    public function findAllById($value, $columns = ['*'])
    {
        return $this->findAll('id', $value, $columns);
    }

    /**
     * 根据指定的查询条件获取实体集合
     *
     * @param $where 查询条件
     * @param array $columns 查询字段
     * @param bool $or
     * @return mixed
     */
    public function findByWhere($where, $columns = ['*'], $or = false)
    {

        $dao = $this->dao;

        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $dao = (! $or)
                    ? $dao->where($value)
                    : $dao->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $dao = (! $or)
                        ? $dao->where($field, $operator, $search)
                        : $dao->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $dao = (! $or)
                        ? $dao->where($field, '=', $search)
                        : $dao->orWhere($field, '=', $search);
                }
            } else {
                $dao = (! $or)
                    ? $dao->where($field, '=', $value)
                    : $dao->orWhere($field, '=', $value);
            }
        }
        return $dao->get($columns)->toArray();
    }
}