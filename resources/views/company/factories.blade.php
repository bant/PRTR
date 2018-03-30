@extends('layouts.prtr')
@section('title', '事業者リスト | PRTRデータベース by Tウォッチ')
@section('content')
<div id="contents">
  <!-- #breadcrumbs -->
  <ul id="breadcrumbs">
    <li><a href="{{url('/')}}">検索メニュー</a></li>
    <li>&gt; <a href="{{url('/company/search')}}">事業者検索</a></li>
    <li>&gt; <a href="{{url('/company/list')}}">事業者リスト</a></li>
    <li>&gt; 事業所リスト</li>
  </ul>
  <!-- /#breadcrumbs -->

  <section>
    <h2>所属事業所(工場)リスト</h2>
    <!-- 会社情報 -->
    <section>
      <div class="display-switch">
        <h3>事業者(会社)情報</h3>
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
        <td>{{$factories_count}}</td>
      </tr>
      <tr>
          <th>温室効果ガス届出</th>
          <td>
            @if(!empty($prtr_co2))
              <a href="http://wwww.xxx.cne.jp/company?id={{$prtr_co2->co2_company_id}}">温室効果ガスの該当URL</a>
            @else
              なし
            @endif
          </td>
        </tr>
      </tbody>
      </table>
    </section>
    <!-- /会社情報 -->

    <!-- 工場リスト -->
    <section>
      <hr class="split">
      <h3 class="result">検索結果:事業所リスト</h3>
      <table id="resultTable" class="table table-bordered table-striped factoryList" summary="所属工場リスト">
      <caption>該当件数: {{$factories_count}}件</caption>
      <thead>
      <tr>
        <th>事業所名<br>旧事業所名</th>
        <th>業種</th>
        <th>郵便番号<br>所在地</th>
        <th>従業員数</th>
        <th>届出物質数</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($factories as  $factory)
      <!-- tw_factory's id is {{$factory->id}} -->
        <tr>
          <td><a href="/company/factory_report?id={{$factory->id}}">{{$factory->name}}</a><br>({{$factory->getOldName()}})</td>
          <td>{{$factory->getBusinessTypeName()}}</td>
          <td>{{$factory->PostNoConvert()}}<br>{{$factory->pref->name}}{{$factory->city}}{{$factory->address}}</td>
          <td>{{$factory->getAverageEmployee()}}</td>
          <td>{{$factory->getAverageReportCount()}}</td>
        </tr>
      @endforeach
      </tbody>
      </table>
      </section>
      <!-- /工場リスト -->






@endsection
