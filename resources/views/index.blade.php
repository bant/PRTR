@extends('layouts.prtr')
@section('title', '検索メニュー | PRTRデータベース by Tウォッチ')
@section('content')
<div id="contents">
<!--- #contents --->
      <ul id="breadcrumbs">
        <li>検索メニュー</li>
      </ul>
      <!-- /#breadcrumbs -->
      <section>
        <h2>検索メニュー</h2>
        <div id="menu">
          <a href="{{url('factory/search')}}">
            <button class="btn btn-warning btn-block btn-lg">
              <i class="fa fa-industry" aria-hidden="true"></i>事業所(工場)検索
            </button>
          </a>
          <p>事業所(工場)名・住所・業種から検索します。</p>
          <a href="{{url('company/search')}}">
            <button class="btn btn-warning btn-block btn-lg">
              <i class="fa fa-building" aria-hidden="true"></i>事業者(会社)検索
            </button>
          </a>
          <p>事業者(会社)名・住所から検索します。</p>
          <a href="{{url('chemical/search')}}">
            <button class="btn btn-warning btn-block btn-lg">
              <i class="fa fa-flask" aria-hidden="true"></i>化学物質検索
            </button>
          </a>
          <p>化学物質名・種別・化学物質番号・CAS登録番号から検索します。</p>
          <a href="{{url('discharge/search')}}">
            <button class="btn btn-warning btn-block btn-lg">
              <i class="fa fa-balance-scale" aria-hidden="true"></i>事業所(工場)比較
            </button>
          </a>
          <p>地域・事業所・化学物質を限定し、事業所(工場)ごとの排出量・移動量を比較します。</p>
        </div>
        <div id="caution">PRTRデータベースは、国のPRTR制度に基づき、全国の事業所が届出した有害化学物質の排出データをTウォッチがデータベース化したものです。</div>
      </section>
    </div>
<!--- /#contents --->
@endsection

