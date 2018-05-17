@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('currency::currencysymbols.title.currencysymbols') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('currency::currencysymbols.title.currencysymbols') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.currency.currencysymbol.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('currency::currencysymbols.button.create currencysymbol') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <?php
                $defaultCurrency =  @setting('currency::default-currency');
                $allowed_currencies = json_decode( @setting('currency::allowed-currencies') );

                ?>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover" id="table">
                            <thead>
                            <tr>
                                <th>{{  trans('currency::currencies.title.currencies')  }}</th>
                                <th>{{  trans('currency::currencysymbols.title.currencysymbols')  }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($allowed_currencies)): ?>
                            <?php foreach ($allowed_currencies as $currencysymbol): ?>
                            <tr>
                                <td>{{$currencysymbol}} </td>
                                <td> sdf </td>
                                <td>
                                    <button data-currency="{{  $currencysymbol  }}" class='edit-btn btn btn-sm btn-flat glyphicon glyphicon-edit' type='button'>编辑</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('currency::currencysymbols.title.create currencysymbol') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.currency.currencysymbol.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
           var table =  $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });


            $("#table tbody").on("click",".edit-btn",function(){
                var tds=$(this).parents("tr").children();
                $.each(tds, function(i,val){
                    var jqob=$(val);
                    if(i < 1 || jqob.has('button').length ){return true;}//跳过第1项 序号,按钮
                    var txt=jqob.text();
                    var put=$("<input type='text'>");
                    put.val(txt);
                    jqob.html(put);
                });
                $(this).html("保存");
                $(this).toggleClass("edit-btn glyphicon-edit");
                $(this).toggleClass("save-btn glyphicon-ok");
            });

            $("#table tbody").on("click",".save-btn",function(){
                var row= ($(this).parents("tr"));
                var tds=$(this).parents("tr").children();
                $.each(tds, function(i,val){
                    var jqob=$(val);
                    console.log(jqob);
                    //把input变为字符串
                    if(!jqob.has('button').length){
                        var txt=jqob.children("input").val();
                        jqob.html(txt);
                        (jqob).data(txt);//修改DataTables对象的数据
                    }
                });
                var data=row.data();

                $.ajax({
                    "url":route('admin.currency.currency.update',{'currency': 1}),
                    "data":data,
                    "type":"post",
                    "error":function(){
                        alert("服务器未正常响应，请重试");
                    },
                    "success":function(response){
                        alert(response);
                    }
                });
                $(this).html("编辑");
                $(this).toggleClass("edit-btn  glyphicon-edit");
                $(this).toggleClass("save-btn  glyphicon-ok");
            });
        });
    </script>
@endpush
