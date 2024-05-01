@extends('app.layouts.basic')

@section('titulo', $titulo)

<link rel="stylesheet" href="{{ asset('css/contato.css') }}">

@section('conteudo')

    <div class="conteudo-contato">
        <div class="titulo-pagina">
            <h1>Entre em contato conosco</h1>
        </div>

        <div class="informacao-pagina">
            <div class="contato-principal">
                <form class="form-contato" action="{{ route('site.contato') }}" method="post">
                    @csrf
                    <input name="nome" type="text" placeholder="Nome" required class="form-nome">
                    <br>
                    <input name="telefone" type="text" placeholder="Telefone" required class="form-telefone">
                    <br>
                    <input name="email" type="text" placeholder="E-mail" required class="form-email">
                    <br>
                    <select name="motivo_contato_id" required class="form-motivo">
                        <option value="">Qual o motivo do contato?</option>
                        @foreach($motivos_contatos as $key => $motivo_contato)
                            <option
                                    value="{{$motivo_contato->id}}" {{old('motivo_contato_id') == $motivo_contato->id ? 'selected' : ''}}>{{$motivo_contato->motivo}}</option>
                        @endforeach
                    </select>
                    <br>
                    <textarea name="mensagem" class="form-mensagem" required
                              placeholder="Preencha aqui a sua mensagem"></textarea>
                    <br>
                    <button type="submit" class="btn-enviar">Enviar</button>
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

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @include('app.layouts._partials.footer')
@endsection


