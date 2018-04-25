@extends('layouts.prtr')
@section('title', '事業者検索 | PRTRデータベース by Tウォッチ')
@section('content')
      <ul id="breadcrumbs">
        <li><a href="{{url('/')}}">検索メニュー</a></li>
        <li>&gt; 事業者検索</li>
      </ul>
      <!-- /#breadcrumbs -->

      <section>
      <h2>事業者検索</h2>
        <section>
        <h3>検索条件</h3>
        <!-- 検索フォーム -->
        {!! Form::open(['url' => 'company/list', 'method'=>'post', 'id'=>'search']) !!}
            <table class="table table-bordered">
            <tbody>
              <tr>
                <th>{!! Form::label('company_name', '事業者名') !!}</th>
                <td>{!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('company_old_name', '旧事業者名') !!}</th>
                <td>{!! Form::text('company_old_name', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('company_pref', '都道府県') !!}</th>
                <td>{!! Form::select('company_pref_id', $company_prefs, 0, ['class' => 'form', 'id' => 'company_pref_id']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('company_city', '市区町村') !!}</th>
                <td>{!! Form::text('company_city', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('company_address', '町域') !!}</th>
                <td>{!! Form::text('company_address', null, ['class' => 'form-control', 'placeholder' => '一部でも検索できます。']) !!}</td>
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
