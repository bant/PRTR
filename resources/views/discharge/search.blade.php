@extends('layouts.prtr')
@section('title', '事業所比較 | PRTRデータベース by Tウォッチ')
@section('content')
  <!-- #breadcrumbs -->
  <ul id="breadcrumbs">
    <li><a href="{{url('/')}}">PRTR 検索メニュー</a></li>
    <li>&gt; 事業所比較</li>
  </ul>
  <!-- /#breadcrumbs -->
  <section>
  <h2>事業所(工場)比較</h2>
    <section>
    <h3>比較条件</h3>
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
  </section>
 </section>
@endsection
