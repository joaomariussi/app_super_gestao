@extends('app.layouts.basic')

@section('title', 'Produtos')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="{{ asset('css/index-produto.css') }}">
@endpush

@push('head-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
@endpush

@push('scripts')
    <script src="{{ asset('js/table-produtos.js') }}"></script>
@endpush

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h2 class="title-h2">Gerenciamento de Produtos</h2>
        </div>
        <div class="menu-produto">
            <div class="button-wrapper">
                <button type="submit" class="button-add"
                        onclick="window.location.href = '{{ route('app.produto.adicionar') }}'">Novo Produto
                </button>
                <div class="button-wrapper">
                    <button type="submit" class="button-back"
                            onclick="window.location.href = '{{ route('site.principal') }}'">Voltar
                    </button>
                </div>
            </div>
            <table class="table table-striped" id="table-produtos">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Código</th>
                    <th scope="col">Estoque</th>
                    <th scope="col">Preço de Venda</th>
                    <th scope="col">Opções</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($produtos as $produto)
                    <tr>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->codigo }}</td>
                        <td>{{ $produto->quantidade }} un</td>
                        <td>R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</td>
                        <td>
                            <form class="form-group" id="form-editar-produto-{{ $produto->id }}"
                                  action="{{ route('app.produto.editar', ['id' => $produto->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                <a href="{{ route('app.produto.visualizar', $produto->id) }}" class="button-visualizar">
                                    Visualizar
                                </a>
                                <button type="button" class="button-edit"
                                        onclick="openModalForEdit('{{ $produto->id }}', '{{ $produto->id_fornecedor }}',
                                        '{{ $produto->unidade_id }}',
                                        '{{ $produto->nome }}', '{{ $produto->codigo }}', '{{ $produto->descricao }}',
                                        '{{ $produto->peso }}','{{ number_format($produto->preco_venda, 2, ',', '.') }}',
                                        '{{ $produto->quantidade }}', '{{ $produto->largura }}','{{ $produto->comprimento }}',
                                        '{{ $produto->altura }}')">
                                    Editar
                                </button>

                                <button type="button" class="button-delete"
                                        onclick="excluirProduto('{{ $produto->id }}')">Excluir
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

    <div id="modal-produto" class="modal-produto">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div class="form-group">
                <label for="id_fornecedor" class="fornecedor-label">Fornecedor</label>
                <select name="id_fornecedor" class="select_fornecedor" required>
                    <option value="" disabled selected>Selecione o Fornecedor</option>
                    @foreach ($fornecedores as $fornecedor)
                        <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="unidade_id" class="unidade-label">Unidade de Medida</label>
                <select name="unidade_id" class="select_unidade" required>
                    <option value="" disabled selected>Selecione a Unidade de Medida</option>
                    @foreach ($unidades as $unidade)
                        <option value="{{ $unidade->id }}">{{ $unidade->descricao }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nome" class="nome-label">Nome do Produto</label>
                <input type="text" name="nome" class="nome-modal" placeholder="Nome do Produto" required>
            </div>
            <div class="form-group">
                <label for="codigo" class="codigo-label">Código</label>
                <input type="text" name="codigo" class="codigo-modal" placeholder="Código do Produto" required>
            </div>
            <div class="form-group">
                <label for="descricao" class="descricao-label">Descrição</label>
                <input type="text" name="descricao" class="descricao-modal" placeholder="Descrição" required>
            </div>
            <div class="form-group">
                <label for="peso" class="peso-label">Peso (kg)</label>
                <input type="text" name="peso" class="peso-modal" placeholder="Peso" required>
            </div>
            <div class="form-group">
                <label for="preco_venda" class="preco-venda-label">Preço de Venda</label>
                <input type="text" step="any" name="preco_venda" placeholder="R$ 0,00" id="preco_venda"
                       class="preco-venda-modal" required>
            </div>
            <div class="form-group">
                <label for="quantidade" class="quantidade-label">Quantidade</label>
                <input type="number" step="any" name="quantidade" class="quantidade" placeholder="Quantidade" required>
            </div>
            <div class="form-group">
                <label for="largura" class="largura-label">Largura (cm)</label>
                <input type="text" name="largura" class="largura-modal" placeholder="Largura" required>
            </div>
            <div class="form-group">
                <label for="comprimento" class="comprimento-label">Comprimento (cm)</label>
                <input type="text" name="comprimento" class="comprimento-modal" placeholder="Comprimento" required>
            </div>
            <div class="form-group">
                <label for="altura" class="altura-label">Altura (cm)</label>
                <input type="text" name="altura" class="altura-modal" placeholder="Altura" required>
            </div>
            <button type="button" class="button-save-modal" onclick="saveChanges()">Salvar</button>
            <button type="button" class="button-close-modal" onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <script>
        function openModalForEdit(id, id_fornecedor, unidade_id, nome, codigo, descricao, peso, preco_venda,
                                  quantidade, largura, comprimento, altura) {
            document.getElementsByName('produto_id')[0].value = id;
            document.getElementsByName('id_fornecedor')[0].value = id_fornecedor;
            document.getElementsByName('unidade_id')[0].value = unidade_id;
            document.getElementsByName('nome')[0].value = nome;
            document.getElementsByName('codigo')[0].value = codigo;
            document.getElementsByName('descricao')[0].value = descricao;
            document.getElementsByName('peso')[0].value = peso;
            document.getElementsByName('quantidade')[0].value = quantidade;
            document.getElementsByName('largura')[0].value = largura;
            document.getElementsByName('comprimento')[0].value = comprimento;
            document.getElementsByName('altura')[0].value = altura;
            document.getElementById('modal-produto').style.display = 'block';

            // Formata o valor para duas casas decimais e substitui ponto por vírgula
            document.getElementsByName('preco_venda')[0].value = preco_venda.replace('.', ',');

            // Aplica a máscara ao campo de preço de venda
            $('#preco_venda').maskMoney({
                prefix: 'R$ ',
                allowNegative: false,
                thousands: '.',
                decimal: ',',
                affixesStay: true
            }).maskMoney('mask');
        }

        document.getElementsByName('id_fornecedor')[0].addEventListener('change', function () {
            var select = document.getElementsByName('id_fornecedor')[0];
            if (select.selectedIndex === 0) {
                select.remove(0);
            }
        });

        document.getElementsByName('unidade_id')[0].addEventListener('change', function () {
            var select = document.getElementsByName('unidade_id')[0];
            if (select.selectedIndex === 0) {
                select.remove(0);
            }
        });

        function closeModal() {
            document.getElementById('modal-produto').style.display = 'none';
        }

        function saveChanges() {
            var id = document.getElementsByName('produto_id')[0].value;
            var id_fornecedor = document.getElementsByName('id_fornecedor')[0].value;
            var unidade_id = document.getElementsByName('unidade_id')[0].value;
            var nome = document.getElementsByName('nome')[0].value;
            var codigo = document.getElementsByName('codigo')[0].value;
            var descricao = document.getElementsByName('descricao')[0].value;
            var peso = document.getElementsByName('peso')[0].value;
            var preco_venda = document.getElementsByName('preco_venda')[0].value;
            var quantidade = document.getElementsByName('quantidade')[0].value;
            var largura = document.getElementsByName('largura')[0].value;
            var comprimento = document.getElementsByName('comprimento')[0].value;
            var altura = document.getElementsByName('altura')[0].value;

            $.ajax({
                type: 'POST',
                url: '/produto/editar/' + id,
                data: {
                    id: id,
                    id_fornecedor: id_fornecedor,
                    unidade_id: unidade_id,
                    nome: nome,
                    codigo: codigo,
                    descricao: descricao,
                    peso: peso,
                    preco_venda: preco_venda,
                    quantidade: quantidade,
                    largura: largura,
                    comprimento: comprimento,
                    altura: altura,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response.message);
                    closeModal();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function excluirProduto(id) {
            if (confirm('Deseja realmente excluir este produto?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/produto/excluir/' + id,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (response) {
                        window.location.href = '{{ route("app.produto") }}';
                    },
                    error: function (xhr, status, error) {
                        window.location.href = '{{ route("app.produto") }}';
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
