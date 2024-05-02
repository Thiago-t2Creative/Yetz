
@extends('layout.site')

@section('content')

    @if($errors->any())
        <script>
            contentToastMsg = "{{ $errors->first() }}"
        </script>
    @endif

    <div class="row">

        <form action="{{ route('jogadores.save') }}" method="post">

            {{ csrf_field() }}

            <input type="hidden" name="jogador_id" value="{{ isset($jogador) ? $jogador->id : "0" }}">

            <div class="input-field col s8">
                <input type="text" name="nome" maxlength="100" value="{{ old("nome")!="" ? old("nome") : (isset($jogador) ? $jogador->nome : "") }}">
                <label class="{{ $errors->has('nome') ? 'has-error' : ''}}">Nome</label>
            </div>

            <div class="input-field col s2">
                <select name="nivel">
                  <option value="1" {{ old("nivel")!="" && old("nivel") == 1 ? "selected" : (isset($jogador) && $jogador->nivel == "1" ? "selected": "") }}>1</option>
                  <option value="2" {{ old("nivel")!="" && old("nivel") == 2 ? "selected" : (isset($jogador) && $jogador->nivel == "2" ? "selected": "") }}>2</option>
                  <option value="3" {{ old("nivel")!="" && old("nivel") == 3 ? "selected" : (isset($jogador) && $jogador->nivel == "3" ? "selected": "") }}>3</option>
                  <option value="4" {{ old("nivel")!="" && old("nivel") == 4 ? "selected" : (isset($jogador) && $jogador->nivel == "4" ? "selected": "") }}>4</option>
                  <option value="5" {{ old("nivel")!="" && old("nivel") == 5 ? "selected" : (isset($jogador) && $jogador->nivel == "5" ? "selected": "") }}>5</option>
                </select>
                <label>Nível</label>
            </div>

            <div class="input-field col s2">
                <select name="goleiro">
                  <option value="0" {{ old("goleiro")!="" && old("goleiro") == 0 ? "selected" : (isset($jogador) && $jogador->goleiro == "0" ? "selected": "") }}>Não</option>
                  <option value="1" {{ old("goleiro")!="" && old("goleiro") == 1 ? "selected" : (isset($jogador) && $jogador->goleiro == "1" ? "selected": "") }}>Sim</option>
                </select>
                <label>Goleiro?</label>
            </div>

            <div class="col s12">

                <div class="cta">
                    <a href="{{ route("jogadores") }}"
                        class="btn red">
                        Cancelar
                    </a>
                    <button class="btn pink darken-3">
                        Salvar
                    </button>
                </div>

            </div>

        </form>

    </div>

@endsection

@section('scripts')

    <script>

    </script>

@endsection
