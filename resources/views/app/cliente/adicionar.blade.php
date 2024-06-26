@extends('app.layouts.basic')

@section('title', 'Novo Cliente')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/adicionar-cliente.css')}}">
@endpush

@push('head-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
@endpush

@push('scripts')
    <script src="{{asset('js/scripts-mascaras.js')}}"></script>
@endpush

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h2 class="title-h2">Gerenciamento de Clientes</h2>
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
                    <div id="cpf-error" class="cpf-existe" style="display: none;"></div>
                </div>

                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="E-mail" class="input-email-cliente" required>
                    <div id="email-error" class="email-existe" style="display: none;"></div>
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

                <div class="button-wrapper">
                    <button type="submit" class="button-add">Cadastrar</button>
                    <a href="{{ route('app.cliente') }}" class="button-back">Voltar</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Aplica a máscara ao campo CPF
            $('#cpf').mask('000.000.000-00', {reverse: true});

            // Configura o evento blur para verificar o CPF
            $('#cpf').on('blur', function () {
                // Obtém o valor do CPF sem os caracteres não numéricos
                let cpf = $(this).cleanVal();
                $.ajax({
                    url: '/verifica-cpf',
                    type: 'POST',
                    data: { cpf: cpf, _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.existe) {
                            // CPF já cadastrado
                            $('#cpf-error').text('CPF já cadastrado').show();
                        } else {
                            // CPF não cadastrado
                            $('#cpf-error').text('').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

    <script>
        // Configura o evento blur para verificar o e-mail
        $(document).ready(function () {
            $('#email').on('blur', function () {
                let email = $(this).val();
                $.ajax({
                    url: '/verifica-email',
                    type: 'POST',
                    data: { email: email, _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.existe) {
                            // E-mail já cadastrado
                            $('#email-error').text('E-mail já cadastrado').show();
                        } else {
                            // E-mail não cadastrado
                            $('#email-error').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
