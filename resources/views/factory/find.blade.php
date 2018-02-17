@extends('layouts.prtr')

@section('title', '事業所検索 | PRTRデータベース by Tウォッチ')

@section('content')
      <ul id="breadcrumbs">
        <li><a href="/">PRTR 検索メニュー</a></li>
        <li>&gt; 事業所検索</li>
      </ul>
      <!-- /#breadcrumbs -->

      <section>
      <h2>事業所(工場)検索</h2>
        <section>
        <h3>検索条件</h3>
        <!-- 検索フォーム -->
        {!! Form::open(['id'=>'search']) !!}
            <table class="table table-bordered">
            <tbody>
              <tr>
                <th>{!! Form::label('name', '事業所名') !!}</th>
                <td>{!! Form::text('name', null, ['class' => 'form-control']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('is_old_name', '旧事業所名も検索に含める') !!}</label></th>
                <td>{!! Form::checkbox('is_old_name') !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('business_type', '業種') !!}</th>
                <td>{!! Form::select('business_type_id', $business_types, 0, ['class' => 'form', 'id' => 'pref_id']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('pref', '都道府県') !!}</th>
                <td>{!! Form::select('pref_id', $prefs, 0, ['class' => 'form', 'id' => 'pref_id']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('city', '市区町村') !!}</th>
                <td>{!! Form::text('city', null, ['class' => 'form-control']) !!}</td>
              </tr>
              <tr>
                <th>{!! Form::label('address', '町域') !!}</th>
                <td>{!! Form::text('address', null, ['class' => 'form-control']) !!}</td>
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
