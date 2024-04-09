$(document).ready(function () {
    $.ajax({
        url: '/fornecedor/search',
        method: 'GET',
        success: function (response) {
            // Limpa o conteúdo atual das colunas
            $('.coluna').empty();

            // Adiciona os dados dos fornecedores às colunas correspondentes
            $.each(response, function (index, fornecedor) {
                var nomeHtml = '<div class="item">' + fornecedor.nome + '</div>';
                var siteHtml = '<div class="item">' + fornecedor.site + '</div>';
                var ufHtml = '<div class="item">' + fornecedor.uf + '</div>';
                var emailHtml = '<div class="item">' + fornecedor.email + '</div>';


                $('.coluna:first-child').append(nomeHtml);
                $('.coluna:nth-child(2)').append(siteHtml);
                $('.coluna:last-child').append(ufHtml);
                $('.coluna:last-child').append(emailHtml);
            });
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
});




