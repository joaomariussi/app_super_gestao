$(document).ready(function () {
    // Máscara para CPF
    $('#cpf').mask('000.000.000-00', {reverse: true});

    // Máscara para telefone
    $('#telefone').mask('(00) 00000-0000');

    // Máscara para CEPx
    $('#cep').mask('00000-000');
});


