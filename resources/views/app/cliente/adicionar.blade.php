@extends('app.layouts.basic')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<link rel="stylesheet" href="{{asset('css/adicionar-cliente.css')}}">

@section('titulo', 'Cliente')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-cliente">
            <h2>Gerenciamento de Clientes</h2>
        </div>

        <div class="informacao-pagina-cliente">
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
            <form class="form-add-cliente" method="post" action="{{ route('app.cliente.adicionar') }}">
                @csrf
                <div class="form-group">
                    <input class="input-nome-cliente" type="text" id="nome" name="nome" placeholder="Nome" required>
                </div>

                <div class="form-group">
                    <input type="text" name="cpf" id="cpf" placeholder="CPF" class="input-cpf-cliente" required>
                </div>

                <div class="form-group">
                    <input type="text" name="email" placeholder="E-mail" class="input-email-cliente" required>
                </div>

                <div class="form-group">
                    <input type="text" name="telefone" id="telefone" placeholder="Telefone"
                           class="input-telefone-cliente" required>
                </div>

                <div class="form-group">
                    <input type="text" name="endereco" placeholder="Endereço" class="input-endereco-cliente" required>
                </div>

                <div class="form-group">
                    <input type="text" name="cep" id="cep" placeholder="CEP" class="input-cep-cliente" required>
                </div>

                <div class="form-group">
                    <input type="text" name="estado" placeholder="UF" class="input-uf-cliente" maxlength="2" required>
                </div>

                <div class="form-group">
                    <input type="text" name="cidade" placeholder="Cidade" class="input-cidade-cliente" required>
                </div>

                <button type="submit" class="button-add">Cadastrar</button>
                <button type="button" onclick="window.location.href='{{ route('app.cliente.index') }}'"
                        class="button-back">Voltar
                </button>
            </form>
        </div>
    </div>

    <script src="{{asset('js/scripts.js')}}"></script>
@endsection
