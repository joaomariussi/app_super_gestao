@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Entre em contato conosco</h1>
        </div>

        <div class="informacao-pagina">
            <div class="contato-principal">
                <form action="{{ route('site.contato') }}" method="post">
                    @csrf
                    <input name="nome" type="text" placeholder="Nome" required class="borda-preta">
                    <br>
                    <input name="telefone" type="text" placeholder="Telefone" required class="borda-preta">
                    <br>
                    <input name="email" type="text" placeholder="E-mail" required class="borda-preta">
                    <br>
                    <select name="motivo_contato_id" required class="borda-preta">
                        <option value="">Qual o motivo do contato?</option>
                        @foreach($motivos_contatos as $key => $motivo_contato)
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

                @if($errors->any())
                    <div class="erros">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div class="rodape">
        <div class="redes-sociais">
            <h2>Redes sociais</h2>
            <img src="img/facebook.png">
            <img src="img/linkedin.png">
            <img src="img/youtube.png">
        </div>
        <div class="area-contato">
            <h2>Contato</h2>
            <span>(11) 3333-4444</span>
            <br>
            <span>supergestao@dominio.com.br</span>
        </div>
        <div class="localizacao">
            <h2>Localização</h2>
            <img src="img/mapa.png">
        </div>
    </div>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
@endsection
