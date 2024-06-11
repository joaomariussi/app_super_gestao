@php use Carbon\Carbon; @endphp
@extends('app.layouts.basic')

@section('title', 'Fornecedores')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="{{ asset('css/index-fornecedor.css') }}">
@endpush

@push('head-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
@endpush

@push('scripts')
    <script src="{{ asset('js/table-fornecedor.js') }}"></script>
@endpush

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h2 class="title-h2">Gerenciamento de Fornecedores</h2>
        </div>

        <div class="menu-fornecedor">
            <div class="button-wrapper">
                <button type="submit" class="button-add"
                        onclick="window.location.href = '{{ route('app.fornecedor.adicionar') }}'">Novo Fornecedor
                </button>

                <div class="button-wrapper">
                    <button type="submit" class="button-back"
                            onclick="window.location.href = '{{ route('site.principal') }}'">Voltar
                    </button>
                </div>
            </div>

            <table class="table table-striped" id="table-fornecedores">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Site</th>
                    <th scope="col">UF</th>
                    <th scope="col">Email</th>
                    <th scope="col">Criado em:</th>
                    <th scope="col">Atualizado em:</th>
                    <th scope="col">Opções</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($fornecedores as $fornecedor)
                    <tr>
                        <th scope="row">{{ $fornecedor->id }}</th>
                        <td>{{ $fornecedor->nome }}</td>
                        <td>{{ $fornecedor->site }}</td>
                        <td>{{ $fornecedor->uf }}</td>
                        <td>{{ $fornecedor->email }}</td>
                        <td>{{ Carbon::parse($fornecedor->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td>{{ Carbon::parse($fornecedor->updated_at)->format('d/m/Y H:i:s') }}</td>
                        <td>
                            <form class="form-group" id="form-editar-fornecedor-{{ $fornecedor->id }}"
                                  action="{{ route('app.fornecedor.editar', ['id' => $fornecedor->id]) }}"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="fornecedor_id" value="{{ $fornecedor->id }}">
                                <button type="button" class="button-edit"
                                        onclick="openModalForEdit('{{ $fornecedor->id }}', '{{ $fornecedor->nome }}',
                                         '{{ $fornecedor->site }}', '{{ $fornecedor->uf }}', '{{ $fornecedor->email }}')">
                                    Editar
                                </button>
                                <button type="button" class="button-delete"
                                        onclick="excluirFornecedor('{{ $fornecedor->id }}')">Excluir
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
    <div id="modal-fornecedor" class="modal-fornecedor">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div class="form-group">
                <label for="nome" class="label-nome">Nome</label>
                <input type="text" class="nome-modal" id="editNome" name="nome" placeholder="Nome">
            </div>

            <div class="form-group">
                <label for="site" class="label-site">Site</label>
                <input type="text" class="site-modal" id="editSite" name="site" placeholder="Site">
            </div>

            <div class="form-group">
                <label for="uf" class="label-uf">UF</label>
                <input type="text" class="uf-modal" id="editUF" name="uf" placeholder="UF">
            </div>

            <div class="form-group">
                <label for="email" class="label-email">Email</label>
                <input type="text" class="email-modal" id="editEmail" name="email" placeholder="Email">
            </div>

            <button type="button" class="button-save-modal" onclick="saveChanges()">Salvar</button>
            <button type="button" class="button-close-modal" onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <script>
        function openModalForEdit(id, nome, site, uf, email) {
            document.getElementsByName('fornecedor_id')[0].value = id;
            document.getElementById('editNome').value = nome;
            document.getElementById('editSite').value = site;
            document.getElementById('editUF').value = uf;
            document.getElementById('editEmail').value = email;
            document.getElementById('modal-fornecedor').style.display = 'block';
        }


        function closeModal() {
            document.getElementById('modal-fornecedor').style.display = 'none';
        }

        function saveChanges() {
            var id = document.getElementsByName('fornecedor_id')[0].value;
            var nome = document.getElementById('editNome').value;
            var site = document.getElementById('editSite').value;
            var uf = document.getElementById('editUF').value;
            var email = document.getElementById('editEmail').value;

            $.ajax({
                type: 'POST',
                url: '/fornecedor/editar/' + id,
                data: {
                    id: id,
                    nome: nome,
                    site: site,
                    uf: uf,
                    email: email,
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

        function excluirFornecedor(id) {
            if (confirm('Deseja realmente excluir este fornecedor?')) {
                $.ajax({
                    type: 'POST',
                    url: '/fornecedor/excluir/' + id,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json', // Define o tipo de retorno
                    success: function (response) {
                        window.location.href = '{{ route("app.fornecedor") }}';
                    },
                    error: function (xhr, status, error) {
                        window.location.href = '{{ route("app.fornecedor") }}';
                    }
                });
            }
        }

        $(document).ready(function(){
            // Espera a página carregar completamente
            setTimeout(function(){
                // Verifica se há uma mensagem flash
                if($('.alert').length > 0){
                    // Mostra a mensagem flash
                    $('.alert').slideDown();
                    // Define um tempo para esconder a mensagem flash após 5 segundos
                    setTimeout(function(){
                        $('.alert').slideUp();
                    }, 4000);
                }
            }, 1000); // Aguarda 1 segundo antes de verificar a existência da mensagem flash
        });
    </script>

    @include('app.layouts._partials.footer')
@endsection

