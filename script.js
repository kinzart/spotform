
document.getElementById("orcamento_final").addEventListener("input", function() {
    var valorInserido = parseInt(this.value);

    if (isNaN(valorInserido)) {
        // Se o valor inserido não for um número, exibe uma mensagem de erro
        this.setCustomValidity("Insira um número válido.");
    } else if (valorInserido < 100 || valorInserido > 2000) {
        // Se o valor inserido estiver fora do intervalo desejado, exibe uma mensagem de erro
        this.setCustomValidity("O valor deve estar entre 100 e 2000.");
    } else {
        // Se o valor estiver dentro do intervalo, não há erro
        this.setCustomValidity("");
    }
});


$(document).ready(function() {
    // Função para fechar o modal
    function closePopup() {
        $("#modal").hide();
    }

    $("#form-spot").submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        var formData = new FormData(this);
        console.log(formData)
        $.ajax({
            url: "processar_formulario.php", // Altere para o URL do seu script PHP
            type: "POST",
            data: formData,
            enctype:'multipart/form-data',
            processData: false,  // Evita o processamento automático dos dados
            contentType: false,  // Evita o cabeçalho "Content-Type" padrão
            success: function(response) {
                $("#modal").show();
                $("#last-section").show(); // Exibe a sessão
                $("html, body").animate({
                    scrollTop: $("#last-section").offset().top // Rola a página até a sessão
                }, 1000); // Tempo de animação em milissegundos
                $("#form-spot :input").prop("disabled", true);
                $("#mensagem").html(response); // Exibe a mensagem de sucesso ou erro
                console.log("formulario enviado")
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $("#close-modal").click(closePopup);
    $("#ler-rider").click(closePopup);
});
