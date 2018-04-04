@extends('layouts.prtr')
@section('title', '化学物質リスト | PRTRデータベース by Tウォッチ')
@section('content')
      <!-- #breadcrumbs -->
      <ul id="breadcrumbs">
        <li><a href="{{url('/')}}">検索メニュー</a></li>
        <li>&gt; <a href="{{url('/chemical/search')}}">化学物質検索</a></li>
        <li>&gt; 化学物質リスト</li>
      </ul>
      <!-- /#breadcrumbs -->

      <section>
        <h2>化学物質リスト</h2>
        <section>
          <div class="display-switch">
            <h3>検索条件</h3>
            <div class="display">非表示にする</div>
          </div>
          <!-- 検索フォーム -->
          <!-- 検索フォーム -->
          {!! Form::open(['url' => 'chemical/list', 'id'=>'search']) !!}
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th>{!! Form::label('name', '化学物質名') !!}</th>
                  <td>{!! Form::text('name', null, ['class' => 'form-control']) !!}</td>
                </tr>
                <tr>
                  <th>{!! Form::label('chemical_type', '種別') !!}</th>
                  <td>{!! Form::select('chemical_type_id', $chemical_types, 0, ['class' => 'form', 'id' => 'chemical_type_id']) !!}</td>
                </tr>
                <tr>
                  <th>{!! Form::label('old_chemical_type', '旧種別') !!}</th>
                  <td>{!! Form::select('old_chemical_type_id', $chemical_types, 0, ['class' => 'form', 'id' => 'chemical_type_id']) !!}</td>
                </tr>
                <tr>
                @if(!empty($errors->first('chemical_no')))
                  <th class ="error">{!! Form::label('chemical_no', '化学物質番号') !!}</th>
                  <td class ="error">{{$errors->first('chemical_no')}}{!! Form::text('chemical_no', null, ['class' => 'form-control']) !!}</td>
                @else 
                  <th>{!! Form::label('chemical_no', '化学物質番号') !!}</th>
                  <td>{!! Form::text('chemical_no', null, ['class' => 'form-control']) !!}</td>
                @endif
                </tr>
                <tr>
                @if(!empty($errors->first('old_chemical_no')))
                  <th class ="error">{!! Form::label('old_chemical_no', '旧化学物質番号') !!}</th>
                  <td class ="error">{{$errors->first('old_chemical_no')}}{!! Form::text('old_chemical_no', null, ['class' => 'form-control']) !!}</td>
                @else 
                  <th>{!! Form::label('old_chemical_no', '旧化学物質番号') !!}</th>
                  <td>{!! Form::text('old_chemical_no', null, ['class' => 'form-control']) !!}</td>
                @endif
                </tr>
                <tr>
                @if(!empty($errors->first('cas')))
                  <th class ="error">{!! Form::label('cas', 'CAS登録番号') !!}</th>
                  <td class ="error">{{$errors->first('cas')}}{!! Form::text('cas', null, ['class' => 'form-control']) !!}</td>
                @else 
                  <th>{!! Form::label('cas', 'CAS登録番号') !!}</th>
                  <td>{!! Form::text('cas', null, ['class' => 'form-control']) !!}</td>
                @endif
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" class="center">
                    {!! Form::submit('検 索', ['class' => 'btn btn-warning']) !!}
                  </td>
                </tr>
                <tr>
              </tfoot>
            </table>
          </form>
          <!-- /検索フォーム -->
        </section>


        <!-- 検索結果 -->
        <section>
          <hr class="split">
          <h3 class="result">検索結果:化学物質リスト</h3>
          <table id="resultTable" class="table table-striped table-bordered chemicalList">
            <caption>該当件数: {{$all_count}}件</caption>
            <thead>
              <tr>
                <th>化学物質名<br>(別名)</th>
                <th>種別<br>(旧種別)</th>
                <th>化学物質番号<br>(旧番号)</th>
                <th>CAS登録番号</th>
                <th>平均<br>届出事業所数</th>
                <th>都道府県別<br>集計</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($chemicals as $chemical)  
            <!-- tw_chemical id is {{$chemical->id}} -->
              <tr>
                <td>
                  @if(!empty($chemical->pdf))
                    <a href="/images/pdf/{{$chemical->pdf}}" target=”_blank”rel="prettyPhoto" title="{{$chemical->name}}の詳細PDFはこちら">{{$chemical->name}}</a>
                  @else 
                    {{$chemical->name}}
                  @endif
                  <br>
                  @if(!empty($chemical->alias))
                    ({{$chemical->alias}})
                  @else 
                    (-)
                  @endif                    
                </td>
                <td>
                  @if(!empty($chemical->chemical_type->name))
                    {{$chemical->chemical_type->name}}
                  @else 
                    -
                  @endif
                  <br>        
                  @if(!empty($chemical->old_chemical_type->name))
                    ({{$chemical->old_chemical_type->name}})
                  @else 
                    (-)
                  @endif                  
                </td>
                <td>{{$chemical->chemical_no}}
                  <br>
                  @if(!empty($chemical->old_chemical_no))
                    ({{$chemical->old_chemical_no}})
                  @else 
                    (-)
                  @endif                      
                </td>
                <td>
                @if(!empty($chemical->cas))
                  {{$chemical->cas}}
                @else 
                  -
                @endif 
                </td>
                <td>
                  <a href="/chemical/factories?id={{$chemical->id}}&sort=1" title="工場別へ">{{$chemical->countFactory()}}</a>
                </td>
                <td>
                  <a href="/chemical/prefectures?id={{$chemical->id}}&sort=1" title="都道府県別集計">都道府県別へ
                  </a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </section>
        <!-- /検索結果 -->

  
  <!-- ページネーション -->
  {{ $chemicals->appends($pagement_params)->links() }}
  <!-- /ページネーション -->
@endsection

@section('add_javascript')
<script type="text/javascript">
//<![CDATA[
  <script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
	</script>
//]]>
</script>
@endsection