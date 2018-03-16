@extends('layouts.prtr')

@section('title', '事業者リスト | PRTRデータベース by Tウォッチ')

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
  <h2>事業者(会社)リスト</h2>
  <!-- 検索フォーム -->
  <section>
  	<div class="display-switch">
      <h3>検索条件</h3>
      <div class="display">非表示にする</div>
    </div>

    {!! Form::open(['url' => 'factory/list', 'id'=>'search']) !!}
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th>{!! Form::label('name', '事業者名') !!}</th>
            <td>{!! Form::text('name', null, ['class' => 'form-control']) !!}</td>
          </tr>
          <tr>
            <th>{!! Form::label('business_type', '業種') !!}</th>
            <td>{!! Form::select('business_type_id', $business_types, 0, ['class' => 'form', 'id' => 'pref_id']) !!}</td>
          </tr>
          <tr>
            <th>{!! Form::label('pref', '都道府県') !!}</th>
            <td>{!! Form::select('pref_id', $prefs, 0, ['class' => 'form', 'id' => 'company_pref_id']) !!}</td>
          </tr>
          <tr>
            <th>{!! Form::label('city', '市区町村') !!}</th>
            <td>{!! Form::text('city', null, ['class' => 'form-control']) !!}</td>
          </tr>
          <tr>
            <th>{!! Form::label('address', '町域') !!}</th>
            <td>{!! Form::text('address', null, ['class' => 'form-control']) !!}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" class="center">
            {!! Form::submit('検 索', ['class' => 'btn btn-warning']) !!}
            </td>
          </tr>
          </tfoot>
      </table>
    {{ Form::close() }}
    </section>
    <!-- /検索フォーム -->

    <!-- 検索結果 -->
    <section>
    <hr class="split">
    <h3 class="result">検索結果:事業所リスト</h3>
      <table id="resultTable" class="table table-striped table-bordered factoryList">
        <caption>該当件数: {{$all_count}}件</caption>
        <thead>
          <tr>
            <th>事業者名<br>
                事業所名(旧事業所名)</th>
            <th>業種</th>
            <th>所在地</th>
            <th>従業員数</th>
            <th>届出物質数</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($factories as $factory)            
            <!-- tw_factory id is ({{$factory->id}}) -->
            <tr>
              <td>{{$factory->company->name}}<br>
              {{$factory->name}}</a></td>
              <td>{{$factory->factory_business_type->business_type->name}}</td>
              <td>{{$factory->PostNoConvert()}}<br>
              {{$factory->pref->name}}{{$factory->address}}</td>
              <td>{{$factory->getAverageEmployee()}}</td>
              <td><a href="/factory/report/{{$factory->id}}">{{$factory->getAverageReportCount()}}</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
  <!-- /検索結果 -->
  </div><!--- /#contents --->
  
  <!-- ページネーション -->
    {{ $factories->appends($pagement_params)->links() }}
  <!-- /ページネーション -->
@endsection
