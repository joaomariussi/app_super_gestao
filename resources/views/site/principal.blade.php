@extends('app.layouts.basico')

@section('titulo', $titulo)

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
            <div class="contato">
                <h1>Contato</h1>
                <p>Caso tenha qualquer dúvida por favor entre em contato com nossa equipe pelo formulário abaixo.
                <p>
                <form action="{{ route('site.contato') }}" method="post">
                    @csrf
                    <input name="nome" type="text" placeholder="Nome" required class="borda-preta">
                    <br>
                    <input name="telefone" type="text" placeholder="Telefone" required class="borda-preta">
                    <br>
                    <input name="email" type="text" placeholder="E-mail" required class="borda-preta">
                    <br>
                    <select name="motivo_contato_id" required class="borda-preta">
                        @foreach($motivos_contatos as $key => $motivo_contato)
                            7
                            <option
                                value="{{$motivo_contato->id}}" {{old('motivo_contato_id') == $motivo_contato->id ? 'selected' : ''}}>{{$motivo_contato->motivo}}</option>
                        @endforeach
                    </select>
                    <br>
                    <textarea name="mensagem" class="borda-preta" required
                              placeholder="Preencha aqui a sua mensagem"></textarea>
                    <br>
                    <button type="submit" class="borda-preta">ENVIAR</button>
                </form>
            </div>
        </div>
    </div>
@endsection
