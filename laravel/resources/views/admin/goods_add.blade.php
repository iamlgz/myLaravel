<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/25
 * Time: 13:40
 */
?>
@extends('adminlte::master')
@include('UEditor::head');
<script src="{{\Illuminate\Support\Facades\URL::asset('/js/app.js')}}"></script>
<script src="{{\Illuminate\Support\Facades\URL::asset('/js/select2.full.min.js')}}"></script>
<div class="content">
    <form action="{{url('admin/goods/goodsadd')}}" name="goodsForm" method="post" novalidate="true" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
        
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">商品名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="" name="goods_name">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label" style="margin-top: 20px;margin-bottom: 20px;">商品价格</label>
            <div class="col-sm-10" style="margin-top: 20px;margin-bottom: 20px;">
                <input type="text" class="form-control" id="" name="goods_price">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">促销价格</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="" name="promotion_price">
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label" style="margin-top: 20px;margin-bottom: 20px;">是否促销</label>
            <div class="col-sm-10" style="margin-top: 20px;margin-bottom: 20px;">
                <select name="is_sale" class="form-control">
                    <option value="0">否</option>
                    <option value="1">是</option>
                </select>
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">商品图片</label>
            <div class="col-sm-10">


                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Launch Modal
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="file-loading">
                                    <input id="input-b9" name="goods_img[]" multiple type="file"'>
                                </div>
                                <div id="kartik-file-errors"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" title="Your custom upload logic">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label" style="margin-top: 20px;margin-bottom: 20px;">商品分类</label>
            <div class="col-sm-10" style="margin-top: 20px;margin-bottom: 20px;">
                <select name="t_id" id="t_id" class="form-control" style="width: 100%">
                    <option>请选择</option>
                    @foreach($cate as $v)
                    <option value="{{$v->c_id}}">{{str_repeat('|--',substr_count($v->path,'-'))}}{{$v->c_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">商品属性</label>
            <div class="col-sm-10" style="float: left;">
                <select class="form-control select2" id="attributes" name="attributes[]" multiple="multiple" data-placeholder="Select a State"
                        style="width: 100%;">

                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label" style="margin-top: 20px;margin-bottom: 20px;">属性值</label>
            <div class="col-sm-10" style="margin-top: 20px;margin-bottom: 20px;">
                <table border="1" class="table" id="table">

                </table>
                <table>
                    <tr><td colspan="2" style="text-align: center"><span class="btn btn-info iamlgz" id="create_sku">生成货品</span></td></tr>
                </table>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10">
                <table border="1" class="sku_table" id="sku_table"></table>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10" style="margin-top: 20px;margin-bottom: 20px;">
                <script id="container" name="content" type="text/plain">商品描述</script>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10">
                <input type="submit" value="添加" class="btn btn-info">
            </div>
        </div>

    </form>
</div>
<script>



    var ue = UE.getEditor('container');


    $('.select2').select2();
    $("#attributes").change(function () {
        var val = $("#attributes").val();
        var token = $("#_token").val();
        $.ajax({
            url:"{{url('admin/attrval/getone')}}",
            type:"post",
            data:{_token:token,data:val},
            success:function(msg){
                $("#table").html(msg);
            }
        })
    });

    $("#t_id").change(function () {
        var id = this.value;
        str = '';
        $.get("{{url('admin/attr/get')}}", {id:id},
            function(data){
                for (var i in data){
                    str += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                $("#attributes").html(str);
            });

    })


    $(document).on('ready', function() {
        $("#input-b9").fileinput({
            showPreview: false,
            showUpload: false,
            elErrorContainer: '#kartik-file-errors',
            allowedFileExtensions: ["jpg", "png", "gif"]
            //uploadUrl: '/site/file-upload-single'
        });
    });

    $("#create_sku").click(function () {
        var iamlgz = [];
        var all =[];
        var attr = [];
        $(".lgz").each(function (i) {
            var arr = [];
            attr.push(this.id);

            $("#table>tr>td>input:checked").each(function () {
                if(attr[i]+'[]' == this.name){
                    arr.push(this.value);
                }
            })

            all.push(arr);

        });


        var Cartesian = function(a, b) {
            var ret = [];
            for (var i = 0; i < a.length; i++) {
                for (var j = 0; j < b.length; j++) {
                    ret.push(ft(a[i], b[j]));
                }
            }
            return ret;
        }
        var ft = function(a, b) {
            if (! (a instanceof Array)) a = [a];
            var ret = Array.call(null, a);
            ret.push(b);
            return ret;
        }
        //多个一起做笛卡尔积
        multiCartesian = function(data) {
            var len = data.length;
            if (len == 0) return [];
            else if (len == 1) return data[0];
            else {
                var r = data[0];
                for (var i = 1; i < len; i++) {
                    r = Cartesian(r, data[i]);
                }
                return r;
            }
        }

        var r = multiCartesian(all);

        for (var i = 0; i < r.length; i++) {
            iamlgz.push("("+r[i]+")")
        }

        $.get("{{url('admin/get/sku')}}",{arr:iamlgz},function (msg) {
            $("#sku_table").html(msg)
        })


    });


</script>



