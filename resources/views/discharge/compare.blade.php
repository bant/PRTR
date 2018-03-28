@extends('layouts.prtr')
@section('title', '事業所比較 | PRTRデータベース by Tウォッチ')
@section('content')
<div id="contents">
  <!-- #breadcrumbs -->
  <ul id="breadcrumbs">
    <li><a href="{{url('/')}}">PRTR 検索メニュー</a></li>
    <li>&gt; 事業所比較</li>
  </ul>
  <!-- /#breadcrumbs -->
  <section>
  <h2>事業所(工場)比較</h2>
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
        <th>{!! Form::label('discharge_pref', '都道府県') !!}</th>
        <td>{!! Form::select('discharge_pref_id', $prefs, 0, ['class' => 'form', 'id' => 'discharge_pref_id']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('discharge_city', '市区町村') !!}</th>
        <td>{!! Form::text('discharge_city', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('discharge_address', '町域') !!}</th>
        <td>{!! Form::text('discharge_address', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('discharge_factory_name', '事業所名') !!}</th>
        <td>{!! Form::text('discharge_factory_name', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('chemical_name', '化学物質名') !!}</th>
        <td>{!! Form::text('chemical_name', null, ['class' => 'form-control']) !!}</td>
      </tr>
      <tr>
        <th>{!! Form::label('regist_year', '届出年度') !!}</th>
        <td>{!! Form::select('regist_year_id', $regist_years, 1, ['class' => 'form', 'id' => 'regist_year_id']) !!}</td>
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
        <caption>該当件数: {{$factory_count}} 件</caption>
        <thead>
          <tr>
          <th>事業者名<br>事業所名</th>
          <th>従業員数</th>
          <th>化学物質名<br>(単位)</th>
          <th>総排出量</th>
          <th>総移動量</th>
          <th>届出年度</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($factories as $factory)            
        <!-- tw_factory is ({{$factory->id}}) -->
          <tr>
            <td>{{$factory->company->name}}<br>{{$factory->name}}</td>
            <td>{{$factory->getAverageEmployee()}}</td>
          <td>
            <a href="/images/pdf/00000-002-006.pdf" rel="prettyPhoto" title="アクリルアミドの詳細PDFはこちら" target="_blank">
              {{$factory->discharge}}
            アクリルアミド</a>
            <br>(kg)
          </td>
          <td>4400</td>
          <td>0</td>
          <td>2010年</td>
          </tr>
        @endforeach
        </tbody>
      </table>
      </section>
      <!-- /工場検索結果 -->
  </section>

  
  <!-- ページネーション -->
  {{ $factories->appends($pagement_params)->links() }}
  <!-- /ページネーション -->
@endsection
