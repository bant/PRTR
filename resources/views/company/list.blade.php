@extends('layouts.prtr')
@section('title', '事業者リスト')
@section('content')
<div id="contents">
  <!-- /#breadcrumbs -->
  <ul id="breadcrumbs">
    <li><a href="{{url('/')}}">検索メニュー</a></li>
    <li>&gt; <a href="{{url('/company/search')}}">事業者検索</a></li>
    <li>&gt; 事業者リスト</li>
  </ul>
  <!-- /#breadcrumbs -->
  <section>
  <h2>事業者リスト</h2>
  </section>
  <!-- /検索フォーム -->
  {!! Form::open(['url' => 'company/list', 'method'=>'get','id'=>'search']) !!}
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th>{!! Form::label('company_name', '事業者名') !!}</th>
        <td>{!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('company_old_name', '旧事業者名') !!}</th>
        <td>{!! Form::text('company_old_name', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('company_pref', '都道府県') !!}</th>
        <td>{!! Form::select('company_pref_id', $company_prefs, 0, ['class' => 'form', 'id' => 'company_pref_id']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('company_city', '市区町村') !!}</th>
        <td>{!! Form::text('company_city', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('company_address', '町域') !!}</th>
        <td>{!! Form::text('company_address', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="center">{!! Form::submit('検 索', ['class' => 'btn btn-warning']) !!}</td>
      </tr>
    </tfoot>
  </table>
  {{ Form::close() }}
  <!-- /検索フォーム -->
  </section>
  
  <!-- 検索結果 -->
  <section>
    <hr class="split">
    <h3 class="result">検索結果:事業者リスト</h3>
    <table id="resultTable" class="table table-striped table-bordered factoryList">
      <caption>該当件数: {{$company_count}}件</caption>
      <thead>
        <tr>
          <th>事業者名<br>(旧事業者名)</th>
          <th>所在地</th>
          <th>事業所数</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($companies as $company)            
        <!-- tw_company is ({{$company->id}}) -->
        <tr>
          <td><a href="/company/factories?id={{$company->id}}" title="{{$company->name}}の所属事業所リストはこちら">{{$company->name}}</a>
          <br>({{$company->getOldName()}})</td>
          <td>{{$company->PostNoConvert()}}<br>
            {{$company->pref->name}}{{$company->city}}{{$company->address}}</td>
          <td>{{$company->getFactoryCount()}}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  <!-- /検索結果 -->
  </div><!--- /#contents --->
  
  <!-- ページネーション -->
    {{ $companies->appends($pagement_params)->links() }}
  <!-- /ページネーション -->
@endsection
