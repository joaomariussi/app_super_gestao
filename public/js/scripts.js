document.addEventListener('DOMContentLoaded', function () {
    var produtosSelecionados = [];

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    function addProdutoToForm(produto) {
        var form = document.querySelector('.form-add-pedido');

        if (form) {
            var inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'produtos[' + produto.id + '][id_produto]';
            inputId.value = produto.id;
            form.appendChild(inputId);

            var inputNome = document.createElement('input');
            inputNome.type = 'hidden';
            inputNome.name = 'produtos[' + produto.id + '][nome_produto]';
            inputNome.value = produto.nome;
            form.appendChild(inputNome);

            var inputCodigo = document.createElement('input');
            inputCodigo.type = 'hidden';
            inputCodigo.name = 'produtos[' + produto.id + '][codigo_produto]';
            inputCodigo.value = produto.codigo;
            form.appendChild(inputCodigo);

            var inputValorProduto = document.createElement('input');
            inputValorProduto.type = 'hidden';
            inputValorProduto.name = 'produtos[' + produto.id + '][valor]';
            inputValorProduto.value = produto.preco_venda;
            form.appendChild(inputValorProduto);

            var inputQuantidade = document.createElement('input');
            inputQuantidade.type = 'hidden';
            inputQuantidade.name = 'produtos[' + produto.id + '][quantidade]';
            inputQuantidade.value = produto.quantidade;
            form.appendChild(inputQuantidade);
        } else {
            console.error("Formulário não encontrado");
        }

        updateValorTotal();
    }

    function openModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'block';

        fetch('/produtos')
            .then(response => response.json())
            .then(data => {
                var select = document.getElementById('produtos-list');
                select.innerHTML = '';

                if (data.length === 0) {
                    document.getElementById('mensagemSemProdutos').style.display = 'block';
                } else {
                    document.getElementById('mensagemSemProdutos').style.display = 'none';
                    data.forEach(function (produto) {
                        var option = document.createElement('option');
                        option.text = produto.nome;
                        option.value = produto.id;
                        option.dataset.preco_venda = produto.preco_venda;
                        option.dataset.codigo = produto.codigo;
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Erro ao obter os produtos:', error);
            });
    }

    function updateProdutoList() {
        var produtosSelecionadosDiv = document.getElementById('produtosSelecionados');
        var tabelaProdutos = document.getElementById('tabelaProdutos').querySelector('tbody');
        tabelaProdutos.innerHTML = '';

        if (produtosSelecionados.length === 0) {
            produtosSelecionadosDiv.style.display = 'none';
        } else {
            produtosSelecionadosDiv.style.display = 'block';
            produtosSelecionados.forEach(function (produto) {
                var produtoRow = document.createElement('tr');

                var nomeTd = document.createElement('td');
                nomeTd.textContent = produto.nome;
                produtoRow.appendChild(nomeTd);

                var codigoTd = document.createElement('td');
                codigoTd.textContent = produto.codigo;
                produtoRow.appendChild(codigoTd);

                var quantidadeTd = document.createElement('td');
                quantidadeTd.textContent = produto.quantidade;
                produtoRow.appendChild(quantidadeTd);

                var precoTd = document.createElement('td');
                var precoTotal = produto.preco_venda * produto.quantidade;
                precoTd.textContent = 'R$ ' + precoTotal.toFixed(2);
                produtoRow.appendChild(precoTd);

                var acoesTd = document.createElement('td');
                var removerButton = document.createElement('button');
                removerButton.textContent = 'Remover';
                removerButton.classList.add('button-remover-produto');
                removerButton.dataset.id = produto.id;
                removerButton.addEventListener('click', function () {
                    var id = this.dataset.id;
                    produtosSelecionados = produtosSelecionados.filter(function (produto) {
                        return produto.id !== id;
                    });
                    updateProdutoList();
                });
                acoesTd.appendChild(removerButton);
                produtoRow.appendChild(acoesTd);

                tabelaProdutos.appendChild(produtoRow);
            });
        }

        updateValorTotal();
    }

    function updateValorTotal() {
        var valorTotalProdutos = 0;

        produtosSelecionados.forEach(function (produto) {
            var quantidade = parseInt(produto.quantidade);
            var preco_venda = parseFloat(produto.preco_venda);

            if (!isNaN(quantidade) && !isNaN(preco_venda)) {
                valorTotalProdutos += preco_venda * quantidade;
            }
        });

        var valorTotalInput = document.getElementById('valor_total');
        if (valorTotalInput) {
            valorTotalInput.value = valorTotalProdutos.toFixed(2);

            // Força a atualização da máscara
            $(valorTotalInput).maskMoney('mask', valorTotalInput.value);
        } else {
            console.error("Elemento 'valor_total' não encontrado");
        }
    }

    var cancelarButton = document.getElementById('cancelar');
    cancelarButton.addEventListener('click', function () {
        closeModal();
    });

    var openModalButton = document.getElementById('openModal');
    openModalButton.addEventListener('click', function () {
        openModal();
    });

    var adicionarButton = document.getElementById('adicionarProduto');
    adicionarButton.addEventListener('click', function () {
        var select = document.getElementById('produtos-list');
        var selectedProductId = select.value;
        var selectedProductName = select.options[select.selectedIndex].text;
        var selectedProductCode = select.options[select.selectedIndex].dataset.codigo;

        var quantidadeInput = document.getElementById('quantidade');
        var quantidade = quantidadeInput.value;

        if (quantidade === '') {
            alert('Selecione uma quantidade para o produto.');
            return;
        }

        var selectedProductPrice = parseFloat(select.options[select.selectedIndex].dataset.preco_venda);

        var existingProductIndex = produtosSelecionados.findIndex(function (produto) {
            return produto.id === selectedProductId;
        });

        if (existingProductIndex !== -1) {
            produtosSelecionados[existingProductIndex].quantidade += parseInt(quantidade);
            updateProdutoList();
            addProdutoToForm(produtosSelecionados[existingProductIndex]);
        } else {
            var produto = {
                id: selectedProductId,
                nome: selectedProductName,
                codigo: selectedProductCode,
                quantidade: parseInt(quantidade),
                preco_venda: selectedProductPrice
            };

            produtosSelecionados.push(produto);
            updateProdutoList();
            addProdutoToForm(produto);
        }

        closeModal();
        quantidadeInput.value = '';
    });

    var form = document.querySelector('.form-add-pedido');
    form.addEventListener('submit', function () {
        produtosSelecionados.forEach(function (produto) {
            addProdutoToForm(produto);
        });
    });
});

// Máscara para o campo Valor Total
$('#valor_total').maskMoney({
    prefix: 'R$ ',
    allowNegative: false,
    thousands: '.',
    decimal: ',',
    affixesStay: true
});

function formatarCpf(cpf) {
    return cpf.substr(0, 3) + '.' + cpf.substr(3, 3) + '.' + cpf.substr(6, 3) + '-' + cpf.substr(9, 2);
}

function formatarCep(cep) {
    return cep.substr(0, 5) + '-' + cep.substr(5, 3);
}

function formatarTelefone(telefone) {
    return '(' + telefone.substr(0, 2) + ') ' + telefone.substr(2, 5) + '-' + telefone.substr(7, 4);
}
