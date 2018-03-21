@extends('layouts.prtr')
@section('title', '化学物質別届出情報 | PRTRデータベース by Tウォッチ')
@section('content')
      <!-- #breadcrumbs -->
      <ul id="breadcrumbs">
        <li><a href="{{url('/')}}">PRTR 検索メニュー</a></li>
        <li><a href="{{url('/chemical/search')}}">&gt; 化学物質検索<a></li>
        <li><a href="{{url('/chemical/list')}}">&gt; 化学物質リスト</a></li>
        <li>&gt; 化学物質別届出情報</li>
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
            @foreach ($discharges as $discharge)                
            <tr>
              <td>{{$discharge->regist_year}}</td>
              <td>18</td>
              <td>173</td>
              <td>180</td>
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
          <form action="/report/ListByChemicalFactory" method="post" id="choose">
            <label for="sort">並び替え</label>
            <select name="sort" id="sort">
              <option value="" selected="selected">並び順の選択</option>
              <option value="EXHAUST_DESC">排出量(降順)</option>
              <option value="EXHAUST_ASC">排出量(昇順)</option>
              <option value="MOVEMENT_DESC">移動量(降順)</option>
              <option value="MOVEMENT_ASC">移動量(昇順)</option>
            </select>
            <label>届出年度</label>
            <select name="year_id" id="year_id">
              <option value="">全年度</option>
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
            </select>
            <input name="id" id="id" value="94404" type="hidden">&nbsp; 
            <input value="絞り込み" type="submit">
          </form>
          <!-- /絞り込みフォーム -->
          <!-- 化学物質別届出情報 -->
          <table id="resultTable" class="tablesorter-green table-striped table-bordered chemicalReport">
            <caption>石綿 
              <span class="plain">(kg) | 該当件数: 187件
              </span>
            </caption>
            <thead>
              <tr>
                <th>事業者名<br>事業所名(都道府県)</th>
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
            <tr>
              <td>三笠市
                <br>みどりが丘環境センター (北海道)
              </td>
              <td>1.2</td>
              <td>2</td>
              <td>0</td>
              <td>0</td>
              <td>1</td>
              <td>6</td>
              <td>3.2</td>
              <td>7</td>
              <td>淀川へ排出。
                <br>淀川下水処理場へ移動。
              </td>
              <td>2014年</td>
            </tr>
            <tr>
              <td>浦臼町
                <br>浦臼町一般廃棄物最終処分場 (北海道)
              </td>
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
            <tr>
              <td>○○○
                <br>▽▽▽(青森県)
              </td>
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
            <tr>
              <td>□□□
                </br>◆◆◆(岩手県)
              </td>
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
            <tr>
              <td>△△△
                <br>■■■(秋田県)
              </td>
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
            <tr>
              <td>▲▲▲
                <br>●●●(福島県)
              </td>
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
            </tbdoy>
          </table>
          <!-- /化学物質別届出情報 -->
        </section>
        <!-- /届出情報 -->


      </section>
  
  <!-- ページネーション -->

  <!-- /ページネーション -->
@endsection