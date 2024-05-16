document.addEventListener('DOMContentLoaded', function () {

    // Armazenar os produtos selecionados
    var produtosSelecionados = [];

    // Função para fechar o modal
    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    // Função para adicionar o produto selecionado ao formulário
    function addProdutoToForm(produto) {
        // Cria um elemento de input oculto para cada atributo do produto
        var form = document.querySelector('.form-add-pedido');

        if (form) {
            var inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'produtos[' + produto.id + '][id_produto]'; // Nome do input usando notação de array
            inputId.value = produto.id;
            form.appendChild(inputId);

            var inputNome = document.createElement('input');
            inputNome.type = 'hidden';
            inputNome.name = 'produtos[' + produto.id + '][nome_produto]'; // Nome do input usando notação de array
            inputNome.value = produto.nome; // Adiciona o nome do produto
            form.appendChild(inputNome);

            var inputValorProduto = document.createElement('input');
            inputValorProduto.type = 'hidden';
            inputValorProduto.name = 'produtos[' + produto.id + '][valor]'; // Nome do input usando notação de array
            inputValorProduto.value = produto.preco_venda; // Aqui estou assumindo que 'preco_venda' é o atributo que armazena o valor do produto
            form.appendChild(inputValorProduto);

            var inputQuantidade = document.createElement('input');
            inputQuantidade.type = 'hidden';
            inputQuantidade.name = 'produtos[' + produto.id + '][quantidade]'; // Nome do input usando notação de array
            inputQuantidade.value = produto.quantidade;
            form.appendChild(inputQuantidade);
        } else {
            console.error("Formulário não encontrado");
        }

        // Atualizar o valor total na view após adicionar o produto ao formulário
        updateValorTotal();
    }

    // Função para abrir o modal
    function openModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'block';

        // Faz uma solicitação AJAX para obter os produtos
        fetch('/produtos')
            .then(response => response.json())
            .then(data => {
                // Limpar o select
                var select = document.getElementById('produtos-list');
                select.innerHTML = '';

                // Preenche o select com os produtos retornados
                data.forEach(function (produto) {
                    var option = document.createElement('option');
                    option.text = produto.nome; // Supondo que 'nome' seja o campo que contém o nome do produto
                    option.value = produto.id; // Supondo que 'id' seja o campo que contém o ID do produto
                    option.dataset.preco_venda = produto.preco_venda; // Adiciona o preço como um atributo personalizado
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao obter os produtos:', error);
            });
    }

    // Função para atualizar a lista de produtos na view
    function updateProdutoList() {
        // Limpar a lista de produtos na view
        var produtosSelecionadosDiv = document.getElementById('produtosSelecionados');
        produtosSelecionadosDiv.innerHTML = '';

        // Verificar se há produtos selecionados
        if (produtosSelecionados.length === 0) {
            // Se não houver produtos, exibir mensagem
            var mensagemDiv = document.createElement('div');
            mensagemDiv.textContent = 'Nenhum produto selecionado';
            produtosSelecionadosDiv.appendChild(mensagemDiv);
        } else {
            // Iterar sobre os produtos selecionados e adicioná-los à lista na view
            produtosSelecionados.forEach(function (produto, index) {
                var produtoDiv = document.createElement('div');
                produtoDiv.textContent = produto.nome;

                // Verificar se é o primeiro produto ou não
                if (index > 0) {
                    produtoDiv.style.marginTop = '5px'; // Adiciona o espaçamento apenas para os produtos além do primeiro
                }

                // Verificar se a quantidade foi selecionada
                if (produto.quantidade > 0) {
                    // Calcular o preço total do produto (preço x quantidade)
                    var precoTotal = produto.preco_venda * produto.quantidade;

                    produtoDiv.textContent += ' - Quantidade: ' + produto.quantidade + ' - Preço Total: R$ ' + precoTotal.toFixed(2);
                } else {
                    // Se a quantidade não foi selecionada, exibir uma mensagem indicando o problema
                    produtoDiv.textContent += ' - Selecione uma quantidade';
                }

                produtosSelecionadosDiv.appendChild(produtoDiv);

                // Adicionar um botão para remover o produto da lista
                var removerButton = document.createElement('button');
                removerButton.textContent = 'Remover';
                removerButton.classList.add('button-remover-produto');
                removerButton.dataset.id = produto.id; // Adiciona o ID do produto como um atributo personalizado
                removerButton.addEventListener('click', function () {
                    // Obter o ID do produto a ser removido
                    var id = this.dataset.id;

                    // Remover o produto da lista de produtos selecionados
                    produtosSelecionados = produtosSelecionados.filter(function (produto) {
                        return produto.id !== id;
                    });

                    // Atualizar a lista de produtos na view
                    updateProdutoList();
                });

                produtoDiv.appendChild(removerButton);
            });
        }

        // Atualizar o valor total na view
        updateValorTotal();
    }

    // Função para atualizar o valor total na view
    function updateValorTotal() {
        var valorTotalProdutos = 0;

        // Calcular o valor total com base nos produtos selecionados
        produtosSelecionados.forEach(function (produto) {
            // Verificar se a quantidade e o preço do produto são números válidos
            var quantidade = parseInt(produto.quantidade);
            var preco_venda = parseFloat(produto.preco_venda);

            if (!isNaN(quantidade) && !isNaN(preco_venda)) {
                valorTotalProdutos += preco_venda * quantidade;
            }
        });

        // Atualizar o valor total dos produtos no input
        var valorTotalInput = document.getElementById('valor_total');
        if (valorTotalInput) {
            valorTotalInput.value = valorTotalProdutos.toFixed(2);
        } else {
            console.error("Elemento 'valor_total' não encontrado");
        }
    }

    // Ouvinte de evento para o botão "Cancelar"
    var cancelarButton = document.getElementById('cancelar');
    cancelarButton.addEventListener('click', function () {
        closeModal();
    });

    // Ouvinte de evento para abrir o modal quando o botão for clicado
    var openModalButton = document.getElementById('openModal');
    openModalButton.addEventListener('click', function () {
        openModal();
    });

    // Ouvinte de evento para o botão "Adicionar"
    var adicionarButton = document.getElementById('adicionarProduto');
    adicionarButton.addEventListener('click', function () {
        // Obter o produto selecionado
        var select = document.getElementById('produtos-list');
        var selectedProductId = select.value;
        var selectedProductName = select.options[select.selectedIndex].text;

        // Obter a quantidade
        var quantidadeInput = document.getElementById('quantidade');
        var quantidade = quantidadeInput.value;

        // Verificar se a quantidade foi selecionada
        if (quantidade === '') {
            alert('Selecione uma quantidade para o produto.');
            return; // Sair da função sem adicionar o produto
        }

        // Obter o preço
        var selectedProductPrice = parseFloat(select.options[select.selectedIndex].dataset.preco_venda);

        // Verificar se o produto já está na lista
        var existingProductIndex = produtosSelecionados.findIndex(function (produto) {
            return produto.id === selectedProductId;
        });

        if (existingProductIndex !== -1) {
            // Se o produto já estiver na lista, adicione apenas a quantidade e atualize o preço total
            produtosSelecionados[existingProductIndex].quantidade += parseInt(quantidade);

            // Atualiza a lista de produtos na view
            updateProdutoList();

            // Adiciona o produto ao formulário
            addProdutoToForm(produtosSelecionados[existingProductIndex]);
        } else {
            // Caso contrário, crie um novo objeto representando o produto selecionado
            var produto = {
                id: selectedProductId,
                nome: selectedProductName,
                quantidade: parseInt(quantidade),
                preco_venda: selectedProductPrice
            };

            // Adicione o produto à lista de produtos selecionados
            produtosSelecionados.push(produto);

            // Atualiza a lista de produtos na view
            updateProdutoList();

            // Adiciona o produto ao formulário
            addProdutoToForm(produto);
        }

        closeModal();

        // Limpa o campo de quantidade para que o usuário possa selecionar outra quantidade
        quantidadeInput.value = '';
    });

    // Ouvinte de evento para o formulário ser submetido
    var form = document.querySelector('.form-add-pedido');
    form.addEventListener('submit', function () {
        produtosSelecionados.forEach(function (produto) {
            addProdutoToForm(produto);
        });
    });
});
