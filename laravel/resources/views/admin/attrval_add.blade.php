<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/17
 * Time: 10:50
 */
?>
@extends('adminlte::master')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">角色信息修改</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="post" action="{{url('admin/attrval/add')}}" onsubmit="return verify()">
        <div class="box-body">
            {{csrf_field()}}
            <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">属性名称</label>
            <div class="col-sm-10">
                <select name="attr_id" id="change" class="form-control">
                    @foreach($attributes as $v)
                        <option value="{{$v['id']}}">{{$v['name']}}</option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="form-group">


                <label for="inputPassword3" class="col-sm-2 control-label">属性值名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="attr_name" name="name" placeholder="Name">
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-default">取消</button>
            <button type="submit" class="btn btn-info pull-right">添加</button>
        </div>
    </form>
</div>

<script>
    function verify() {
        var role = document.getElementById('attr_name').value;

        if (role == ''){
            alert('请输入属性值名称');
            return false;
        }
        return true;
    }

</script>
