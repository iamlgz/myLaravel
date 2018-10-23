<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/17
 * Time: 10:50
 */
?>
@extends('adminlte::master')
<script src="{{\Illuminate\Support\Facades\URL::asset('/js/app.js')}}"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">角色信息修改</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="post" action="{{url('admin/button/poweradd')}}">
        <div class="box-body">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">角色名称</label>
                <div class="col-sm-10">
                    <select name="role_name" id="change" class="form-control">
                        @foreach($role as $v)
                        <option value="{{$v->id}}">{{$v->role_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            @foreach($button as $v)
                <div class="box-body">
                    <label for="inputPassword3" class="col-sm-2 control-label">
                        {{$v['text']}}
                    </label>
                </div>
            <div style="margin-left: 150px;line-height: 20px">
                @foreach($v['son'] as $va)
                        <input type="checkbox" value="{{$va['id']}}" name="checkname[]" style="margin-left: 20px;">{{$va['button_name']}}
                @endforeach
            </div>
            @endforeach
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-default">取消</button>
            <button type="submit" class="btn btn-info pull-right">添加</button>
        </div>
    </form>
</div>

{{--<script>--}}
    {{--$(function () {--}}
        {{--var id = $("#change").val();--}}
        {{--$.ajax({--}}
            {{--url:"{{url('admin/role/select')}}",--}}
            {{--data:{id:id},--}}
            {{--success:function (msg) {--}}
                {{--console.log(msg)--}}
            {{--}--}}
        {{--})--}}
    {{--})--}}
{{--</script>--}}