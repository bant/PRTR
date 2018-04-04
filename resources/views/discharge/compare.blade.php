@extends('layouts.prtr')
@section('title', '事業所比較 | PRTRデータベース by Tウォッチ')
@section('content')
<div id="contents">
  <!-- #breadcrumbs -->
  <ul id="breadcrumbs">
    <li><a href="{{url('/')}}">PRTR 検索メニュー</a></li>
    <li>&gt; <a href="{{url('/discharge/search')}}">事業所比較検索</a></li>
    <li>&gt; 比較結果リスト</li>
  </ul>
  <!-- /#breadcrumbs -->
  <section>
  <h2>事業所比較</h2>
    <section>
    <div class="display-switch">
      <h3>比較条件</h3>
      <div class="display">非表示にする</div>
    </div>
    <!-- 検索フォーム -->
    {!! Form::open(['url' => 'discharge/compare', 'id'=>'search']) !!}
      <table class="table table-bordered">
      <tbody>
      <tr>
        <th>{!! Form::label('factory_pref', '都道府県') !!}</th>
        <td>{!! Form::select('factory_pref_id', $prefs, 0, ['class' => 'form', 'id' => 'factory_pref_id']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('factory_city', '市区町村') !!}</th>
        <td>{!! Form::text('factory_city', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('factory_address', '町域') !!}</th>
        <td>{!! Form::text('factory_address', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('factory_name1', '事業所名(その1)') !!}</th>
        <td>{!! Form::text('factory_name1', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('factory_name2', '事業所名(その2)') !!}</th>
        <td>{!! Form::text('factory_name2', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('chemical_name', '化学物質名') !!}</th>
        <td>{!! Form::text('chemical_name', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('regist_year', '届出年度') !!}</th>
        <td>{!! Form::select('regist_year', $regist_years, 1, ['class' => 'form', 'id' => 'regist_year']) !!}</td>
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
    <!-- /検索フォーム -->
    <!-- 工場検索結果 -->
      <section>
      <hr class="split">
      <h3 class="result">比較結果リスト</h3>
      <table id="resultTable" class="table table-striped table-bordered compareList">
        <caption>該当件数: {{$discharge_count}} 件</caption>
        <thead>
          <tr>
          <th>事業者名<br>事業所名</th>
          <th>住所</th>
          <th>化学物質名<br>(単位)</th>
          <th>総排出量</th>
          <th>総移動量</th>
          <th>届出年度</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($discharges as $discharge)            
        <!-- tw_discharge is ({{$discharge->id}}) -->
          <tr>
            <td>
              {{$discharge->factory->company->name}}<br>{{$discharge->factory->name}}</td>
            <td>{{$discharge->factory->PostNoConvert()}}<br>{{$discharge->factory->pref->name}}{{$discharge->factory->city}}{{$discharge->factory->address}}</td>
          <td>
            <a href="/images/pdf/{{$discharge->chemical->pdf}}" rel="prettyPhoto" title="{{$discharge->chemical->name}}の詳細PDFはこちら" target="_blank">
              {{$discharge->chemical->name}}</a>
            <br>({{$discharge->chemical->unit->name}})
          </td>
          <td>{{$discharge->sum_exhaust}}</td>
          <td>{{$discharge->sum_movement}}</td>
          <td>{{$discharge->report_regist_year_id}}年</td>
          </tr>
        @endforeach
        </tbody>
      </table>
      </section>
      <!-- /工場検索結果 -->
  </section>

  
  <!-- ページネーション -->
  {{ $discharges->appends($pagement_params)->links() }}
  <!-- /ページネーション -->
@endsection
