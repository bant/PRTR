@extends('layouts.prtr')
@section('title', '所属事業所届出情報')
@section('content')
<div id="contents">
  <!-- #breadcrumbs -->
  <ul id="breadcrumbs">
    <li><a href="{{url('/')}}">検索メニュー</a></li>
    <li>&gt; <a href="{{url('/company/search')}}">事業者検索</a></li>
    <li>&gt; <a href="{{url('/company/list')}}">事業者リスト</a></li>
    <li>&gt; <a href="{{url('/company/factories?id=')}}{{$company->id}}">所属事業所リスト</a></li>
    <li>&gt; 所属事業所届出情報</li>
  </ul>
  <!-- /#breadcrumbs -->
  <section>
    <h2>所属事業所届出情報</h2>
    <!-- 会社・工場情報 -->
    <section>
      <div class="display-switch">
        <h3>事業者・事業所情報</h3>
        <div class="display">非表示にする</div>
      </div>
      <table id="companyTable" class="table table-bordered companyTable" summary="会社情報">
      <caption>事業者情報</caption>
      <tbody>
        <tr>
          <th>事業者名<br>(旧事業者名)</th>
          <td>{{$company->name}}<br>{{$company->getOldName()}}</td>
        </tr>
        <tr>
          <th>所在地</th>
          <td>{{$company->PostNoConvert()}}<br>{{$company->pref->name}}{{$company->city}}{{$company->address}}</td>
        </tr>
        <tr>
          <th>事業所数</th>
          <td>{{$company->getFactoryCount()}}</td>
        </tr>
        <tr>
          <th>温室効果ガス届出</th>
          <td>
          @if(!empty($prtr_co2))
              <a href="http://co2.toxwatch.net/company/info?id={{$prtr_co2->co2_company_id}}">{{$company->name}}の温室効果ガス情報はこちら</a>
          @else
              なし
          @endif
          </td>
        </tr>
      </tbody>
      </table>

      <table id="factoryTable" class="table table-bordered companyTable" summary="工場情報">
      <caption>事業所情報</caption>
      <tbody>
        <tr>
          <th>事業所名<br>(旧事業所名)</th>
          <td>{{$factory->name}}<br>{{$factory->getOldName()}}</td>
        </tr>
        <tr>
          <th>所在地</th>
          <td>{{$factory->PostNoConvert()}}<br>{{$factory->pref->name}}{{$factory->city}}{{$factory->address}}</td>
        </tr>
        <tr>
          <th>業種</th>
          <td>{{$factory->getBusinessTypeName()}}</td>
        </tr>
      </tbody>
      </table>
    </section>
    <!-- /会社・工場情報 -->

    <!-- 届出履歴 -->
    <section>
      <hr class="split">
      <div class="display-switch">
        <h3>所属事業所届出履歴</h3>
        <div class="display">非表示にする</div>
      </div>
      <table id="reportTable" class="table table-bordered table-striped reportHistory" summary="届出履歴">
      <caption>{{$company->name}}&nbsp;&nbsp;{{$factory->name}}</caption>
      <thead>
        <tr>
          <th>届出年度</th>
          <th>従業員数</th>
          <th>届出物質数</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($factory_histories as $factory_history)        
        <tr>
          <td>{{$factory_history->regist_year->name}}</td>
          <td>{{$factory_history->employee}}</td>
          <td>{{$factory_history->report_count}}</td>
        </tr>
      @endforeach
      </tbody>
      </table>
    </section>
    <!-- /届出履歴 -->

    <!-- 届出情報 -->
    <section>
      <hr class="split">
      <h3 class="result">所属事業所届出情報</h3>
      <!-- 絞り込みフォーム -->
      {!! Form::open(['url' => 'company/factory_report', 'method'=>'get','id'=>'choose']) !!}
        {!! Form::hidden('id', $factory->id) !!}
        {!! Form::label('chemical_name', '化学物質名') !!}
        {!! Form::text('chemical_name', null) !!}&nbsp;
        {!! Form::label('regist_year', '届出年度') !!}
        {!! Form::select('regist_year', $years, 0, ['class' => 'form', 'id' => 'regist_year']) !!}         
        {!! Form::submit('検 索', ['class' => 'btn btn-warning']) !!}
      {{ Form::close() }}
      <!-- /絞り込みフォーム -->
      <!-- 化学物質届出情報 -->
      <table id="resultTable" class="table-striped table-bordered chemicalReport">
        <caption>該当件数: {{$discharge_count}}件</caption>
        <thead>
          <tr>
            <th>化学物質名<br>[単位]</th>
            <th>大気<br>[排出]</th>
            <th>水域<br>[排出]</th>
            <th>土壌<br>[排出]</th>
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
        <!-- tw_discharge's id is 2854945 -->
            <tr>
              <td>
                @if(!empty($discharge->chemical->pdf))
                  <a href="/images/pdf/{{$discharge->chemical->pdf}}" target=”_blank”rel="prettyPhoto" title="{{$discharge->chemical->name}}の詳細PDFはこちら">{{$discharge->chemical->name}}</a>
                @else 
                  {{$discharge->chemical->name}}
                  <br>
                @endif
                ({{$discharge->chemical->unit->name}})
              </td>
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
        <!-- /化学物質届出情報 -->
     </section>
     <!-- /届出情報 -->
  </section>
  
  <!-- ページネーション -->
    {{ $discharges->appends($pagement_params)->links() }}
  <!-- /ページネーション -->
@endsection
