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
        <h3 class="box-title">管理员信息修改</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="post" action="{{url('admin/admin/update')}}" onsubmit="return verify()">
        <input type="hidden" name="admin_id" value="{{$data['admin_id']}}">
        <div class="box-body">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"">邮箱</label>

                <div class="col-sm-10">
                    <input type="email" class="form-control" name="admin_email" value="{{$data['admin_email']}}" id="admin_email" placeholder="Email">
                </div>
            </div>
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">密码</label>

                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">重复密码</label>

                <div class="col-sm-10">
                    <input type="password" class="form-control" name="repassword" id="repassword" placeholder="RePassword">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nickname" value="{{$data['nickname']}}" name="nickname" placeholder="Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">手机号</label>
                <div class="col-sm-10">
                    <input type="tel" class="form-control" name="mobile" value="{{$data['admin_mobile']}}" id="mobile" placeholder="Mobile">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">是否冻结</label>
                <div class="col-sm-10">
                    <select name="is_freeze" id="" class="form-control">
                        @if($data['is_freeze'])
                            <option value="1" selected>冻结</option>
                            <option value="0">正常</option>
                            @else
                            <option value="1">冻结</option>
                            <option value="0" selected>正常</option>
                        @endif


                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">分配角色</label>
                <div class="col-sm-10">
                    <select name="role_id" id="" class="form-control">
                        @foreach($role as $v)
                            @if($v['id'] == $data['role_id'])
                                <option value="{{$v['id']}}" selected>{{$v['role_name']}}</option>
                                @else
                                <option value="{{$v['id']}}">{{$v['role_name']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-default">取消</button>
            <button type="submit" class="btn btn-info pull-right">修改</button>
        </div>
    </form>
</div>

<script>
    function verify() {
        var email = document.getElementById('admin_email').value;
        var password = document.getElementById('password').value;
        var repassword = document.getElementById('repassword').value;
        var mobile = document.getElementById('mobile').value;
        if (email == ''){
            alert('请输入邮箱')
            return false
        }
        if (password !== repassword){
            alert('两次输入的密码不一致')
            return false
        }
        if (mobile == ''){
            alert('请输入手机号')
            return false
        }
        return true;
    }

</script>
