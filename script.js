

$(document).ready(function() {
    // Função para fechar o modal
    function closePopup() {
        $("#modal").hide();
    }

    $("#form-spot").submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        console.log('enviando form')
        var formData = new FormData(this);

        // Adicione as imagens ao FormData corretamente
        var imageInputs = document.querySelectorAll('input[type="file"]');
        for (var i = 0; i < imageInputs.length; i++) {
            var fileInput = imageInputs[i];
            var files = fileInput.files;
            for (var j = 0; j < files.length; j++) {
                formData.append('fotos_divulgacao[]', files[j]);
            }
        }

        $.ajax({
            url: "processar_formulario.php", // Altere para o URL do seu script PHP
            type: "POST",
            data: formData,
            processData: false,  // Evita o processamento automático dos dados
            contentType: false,  // Evita o cabeçalho "Content-Type" padrão
            success: function(response) {
                if (response.success) {
                    // Sucesso - exibir mensagem de sucesso para o usuário
                    $("#modal").show();
                    $("#last-section").show();
                    $("html, body").animate({
                        scrollTop: $("#last-section").offset().top
                    }, 1000);
                    $("#form-spot :input").prop("disabled", true);
                    $("#mensagem").html(response.message); // Exibe a mensagem de sucesso
                    console.log("Formulário enviado com sucesso");
                } else {
                    // Erro - exibir mensagem de erro para o usuário
                    $("#mensagem").html(response.message); // Exibe a mensagem de erro
                    if (response.errors && response.errors.length > 0) {
                        // Se houver detalhes de erros, exiba-os
                        var errorList = "<ul>";
                        for (var i = 0; i < response.errors.length; i++) {
                            errorList += "<li>" + response.errors[i] + "</li>";
                        }
                        errorList += "</ul>";
                        $("#mensagem").append(errorList);
                    }
                }
            },

            error: function(error) {
                console.log(error);
            },
            cache: false, // Desativa o cache do navegador
            contentType: false, // Evita o cabeçalho "Content-Type" padrão
            processData: false // Evita o processamento automático dos dados
        });
    });

    $("#close-modal").click(closePopup);
    $("#ler-rider").click(closePopup);
});
