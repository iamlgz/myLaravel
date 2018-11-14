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
        <h3 class="box-title">修改分类</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="post" action="{{url('admin/category/update')}}" onsubmit="return verify()" enctype="multipart/form-data">
        <div class="box-body">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">分类名称</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Name" value="{{$data->c_name}}">
                </div>
            </div>
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">图片</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control-file" name="imgfile" placeholder="图片">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">URL</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="" name="url" placeholder="非必填项">
                </div>
            </div>
            <input type="hidden" name="id" value="{{$id}}">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">父级分类</label>
                <div class="col-sm-10">
                    <select name="pid" id="" class="form-control">
                        <option value="0">父级分类</option>
                        @foreach($cate as $v)
                            @if($data->pid == $v->c_id)
                            <option value="{{$v->c_id.'/'.$v->path.'-'.$v->c_id}}" selected>{{$v->c_name}}</option>
                                @else
                                <option value="{{$v->c_id.'/'.$v->path.'-'.$v->c_id}}">{{$v->c_name}}</option>
                            @endif
                        @endforeach
                    </select>
                    {{--<option value="0">父级分类</option>--}}
                    {{--@foreach($data as $v)--}}
                        {{--<option value="{{$v->path.'-'.$v->c_id}}">{{str_repeat('|--',substr_count($v->a,'-')-1)}}{{$v->c_name}}</option>--}}
                    {{--@endforeach--}}
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
        var category_name = document.getElementById('category_name').value;

        if (category_name == ''){
            alert('请输入分类名称')
            return false
        }

        return true;
    }

</script>
