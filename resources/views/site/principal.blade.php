@extends('app.layouts.basic')

@section('title', 'Principal')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
@endpush

@section('conteudo')
    <div class="conteudo-destaque">
        <div class="esquerda">
            <div class="informacoes">
                <h1>Sistema Super Gestão</h1>
                <p>Software para gestão empresarial ideal para sua empresa.
                <p>
                <div class="chamada">
                    <img src="/img/check.png">
                    <span class="texto-branco">Gestão completa e descomplicada</span>
                </div>
                <div class="chamada">
                    <img src="img/check.png">
                    <span class="texto-branco">Sua empresa na nuvem</span>
                </div>
            </div>

            <div class="video">
                <img src="img/player_video.jpg">
            </div>
        </div>

        <div class="direita">
            <div class="contato-home">
                <h1>Contato</h1>
                <p>Caso tenha qualquer dúvida por favor entre em contato com nossa equipe pelo formulário abaixo.

                @if (session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="form-home" action="{{ route('site.contato') }}" method="post">
                    @csrf
                    <input name="nome" type="text" placeholder="Nome" required class="form-nome">
                    <br>
                    <input name="telefone" type="text" placeholder="Telefone" required class="form-telefone">
                    <br>
                    <input name="email" type="text" placeholder="E-mail" required class="form-email">
                    <br>
                    <select name="motivo_contato_id" required class="select-duvida">
                        <option value="">Qual o motivo do contato?</option>
                        @foreach($motivos_contato as $key => $motivo_contato)
                            <option
                                value="{{$motivo_contato->id}}"
                                {{old('motivo_contato_id') == $motivo_contato->id ? 'selected' : ''}}>
                                {{$motivo_contato->motivo}}</option>
                        @endforeach
                    </select>
                    <br>
                    <textarea name="mensagem" class="form-mensagem" required
                              placeholder="Preencha aqui a sua mensagem"></textarea>
                    <br>
                    <button type="submit" class="btn-enviar">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    @include('app.layouts._partials.footer')
@endsection
