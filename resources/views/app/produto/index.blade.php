@extends('app.layouts.basic')

<title>Gerenciamento de Produtos</title>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
<link rel="stylesheet" href="{{ asset('css/index-produto.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-produto">
            <h2>Gerenciamento de Produtos</h2>
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
                    <th scope="col">#</th>
                    <th scope="col">Nome do Produto</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Peso (g)</th>
                    <th scope="col">Preço de Venda</th>
                    <th scope="col">Opções</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($produtos as $produto)
                    <tr>
                        <th scope="row">{{ $produto->id }}</th>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->descricao }}</td>
                        <td>{{ $produto->peso }}</td>
                        <td>R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}</td>
                        <td>
                            <form class="form-group" id="form-editar-fornecedor-{{ $produto->id }}"
                                  action="{{ route('app.produto.editar', ['id' => $produto->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                <button type="button" class="button-edit"
                                        onclick="openModalForEdit('{{ $produto->id_fornecedor }}', '{{ $produto->unidade_id }}',
                                        '{{ $produto->nome }}', '{{ $produto->descricao }}', '{{ $produto->peso }}',
                                        '{{ $produto->preco_venda }}','{{ $produto->quantidade }}', '{{ $produto->largura }}',
                                        '{{ $produto->comprimento }}', '{{ $produto->altura }}')">Editar
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
                <label for="nome" class="fornecedor-label"> Fornecedor</label>
                <select name="id_fornecedor" class="select_fornecedor" required>
                    <option value="" disabled selected>Selecione o Fornecedor</option>
                    @foreach ($fornecedores as $fornecedor)
                        <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nome" class="unidade-label"> Unidade de Medida</label>
                <select name="unidade_id" class="select_unidade" required>
                    <option value="" disabled selected>Selecione a Unidade de Medida</option>
                    @foreach ($unidades as $unidade)
                        <option value="{{ $unidade->id }}">{{ $unidade->descricao }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nome" class="nome-label"> Nome do Produto</label>
                <input type="text" name="nome" class="nome-modal" placeholder="Nome do Produto" required>
            </div>
            <div class="form-group">
                <label for="nome" class="descricao-label"> Descrição</label>
                <input type="text" name="descricao" class="descricao-modal" placeholder="Descrição" required>
            </div>
            <div class="form-group">
                <label for="nome" class="peso-label"> Peso (g)</label>
                <input type="text" name="peso" class="peso-modal" placeholder="Peso" required>
            </div>
            <div class="form-group">
                <label for="nome" class="preco-venda-label"> Preço de Venda</label>
                <input type="text" name="preco_venda" class="preco-venda-modal" placeholder="Preço de Venda" required>
            </div>
            <div class="form-group">
                <label for="quantidade" class="quantidade-label"> Quantidade</label>
                <input type="number" step="any" name="quantidade" class="quantidade" placeholder="Quantidade"
                       required>
            </div>
            <div class="form-group">
                <label for="nome" class="largura-label"> Largura (cm)</label>
                <input type="text" name="largura" class="largura-modal" placeholder="Largura" required>
            </div>
            <div class="form-group">
                <label for="nome" class="comprimento-label"> Comprimento (cm)</label>
                <input type="text" name="comprimento" class="comprimento-modal" placeholder="Comprimento" required>
            </div>
            <div class="form-group">
                <label for="nome" class="altura-label"> Altura (cm)</label>
                <input type="text" name="altura" class="altura-modal" placeholder="Altura" required>
            </div>
            <button type="button" class="button-save-modal" onclick="saveChanges()">Salvar</button>
            <button type="button" class="button-close-modal" onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <script>
        function openModalForEdit(id_fornecedor, unidade_id, nome, descricao, peso, preco_venda,
                                  quantidade, largura, comprimento, altura) {

            // Verifica se a opção temporária já foi adicionada ao select de fornecedor
            var selectFornecedor = document.getElementsByName('id_fornecedor')[0];
            var placeholderOptionFornecedor = selectFornecedor.querySelector('[value=""]');
            if (!placeholderOptionFornecedor) {
                placeholderOptionFornecedor = document.createElement('option');
                placeholderOptionFornecedor.value = '';
                placeholderOptionFornecedor.text = 'Selecione o Fornecedor';
                placeholderOptionFornecedor.disabled = true;
                placeholderOptionFornecedor.selected = true;
                selectFornecedor.add(placeholderOptionFornecedor);
            }

            // Verifica se a opção temporária já foi adicionada ao select de unidade de medida
            var selectUnidade = document.getElementsByName('unidade_id')[0];
            var placeholderOptionUnidade = selectUnidade.querySelector('[value=""]');
            if (!placeholderOptionUnidade) {
                placeholderOptionUnidade = document.createElement('option');
                placeholderOptionUnidade.value = '';
                placeholderOptionUnidade.text = 'Selecione a Unidade de Medida';
                placeholderOptionUnidade.disabled = true;
                placeholderOptionUnidade.selected = true;
                selectUnidade.add(placeholderOptionUnidade);
            }

            document.getElementById('modal-produto').style.display = 'block';
            document.getElementsByName('id_fornecedor')[0].value = id_fornecedor;
            document.getElementsByName('unidade_id')[0].value = unidade_id;
            document.getElementsByName('nome')[0].value = nome;
            document.getElementsByName('descricao')[0].value = descricao;
            document.getElementsByName('peso')[0].value = peso;
            document.getElementsByName('preco_venda')[0].value = preco_venda;
            document.getElementsByName('quantidade')[0].value = quantidade;
            document.getElementsByName('largura')[0].value = largura;
            document.getElementsByName('comprimento')[0].value = comprimento;
            document.getElementsByName('altura')[0].value = altura;
        }

        // Remove a opção temporária quando uma opção é selecionada no select de fornecedor
        document.getElementsByName('id_fornecedor')[0].addEventListener('change', function () {
            var select = document.getElementsByName('id_fornecedor')[0];
            if (select.selectedIndex === 0) {
                select.remove(0);
            }
        });

        // Remove a opção temporária quando uma opção é selecionada no select de unidade de medida
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
                    type: 'POST',
                    url: '/produto/excluir/' + id,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response.message);
                        // Verifica se há registros na tabela
                        var table = $('#table-produtos').DataTable();
                        if (table.data().count() === 0) {
                            // Se não houver registros, não recarrega os dados
                            return;
                        }
                        // Recarrega os dados do DataTables
                        table.ajax.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        }
    </script>

    <script src="{{ asset('js/table-produtos.js') }}"></script>
@endsection
