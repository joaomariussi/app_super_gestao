@extends('app.layouts.basic')

@section('title', 'Contato')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/contato.css') }}">
@endpush

@section('conteudo')

    <div class="conteudo-contato">
        <div class="titulo-pagina">
            <h2 class="title-h2">Entre em contato conosco</h2>
        </div>

        <div class="informacao-pagina">
            <div class="contato-principal">
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


