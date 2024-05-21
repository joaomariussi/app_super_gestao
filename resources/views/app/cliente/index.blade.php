@extends('app.layouts.basic')

<title>Gerenciamento de Clientes</title>

<link rel="stylesheet" href="{{ asset('css/index-cliente.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-cliente">
            <h2>Gerenciamento de Clientes</h2>
        </div>

        <div class="menu-cliente">
            <div class="button-wrapper">
                <a href="{{ route('app.cliente.salvar') }}" class="button-add">Novo Cliente</a>

                <div class="button-wrapper">
                    <a href="{{ route('site.principal') }}" class="button-back">Voltar</a>
                </div>
            </div>

            <table id="clientes" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>CEP</th>
                    <th>Estado</th>
                    <th>Cidade</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ substr($cliente->cpf, 0, 3) }}.{{ substr($cliente->cpf, 3, 3) }}.
                            {{ substr($cliente->cpf, 6, 3) }}-{{ substr($cliente->cpf, -2) }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ substr($cliente->telefone, 0, 2) }} {{ substr($cliente->telefone, 2, 5) }}
                            -{{ substr($cliente->telefone, -4) }}</td>
                        <td>{{ $cliente->endereco }}</td>
                        <td>{{ substr($cliente->cep, 0, 5) }}-{{ substr($cliente->cep, -3) }}</td>
                        <td>{{ $cliente->estado }}</td>
                        <td>{{ $cliente->cidade }}</td>
                        <td>
                            <form class="form-group" id="form-editar-cliente-{{ $cliente->id }}"
                                  action="{{ route('app.cliente.editar', ['id' => $cliente->id]) }}"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
                                <button type="button" class="button-edit"
                                        onclick="openModalForEdit('{{ $cliente->nome }}', '{{ $cliente->cpf }}',
                                        '{{ $cliente->email }}', '{{ $cliente->telefone }}', '{{ $cliente->endereco }}',
                                        '{{ $cliente->cep }}', '{{ $cliente->estado }}', '{{ $cliente->cidade }}')">Editar
                                </button>
                                <button type="button" class="button-delete"
                                        onclick="excluirCliente('{{ $cliente->id }}')">Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-cliente" class="modal-cliente">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div class="form-group">
                <label for="nome" class="label-nome">Nome</label>
                <input type="text" class="nome-modal" id="editNome" name="nome" placeholder="Nome">
            </div>

            <div class="form-group">
                <label for="cpf" class="label-cpf">CPF</label>
                <input type="text" class="cpf-modal" id="editCPF" name="cpf" placeholder="CPF">
            </div>

            <div class="form-group">
                <label for="email" class="label-email">Email</label>
                <input type="text" class="email-modal" id="editEmail" name="email" placeholder="Email">
            </div>

            <div class="form-group">
                <label for="telefone" class="label-telefone">Telefone</label>
                <input type="text" class="telefone-modal" id="editTelefone" name="telefone" placeholder="Telefone">
            </div>

            <div class="form-group">
                <label for="endereco" class="label-endereco">Endereço</label>
                <input type="text" class="endereco-modal" id="editEndereco" name="endereco" placeholder="Endereço">
            </div>

            <div class="form-group">
                <label for="cep" class="label-cep">CEP</label>
                <input type="text" class="cep-modal" id="editCEP" name="cep" placeholder="CEP">
            </div>

            <div class="form-group">
                <label for="estado" class="label-estado">Estado</label>
                <input type="text" class="estado-modal" id="editEstado" maxlength="2" name="estado" placeholder="Estado">
            </div>

            <div class="form-group">
                <label for="cidade" class="label-cidade">Cidade</label>
                <input type="text" class="cidade-modal" id="editCidade" name="cidade" placeholder="Cidade">
            </div>

            <button type="button" class="button-save-modal" onclick="saveChanges()">Salvar</button>
            <button type="button" class="button-close-modal" onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <script>

        function openModalForEdit(nome, cpf, email, telefone, endereco, cep, estado, cidade) {
            document.getElementById('modal-cliente').style.display = 'block';
            document.getElementById('editNome').value = nome;
            document.getElementById('editCPF').value = cpf;
            document.getElementById('editEmail').value = email;
            document.getElementById('editTelefone').value = telefone;
            document.getElementById('editEndereco').value = endereco;
            document.getElementById('editCEP').value = cep;
            document.getElementById('editEstado').value = estado;
            document.getElementById('editCidade').value = cidade;

            // Aplica máscara aos campos dentro do modal
            $('.cpf-modal').mask('000.000.000-00', {reverse: true});
            $('.telefone-modal').mask('(00) 00000-0000');
            $('.cep-modal').mask('00000-000');
        }

        function closeModal() {
            document.getElementById('modal-cliente').style.display = 'none';
        }

        function saveChanges() {
            let id = document.getElementsByName('cliente_id')[0].value;
            let nome = document.getElementById('editNome').value;
            let cpf = document.getElementById('editCPF').value;
            let email = document.getElementById('editEmail').value;
            let telefone = document.getElementById('editTelefone').value;
            let endereco = document.getElementById('editEndereco').value;
            let cep = document.getElementById('editCEP').value;
            let estado = document.getElementById('editEstado').value;
            let cidade = document.getElementById('editCidade').value;

            $.ajax({
                type: 'POST',
                url: '/cliente/editar/' + id,
                data: {
                    id: id,
                    nome: nome,
                    cpf: cpf,
                    email: email,
                    telefone: telefone,
                    endereco: endereco,
                    cep: cep,
                    estado: estado,
                    cidade: cidade,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json', // Define o tipo de retorno
                success: function (response) {
                    console.log(response.message);
                    // Recarrega a página após 1 segundo
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    // Fecha o modal.
                    closeModal();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function excluirCliente(id) {
            if (confirm('Deseja realmente excluir este cliente?')) {
                $.ajax({
                    type: 'POST',
                    url: '/cliente/excluir/' + id,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json', // Define o tipo de retorno
                    success: function (response) {
                        console.log(response.message);
                        // Destroi a instância atual do DataTables
                        reloadDataTable();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }
    </script>

    <script src="{{ asset('js/table-clientes.js') }}"></script>
    <script src="{{asset('js/scripts-mascaras.js')}}"></script>
@endsection
