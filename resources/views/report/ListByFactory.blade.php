@extends('layouts.prtr')

@section('title', '化学物質届出情報 | PRTRデータベース by Tウォッチ')

@section('content')
<div id="contents">
  <!-- /#breadcrumbs -->
  <ul id="breadcrumbs">
    <li><a href="/">検索メニュー</a></li>
    <li>&gt; <a href="/factory/search">事業所検索</a></li>
    <li>&gt; <a href="/factory/list">事業所リスト</a></li>
    <li>&gt; 届出情報</li>
  </ul>
  <!-- /#breadcrumbs -->
  <section>
    <h2>届出情報</h2>
    <!-- 会社・工場情報 -->
    <section>
      <div class="display-switch">
        <h3>事業者(会社)・事業所(工場)情報</h3>
        <div class="display">非表示にする</div>
      </div>

      <table id="companyTable" class="table table-bordered companyTable" summary="会社情報">
      <caption>事業者情報</caption>
      <tbody>
        <tr>
          <th>事業者名<br>(旧事業者名)</th>
          <td>{{$factory->company->name}}</td>
        </tr>
        <tr>
          <th>所在地</th>
          <td>{{$factory->company->PostNoConvert()}}<br>
              {{$factory->company->pref->name}}{{$factory->company->address}}</td>
        </tr>
        <tr>
          <th>事業所数</th>
          <td>{{$factory_count}}</td>
        </tr>
        <tr>
          <th>温室効果ガス届出</th>
          <td>urlを記載/ない場合は「なし」</td>
        </tr>
      </tbody>
      </table>

      <table id="factoryTable" class="table table-bordered companyTable" summary="工場情報">
      <caption>事業所情報</caption>
      <tbody>
        <tr>
          <th>事業所名<br>(旧事業所名)</th>
          <td>{{$factory->name}}</td>
        </tr>
        <tr>
          <th>所在地</th>
          <td>{{$factory->PostNoConvert()}}<br>
              {{$factory->pref->name}}{{$factory->address}}</td>
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
        <h3>届出履歴</h3>
          <div class="display">非表示にする</div>
        </div>
        <table id="reportTable" class="table table-bordered table-striped reportHistory" summary="届出履歴">
          <caption>{{$factory->company->name}}&emsp;{{$factory->name}}</caption>
          <thead>
            <tr>
              <th>届出年度</th>
              <th>従業員数</th>
              <th>届出物質数</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($factory_histories as  $factory_history)
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
        <h3 class="result">化学物質届出情報</h3>
        <!-- 絞り込みフォーム -->
        <form action="/report/ListByCompany" method="post" id="choose">
          <label for="chemical_name">化学物質名</label>
          <input name="chemical_name" id="chemical_name" value="" type="text">&nbsp;
          <label>届出年度</label>
          <select name="year_id" id="year_id"><option value="">全年度</option>
            <option value="2014">2014年</option>
            <option value="2013">2013年</option>
            <option value="2012">2012年</option>
            <option value="2011">2011年</option>
            <option value="2010">2010年</option>
            <option value="2009">2009年</option>
            <option value="2008">2008年</option>
            <option value="2007">2007年</option>
            <option value="2006">2006年</option>
            <option value="2005">2005年</option>
            <option value="2004">2004年</option>
            <option value="2003">2003年</option>
            <option value="2002">2002年</option>
            <option value="2001">2001年</option>
          </select><input name="id" id="id" value="94404" type="hidden">&nbsp;
          <input value="絞り込み" type="submit">
        </form>
        <!-- /絞り込みフォーム -->
        
        
        <!-- 化学物質届出情報 -->
        <table id="resultTable" class="tablesorter-green table-striped table-bordered chemicalReport">
          <caption>該当件数: 187件</caption>
          <thead>
            <tr>
              <th>化学物質名<br>
              [単位]</th>
              <th>大気<br>
              [排出]</th>
              <th>水域<br>
              [排出]</th>
              <th>土壌<br>
              [排出]</th>
              <th>埋立<br>
              [排出]</th>
              <th>下水<br>
              [移動]</th>
              <th>下水以外<br>
              [移動]</th>
              <th>総排出量</th>
              <th>総移動量</th>
              <th>備考</th>
              <th>届出年度</th>
            </tr>
         </thead>
        <tbody>
         @foreach ($discharges as  $discharge)
        <!-- tw_discharge's id is {{$discharge->id}} -->
        <tr>
             <td>
              <a href="/images/pdf/00000-179-006.jpg" rel="prettyPhoto" title="ダイオキシン類の詳細PDFはこちら">
          ダイオキシン類</a><br>
          (mg-TEQ)  {{$discharge->chemical_id}} </td>
             <td>{{$discharge->atmosphere}}</td>
             <td>{{$discharge->sea}}</td>
             <td>0</td>
             <td>0</td>
             <td>1</td>
             <td>6</td>
             <td>3.2</td>
             <td>7</td>
             <td>淀川へ排出。<br>
             淀川下水処理場へ移動。</td>
             <td>2014年</td>
        </tr>


        <!--/ tw_discharge's id is {{$discharge->id}} -->
         @endforeach


         <!-- tw_discharge's id is 2854945 -->

         <!--/ tw_discharge'id is 2854945 -->
         <!-- tw_discharge's id is 2854956 -->
           <tr>
             <td>メチルナフタレン<br>
             (kg)</td>
             <td>59</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>40</td>
             <td>59</td>
             <td>40</td>
             <td>焼却・溶融で処理。</td>
             <td>2014年</td>
           </tr>
         <!--/ tw_discharge'id is 2854956 -->
         <!-- tw_discharge's id is 2854939 -->
           <tr>
             <td>
              <a href="/images/pdf/00000-003-006.jpg" rel="prettyPhoto" title="アクリル酸及びその水溶性塩の詳細PDFはこちら">
          アクリル酸及びその水溶性塩</a><br>
(kg)</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>6300</td>
             <td>0</td>
             <td>0</td>
             <td>6300</td>
             <td>汚泥あり。</td>
             <td>2014年</td>
           </tr>
         <!--/ tw_discharge'id is 2854939 -->
         <!-- tw_discharge's id is 2854940 -->
           <tr>
             <td>
                <a href="/images/pdf/00000-011-006.jpg" rel="prettyPhoto" title="アセトアルデヒドの詳細PDFはこちら">
          アセトアルデヒド</a></br>
             (kg)</td>
             <td>130</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>130</td>
             <td>0</td>
             <td></td>
             <td>2014年</td>
           </tr>
         <!--/ tw_discharge'id is 2854940 -->
         <!-- tw_discharge's id is 2854941 -->
           <tr>
             <td>
                <a href="/images/pdf/00000-085-006.jpg" rel="prettyPhoto" title="クロロジフルオロメタンの詳細PDFはこちら">
          クロロジフルオロメタン</a><br>
(kg)</td>
             <td>1600</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>1600</td>
             <td>0</td>
             <td></td>
             <td>2014年</td>
           </tr>
         <!--/ tw_discharge'id is 2854941 -->
         <!-- tw_discharge's id is 2854942 -->
           <tr>
             <td>
                <a href="/images/pdf/00000-124-006.jpg" rel="prettyPhoto" title="２，２－ジクロロ－１，１，１－トリフルオロエタンの詳細PDFはこちら">
          ２，２－ジクロロ－１，..      </a><br>
(kg)</td>
             <td>450</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>0</td>
             <td>450</td>
             <td>0</td>
             <td></td>
             <td>2014年</td>
           </tr>
         <!--/ tw_discharge'id is 2854942 -->
         </tbdoy>
       </table>
        <!-- /化学物質届出情報 -->
  </section>
  <!-- /届出情報 -->


  </section>


</div><!--- /#contents --->
@endsection

