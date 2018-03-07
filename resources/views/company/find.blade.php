@extends('layouts.prtr')
@section('title', '事業者検索 | PRTRデータベース by Tウォッチ')
@section('content')
      <ul id="breadcrumbs">
        <li><a href="/">PRTR 検索メニュー</a></li>
        <li>&gt; 事業者検索</li>
      </ul>
      <!-- /#breadcrumbs -->

      <section>
      <h2>事業者(会社)検索</h2>
        <section>
        <h3>検索条件</h3>
        <!-- 検索フォーム -->
        {!! Form::open(['id'=>'search']) !!}
            <table class="table table-bordered">
            <tbody>
              <tr>
                <th>{!! Form::label('company_name', '事業者名') !!}</th>
                <td>{!! Form::text('company_name', null, ['class' => 'form-control']) !!}</td>
              </tr>
<!--
              <tr>
                <th>{!! Form::label('is_old_name', '旧事業者名も検索に含める') !!}</label></th>
                <td>{!! Form::checkbox('is_old_name') !!}</td>
              </tr>
-->
              <tr>
                <th>{!! Form::label('company_pref', '都道府県') !!}</th>
                <td>{!! Form::select('company_pref_id', $prefs, 0, ['class' => 'form', 'id' => 'pref_id']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('company_city', '市区町村') !!}</th>
                <td>{!! Form::text('company_city', null, ['class' => 'form-control']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('company_address', '町域') !!}</th>
                <td>{!! Form::text('company_address', null, ['class' => 'form-control']) !!}</td>
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
