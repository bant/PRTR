@extends('layouts.prtr')
@section('title', '都道府県別集計 | PRTRデータベース by Tウォッチ')
@section('content')
      <!-- #breadcrumbs -->
      <ul id="breadcrumbs">
        <li><a href="{{url('/')}}">PRTR 検索メニュー</a></li>
        <li><a href="{{url('/chemical/search')}}">&gt; 化学物質検索<a></li>
        <li><a href="{{url('/chemical/list')}}">&gt; 化学物質リスト</a></li>
        <li>&gt; 化学物質別都道府県集計</li>
      </ul>
      <!-- /#breadcrumbs -->

      <section>
      <h2>化学物質別届出情報</h2>
        <!-- 化学物質情報 -->
        <section>
          <div class="display-switch">
            <h3>化学物質情報</h3>
            <div class="display">非表示にする</div>
          </div>
          <table id="chemicalTable" class="table table-bordered chemicalTable" summary="化学物質情報">
            <caption>化学物質情報</caption>
            <tbody>
            <tr>
              <th>化学物質名 (別名)</th>
              <td>
                {{$chemical->name}}
                @if (!empty($chemical->alias))
                  ({{$chemical->alias}})
                @else
                  (-)
                @endif
              </td>
            </tr>
            <tr>
              <th>種別 (旧種別)</th>
              <td>
                @if (!empty($chemical->chemical_type->name))
                  {{$chemical->chemical_type->name}}
                @else
                  -
                @endif
                @if (!empty($chemical->old_chemical_type->name))
                  ({{$chemical->old_chemical_type->name}})
                @else
                  (-)
                @endif
              </td>
            </tr>
            <tr>
              <th>化学物質番号 (旧番号)</th>
              <td>
                @if (!empty($chemical->chemical_no))
                  {{$chemical->chemical_no}}
                @else
                  -
                @endif
                @if (!empty($chemical->old_chemical_no))
                  ({{$chemical->old_chemical_no}})
                @else
                  (-)
                @endif              
              </td>
            </tr>
            <tr>
              <th>CAS登録番号</th>
              <td>
                @if (!empty($chemical->cas))
                  {{$chemical->cas}}
                @else
                  -
                @endif
              </td>
            </tr>
            </tbody>
          </table>
        </section>
        <!-- /化学物質情報 -->
        <!-- 届出履歴 -->
        <section>
          <hr class="split">
          <div class="display-switch">
            <h3>届出履歴</h3>
            <div class="display">非表示にする</div>
          </div>
          <table id="reportTable" class="table table-bordered table-striped reportHistory" summary="届出履歴">
            <caption>{{$chemical->name}}
              <span class="plain">({{$chemical->unit->name}})
              <span>
            </caption>
            <thead>
              <tr>
                <th>届出年度</th>
                <th>事業所数</th>
                <th>総排出量合計</th>
                <th>総移動量合計</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($chemical_infos as $chemical_info)                
            <tr>
              <td>{{$chemical_info['YEAR']}}</td>
              <td>{{$chemical_info['COUNT']}}</td>
              <td>{{$chemical_info['TOTAL_SUM_EXHAUST']}}</td>
              <td>{{$chemical_info['TOTAL_SUM_MOVEMENT']}}</td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </section>
        <!-- /届出履歴 -->

        <!-- 届出情報 -->
        <section>
          <hr class="split">
          <h3 class="result">化学物質届出情報</h3>
          <!-- 絞り込みフォーム -->
          {!! Form::open(['url' => "chemical/prefectures", 'method'=>'get', 'id'=>'choose']) !!}
            {!! Form::hidden('id', $chemical->id) !!}
            {!! Form::label('sort', '並び替え') !!}
            {!! Form::select('sort', [ 
                  '1' => '排出量(降順)',
                  '2' => '排出量(昇順)',
                  '3' => '移動量(降順)',
                  '4' => '移動量(昇順)'], 1) !!}
            {!! Form::label('regist_year', '届出年度') !!}
            {!! Form::select('regist_year', $regist_years, 1, ['class' => 'form', 'id' => 'regist_year']) !!}
            {!! Form::submit('検 索', ['class' => 'btn btn-warning']) !!}
          {{ Form::close() }}
          <!-- /絞り込みフォーム -->
          <!-- 化学物質別届出情報 -->
          <table id="resultTable" class="tablesorter-green table-striped table-bordered chemicalReport">
            <caption>{{$chemical->name}}
              <span class="plain">({{$chemical->unit->name}}) | 該当件数: {{$pref_discharges_count}}件
              </span>
            </caption>
            <thead>
              <tr>
                <th>都道府県</th>
                <th>大気<br>[排出]</th>
                <th>水域<br>[排出]</th>
                <th>土壌<br>[排出]</th>
                <th>埋立<br>[排出]</th>
                <th>下水<br>[移動]</th>
                <th>下水以外<br>[移動]</th>
                <th>総排出量</th>
                <th>総移動量</th>
                <th>届出年度</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($pref_discharges as $pref_discharge)       
            <tr>
              <td>{{$pref_discharge['PREF']}}</td>
              <td>{{$pref_discharge['TOTAL_ATMOSPHERE']}}</td>
              <td>{{$pref_discharge['TOTAL_SEA']}}</td>
              <td>{{$pref_discharge['TOTAL_SOIL']}}</td>
              <td>{{$pref_discharge['TOTAL_RECLAIMED']}}</td>
              <td>{{$pref_discharge['TOTAL_SEWER']}}</td>
              <td>{{$pref_discharge['TOTAL_OTHER']}}</td>
              <td>{{$pref_discharge['TOTAL_EXHAUST']}}</td>
              <td>{{$pref_discharge['TOTAL_SUM_MOVEMENT']}}</td>
              <td>{{$pref_discharge['REGIST_YEAR']}}</td>
            </tr>
            @endforeach
            </tbdoy>
          </table>
          <!-- /化学物質別届出情報 -->
        </section>
        <!-- /届出情報 -->


      </section>
  
  <!-- ページネーション -->

  <!-- /ページネーション -->
@endsection
