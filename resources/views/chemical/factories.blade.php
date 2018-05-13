@extends('layouts.prtr')
@section('title', '化学物質別事業所別届出情報')
@section('content')
      <!-- #breadcrumbs -->
      <ul id="breadcrumbs">
        <li><a href="{{url('/')}}">検索メニュー</a></li>
        <li><a href="{{url('/chemical/search')}}">&gt; 化学物質検索<a></li>
        <li><a href="{{url('/chemical/list')}}">&gt; 化学物質リスト</a></li>
        <li>&gt; 化学物質別事業所別情報</li>
      </ul>
      <!-- /#breadcrumbs -->

      <section>
      <h2>化学物質別事業所別届出情報</h2>
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
            <h3>化学物質別届出集計</h3>
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
          <h3 class="result">化学物質別事業所別届出情報</h3>
          <!-- 絞り込みフォーム -->
          {!! Form::open(['url' => "chemical/factories", 'method'=>'get', 'id'=>'choose']) !!}
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
          <table id="resultTable" class="table-striped table-bordered chemicalReport">
            <caption>{{$chemical->name}}
              <span class="plain">(({{$chemical->unit->name}})) | 該当件数: {{$discharge_count}}件
              </span>
            </caption>
            <thead>
              <tr>
                <th>事業者名<br>事業所名(都道府県)</th>
                <th class="tablesorter-header">大気<br>[排出]</th>
                <th class="tablesorter-header">水域<br>[排出]</th>
                <th class="tablesorter-header">土壌<br>[排出]</th>
                <th>埋立<br>[排出]</th>
                <th>下水<br>[移動]</th>
                <th>下水以外<br>[移動]</th>
                <th>総排出量</th>
                <th>総移動量</th>
                <th>備考</th>
                <th>届出年度</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($discharges as $discharge)       
            <tr>
              <td>{{$discharge->factory->company->name}}<br>{{$discharge->factory->name}} ({{$discharge->factory->pref->name}})</td>
              <td>{{$discharge->atmosphere}}</td>
              <td>{{$discharge->sea}}</td>
              <td>{{$discharge->soil}}</td>
              <td>{{$discharge->reclaimed}}</td>
              <td>{{$discharge->sewer}}</td>
              <td>{{$discharge->other}}</td>
              <td>{{$discharge->sum_exhaust}}</td>
              <td>{{$discharge->sum_movement}}</td>
              <td>
                @if(!empty($discharge->area_name))
                  河川・海域エリアは、{{$discharge->area_name}}
                @endif
              </td>
              <td>{{$discharge->regist_year->name}}</td>
            </tr>
            @endforeach
            </tbdoy>
          </table>
          <!-- /化学物質別届出情報 -->
        </section>
        <!-- /届出情報 -->


      </section>
  
  <!-- ページネーション -->
  {{ $discharges->appends($pagement_params)->links() }}
  <!-- /ページネーション -->
@endsection
